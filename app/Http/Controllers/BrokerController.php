<?php

namespace App\Http\Controllers;

use App\Http\Requests\Broker\RentRequest;
use App\Models\Commitment;
use App\Models\Property;
use App\Models\RentalInformation;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;

class BrokerController extends Controller
{
    private $commitments;

    public function index()
    {
        $firstPropertyID = Property::all()[0]->ID ? Property::all()[0]->ID : null;
        $calendar = $this->createCalendar($firstPropertyID);

        return view('broker')
            ->with('name', Auth::user()->display_name)
            ->with('properties', Property::all())
            ->with('calendar', $calendar);
    }

    private function hasCommitment($date)
    {
        $startMonth = now()->startOfMonth();
        $endMonth = now()->endOfMonth();

        foreach ($this->commitments as $commitment) {
            $initialDate = $startMonth->gte($commitment->checkin) ? $startMonth : new Carbon($commitment->checkin);
            $endDate = $endMonth->lte($commitment->checkout) ? $endMonth : new Carbon($commitment->checkout);

            if ($date->gte($initialDate) && $date->lte($endDate)) {
                $style = $commitment->type == 'blocked' ?
                    "order: 1; background: rgb(253, 216, 222); color: rgb(121, 6, 25);" :
                    "order: 1; background: rgb(199, 245, 217); color: rgb(11, 65, 33);";

                $eventType = $commitment->type == 'blocked' ? 'Bloqueado' : 'Alugado';
                $eventMessage = "<h6><strong>$eventType</strong></h6>
                <p class=`mb-0`>
                    <small>
                        <i class=`fas fa-calendar-alt pr-1`></i>
                        " . $initialDate->format('d/m/Y') . " - " . $endDate->format('d/m/Y') . "
                    </small>
                </p>";

                $title = $initialDate->equalTo($date) ? "$eventType" : "&nbsp;";

                $event = "
                <div 
                    data-mdb-event-key='1'
                    data-mdb-event-order='0'
                    class='event event-1 event-long event-readonly'
                    data-mdb-toggle='tooltip'
                    data-mdb-offset='0,10'
                    data-mdb-html='true'
                    title=''
                    style='$style'
                    data-mdb-original-title='$eventMessage'>
                    $title
                </div>";

                return $event;
            }
        }

        return false;
    }

    public function getCalendarAsJson($propertyId)
    {
        $row = $this->createCalendar($propertyId);
        $data = ['data' => $row];

        return response()->json($data, 200);
    }

    private function createCalendar($propertyId)
    {
        $startMonth = now()->startOfMonth();
        $endMonth = now()->endOfMonth();

        $this->commitments = Commitment::query()
            ->where('property_id', $propertyId)
            ->where(function ($query) use ($startMonth, $endMonth) {
                $query->whereDate('checkin', '>', $startMonth);
                $query->orWhereDate('checkout', '<', $endMonth);
            })
            ->get();

        $weekDay = [
            'Sun' => 0,
            'Mon' => 1,
            'Tue' => 2,
            'Wed' => 3,
            'Thu' => 4,
            'Fri' => 5,
            'Sat' => 6
        ];

        $period = CarbonPeriod::create($startMonth, $endMonth);

        $row = "<tr>";

        foreach ($period->toArray() as $key => $date) {
            if ($key == 0) {
                $dayOfWeek = date('D', $date->timestamp);
                $firstDayMonth = $weekDay[$dayOfWeek];

                for ($j = 0; $j < $firstDayMonth; $j++) {
                    $row .= "<td></td>";
                }
            }

            $class = '';
            if ($key == count($period->toArray()) - 1) {
                $class = "class='last-element'";
            }

            $commitment = $this->hasCommitment($date);

            $row .= "
            <td $class data-date='" . $date->format('d/m/Y') . "'>
                <div class='day-field-wrapper'>
                    <div class='day-field'>" . $date->format('d') . "</div>
                </div>
                <div class='events-wrapper'>
                    $commitment
                </div>
            </td>";

            $dayOfWeek = date('D', $date->timestamp);
            if ($weekDay[$dayOfWeek] == 6) {
                $row .= "</tr><tr>";
            }
        }

        $row .= "</tr>";
        return $row;
    }

    public function rent(RentRequest $request)
    {
        $checkin = $request->checkin;
        $checkout = $request->checkout;

        if (Carbon::createFromFormat('Y-m-d', $checkin) > Carbon::createFromFormat('Y-m-d', $checkout)) {
            return back()->withErrors('Data de Check-in deve ser menor do que Check-out.');
        }

        $hasCommitment = Commitment::query()
            ->where('property_id', $request->propriedade)
            ->where(function ($query) use ($checkin) {
                $query->whereDate('checkin', '<=', $checkin);
                $query->whereDate('checkout', '>=', $checkin);
            })
            ->orWhere(function ($query) use ($checkout) {
                $query->whereDate('checkin', '<=', $checkout);
                $query->whereDate('checkout', '>=', $checkout);
            })
            ->first();

        if ($hasCommitment) {
            return back()->withErrors('Já existe um registro cadastrado nessa data.');
        }

        $fileNameToStore = '';
        if ($request->hasFile('contrato')) {
            $filenameWithExt = $request->file('contrato')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('contrato')->getClientOriginalExtension();

            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $request->file('contrato')->storeAs('public/contracts', $fileNameToStore);
        }

        $commitment = new Commitment([
            'user_id' => Auth::id(),
            'property_id' => $request->propriedade,
            'checkin' => $checkin,
            'checkout' => $checkout,
            'type' => 'rented'
        ]);

        $commitment->save();

        $rentalInformation = new RentalInformation([
            'user_id' => Auth::id(),
            'commitment_id' => $commitment->id,
            'guest_name' => $request->hospede,
            'guest_phone' => $request->telefone,
            'price' => $request->preco,
            'adults' => $request->adultos,
            'kids' => $request->criancas,
            'contract' => $fileNameToStore
        ]);

        $rentalInformation->save();

        return redirect('/broker');
    }
}
