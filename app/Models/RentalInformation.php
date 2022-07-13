<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RentalInformation extends Model
{
    protected $table = 'backoffice_rental_information';

    protected $fillable = [
        'id',
        'user_id',
        'commitment_id',
        'guest_name',
        'guest_phone',
        'price',
        'adults',
        'kids',
        'contract',
        'site_tax',
        'broker_tax',
        'publisher_tax'
    ];

    public $timestamps = false;

    public function commitment(): HasOne
    {
        return $this->hasOne(Commitment::class, 'id', 'commitment_id');
    }

    public static function getReservations($user_id)
    {
        return self::query()
            ->select(
                'backoffice_rental_information.id',
                'backoffice_rental_information.guest_name',
                'backoffice_rental_information.price',
                'backoffice_commitments.checkin',
                'backoffice_commitments.checkout',
                'wp_posts.post_title'
            )
            ->join(
                'backoffice_commitments',
                'backoffice_commitments.id',
                '=',
                'backoffice_rental_information.commitment_id'
            )
            ->join(
                'wp_posts',
                'wp_posts.ID',
                '=',
                'backoffice_commitments.property_id',
            )
            ->where('backoffice_rental_information.user_id', $user_id)
            ->where('type', 'rented')
            ->get();
    }

    public static function getReservationDetails($reservation_id)
    {
        return self::query()
            ->with('commitment.property')
            ->where('backoffice_rental_information.id', $reservation_id)
            ->first();
    }

    public static function reportPropertyInformations($user_id, $propertyId = 0)
    {
        return self::query()
            ->with('commitment.property')
            ->whereHas('commitment', function ($query) {
                $query->whereDate('backoffice_commitments.checkin', '>=', now()->startOfYear());
                $query->whereDate('backoffice_commitments.checkin', '<=', now()->endOfYear());
            })
            ->where('user_id', $user_id)
            ->whereHas('commitment.property', function ($query) use ($propertyId) {
                if ($propertyId) {
                    $query->where('wp_posts.ID', $propertyId);
                }
            })
            ->get();
    }

    public static function reportInformations($user_id)
    {
        return self::query()
            ->with('commitment.property')
            ->whereHas('commitment', function ($query) {
                $query->whereDate('backoffice_commitments.checkin', '>=', now()->startOfYear());
                $query->whereDate('backoffice_commitments.checkin', '<=', now()->endOfYear());
            })
            ->where('backoffice_rental_information.user_id', $user_id)
            ->get();
    }

    public static function reservationDestroy($id)
    {
        $reservation = self::find($id);

        if ($reservation) {
            $commitment = Commitment::find($reservation->commitment_id);

            if ($commitment) {
                $commitment->delete();
            }

            $reservation->delete();
        }
    }
}
