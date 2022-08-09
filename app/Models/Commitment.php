<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class Commitment extends Model
{
    protected $table = 'backoffice_commitments';

    protected $fillable = [
        'id',
        'user_id',
        'property_id',
        'checkin',
        'checkout',
        'type'
    ];

    public $timestamps = false;

    public function property(): HasOne
    {
        return $this->hasOne(Property::class, 'ID', 'property_id');
    }

    public static function between($propertyId, $startDate, $endDate)
    {
        return self::query()
            ->where('property_id', $propertyId)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereDate('checkin', '>', $startDate);
                $query->orWhereDate('checkout', '<', $endDate);
            })
            ->get();
    }

    public static function hasCommitmentBetween($propertyId, $checkin, $checkout)
    {
        return self::query()
            ->where('property_id', $propertyId)
            ->where(function ($query) use ($checkin, $checkout) {
                $query->where(function ($query) use ($checkin) {
                    $query->whereDate('checkin', '<=', $checkin);
                    $query->whereDate('checkout', '>=', $checkin);
                });

                $query->orWhere(function ($query) use ($checkout) {
                    $query->whereDate('checkin', '<=', $checkout);
                    $query->whereDate('checkout', '>=', $checkout);
                });
            })
            ->first();
    }

    public static function hasCommitmentEquals($propertyId, $checkin, $checkout, $user_id = null)
    {
        return self::query()
            ->where(function ($query) use ($user_id) {
                if ($user_id) {
                    $query->where('user_id', $user_id);
                }
            })
            ->where('property_id', $propertyId)
            ->where('type', 'blocked')
            ->whereDate('checkin', '=', $checkin)
            ->whereDate('checkout', '=', $checkout)
            ->first();
    }

    public static function block($propertyId, $checkin, $checkout, $user_id, $callback)
    {
        if ($propertyId == '') {
            return back()->withErrors('Você não possui uma propriedade selecionada.');
        }

        if (
            Carbon::createFromFormat('Y-m-d', $checkin) >
            Carbon::createFromFormat('Y-m-d', $checkout)
        ) {
            return back()->withErrors('Data de Check-in deve ser menor do que Check-out.');
        }

        $hasCommitment = self::hasCommitmentBetween(
            $propertyId,
            $checkin,
            $checkout
        );

        if ($hasCommitment) {
            return back()->withErrors('Já existe um registro cadastrado nessa data.');
        }

        $commitment = new self([
            'user_id' => $user_id,
            'property_id' => $propertyId,
            'checkin' => $checkin,
            'checkout' => $checkout,
            'type' => 'blocked'
        ]);

        $commitment->save();

        return $callback;
    }

    public static function unblock($propertyId, $checkin, $checkout, $user_id, $callback)
    {
        if ($propertyId == '') {
            return back()->withErrors('Você não possui uma propriedade selecionada.');
        }
        
        if (
            Carbon::createFromFormat('Y-m-d', $checkin) >
            Carbon::createFromFormat('Y-m-d', $checkout)
        ) {
            return back()->withErrors('Data de Check-in deve ser menor do que Check-out.');
        }

        $commitment = self::hasCommitmentEquals(
            $propertyId,
            $checkin,
            $checkout,
            $user_id
        );

        if (!$commitment) {
            return back()->withErrors('Nenhum registro encontrado nessas datas.');
        }

        $commitment->delete();

        return $callback;
    }

    public static function updateRent(
        $rentalInformationId,
        $propertyId,
        $checkin,
        $checkout,
        $preco,
        $hospede,
        $telefone,
        $adultos,
        $criancas,
        $clean,
        $bail,
        $hasFile,
        $contrato,
        $user_id,
        $callback
    ) {
        $rentalInformation = RentalInformation::find($rentalInformationId);
        $fileNameToStore = '';

        if ($hasFile) {
            $filenameWithExt = $contrato->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $contrato->getClientOriginalExtension();

            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $contrato->storeAs('public/contracts', $fileNameToStore);
        }

        $property = Property::find($propertyId);

        $commitment = Commitment::find($rentalInformation->commitment_id);

        $commitment->update([
            'user_id' => $user_id,
            'property_id' => $propertyId,
            'checkin' => $checkin,
            'checkout' => $checkout
        ]);

        $commitment->save();

        $tax = $preco * 10 / 100;

        $broker_tax = 0;

        if (Auth::user()->role != 'administrator') {
            $broker_tax = $tax * 30 / 100;
        }

        $publisher_tax = 0;

        if ($property->propertyInfo && $property->propertyInfo->user_indication_id) {
            $publisher_tax = $property->propertyInfo->user_indication_id == $user_id ? 0 : $tax * 30 / 100;
        }

        $regional_tax = $tax * 10 / 100;

        $site_tax = $tax - $publisher_tax - $broker_tax - $regional_tax;

        $rentalInformation->update([
            'user_id' => $user_id,
            'commitment_id' => $commitment->id,
            'guest_name' => $hospede,
            'guest_phone' => $telefone,
            'price' => $preco,
            'adults' => $adultos,
            'kids' => $criancas,
            'contract' => $rentalInformation->contract && !$fileNameToStore ? $rentalInformation->contract : $fileNameToStore,
            'site_tax' => $site_tax,
            'broker_tax' => $broker_tax,
            'publisher_tax' => $publisher_tax,
            'regional_tax' => $regional_tax,
            'clean_tax' => $clean,
            'bail_tax' => $bail
        ]);

        $rentalInformation->save();

        return $callback;
    }

    public static function rent(
        $propertyId,
        $checkin,
        $checkout,
        $preco,
        $hospede,
        $telefone,
        $adultos,
        $criancas,
        $clean,
        $bail,
        $hasFile,
        $contrato,
        $user_id,
        $callback
    ) {
        if (
            Carbon::createFromFormat('Y-m-d', $checkin) >
            Carbon::createFromFormat('Y-m-d', $checkout)
        ) {
            return back()->withErrors('Data de Check-in deve ser menor do que Check-out.');
        }

        $hasCommitment = self::hasCommitmentBetween(
            $propertyId,
            $checkin,
            $checkout
        );

        if ($hasCommitment) {
            return back()->withErrors('Já existe um registro cadastrado nessa data.');
        }

        $fileNameToStore = '';

        if ($hasFile) {
            $filenameWithExt = $contrato->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $contrato->getClientOriginalExtension();

            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $contrato->storeAs('public/contracts', $fileNameToStore);
        }

        $property = Property::find($propertyId);

        $commitment = new Commitment([
            'user_id' => $user_id,
            'property_id' => $propertyId,
            'checkin' => $checkin,
            'checkout' => $checkout,
            'type' => 'rented'
        ]);

        $commitment->save();

        $tax = $preco * 10 / 100;

        $broker_tax = 0;
        if (Auth::user()->role != 'administrator') {
            $broker_tax = $tax * 30 / 100;
        }

        $publisher_tax = 0;
        if ($property->propertyInfo && $property->propertyInfo->user_indication_id) {
            $publisher_tax = $property->propertyInfo->user_indication_id == $user_id ? 0 : $tax * 30 / 100;
        }

        $regional_tax = $tax * 10 / 100;

        $site_tax = $tax - $publisher_tax - $broker_tax - $regional_tax;

        $rentalInformation = new RentalInformation([
            'user_id' => $user_id,
            'commitment_id' => $commitment->id,
            'guest_name' => $hospede,
            'guest_phone' => $telefone,
            'price' => $preco,
            'adults' => $adultos,
            'kids' => $criancas,
            'contract' => $fileNameToStore,
            'site_tax' => $site_tax,
            'broker_tax' => $broker_tax,
            'publisher_tax' => $publisher_tax,
            'regional_tax' => $regional_tax,
            'clean_tax' => $clean,
            'bail_tax' => $bail
        ]);

        $rentalInformation->save();

        return $callback;
    }
}
