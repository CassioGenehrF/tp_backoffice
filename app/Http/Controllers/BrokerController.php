<?php

namespace App\Http\Controllers;

use App\Helpers\CalendarBuilder;
use App\Helpers\ReportBuilder;
use App\Http\Requests\Broker\RentRequest;
use App\Models\Commitment;
use App\Models\Property;
use App\Models\RentalInformation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class BrokerController extends Controller
{

    public function index()
    {
        $firstPropertyID = Property::published()->get()[0]->ID ? Property::published()->get()[0]->ID : null;
        $calendar = CalendarBuilder::create($firstPropertyID);

        return view('broker')
            ->with('name', Auth::user()->display_name)
            ->with('properties', Property::published()->get())
            ->with('calendar', $calendar);
    }

    public function reservations()
    {
        $reservations = RentalInformation::getReservations(Auth::id());

        return view('reservations')
            ->with('name', Auth::user()->display_name)
            ->with('reservations', $reservations);
    }

    public function reservationDestroy(RentRequest $request)
    {
        RentalInformation::reservationDestroy($request->id);
        return redirect(route('broker.reservations'));
    }

    public function reservationDetails($id)
    {
        $reservation = RentalInformation::getReservationDetails($id);

        return view('reservation-details')
            ->with('name', Auth::user()->display_name)
            ->with('reservation', $reservation)
            ->with('user', Auth::user());
    }

    public function downloadContract($id)
    {
        $reservation = RentalInformation::find($id);
        $filePath = public_path() . "/storage/contracts/$reservation->contract";
        return Response::download($filePath, $reservation->contract);
    }

    public function report()
    {
        $report = ReportBuilder::report(Auth::id(), 0, true);

        return view('broker-report')
            ->with('name', Auth::user()->display_name)
            ->with('report', $report);
    }

    public function getCalendarAsJson($propertyId)
    {
        $row = CalendarBuilder::create($propertyId);
        $data = ['data' => $row];

        return response()->json($data, 200);
    }

    public function rent(RentRequest $request)
    {
        return Commitment::rent(
            $request->propriedade,
            $request->checkin,
            $request->checkout,
            $request->preco,
            $request->hospede,
            $request->telefone,
            $request->adultos,
            $request->criancas,
            $request->hasFile('contrato'),
            $request->file('contrato'),
            Auth::id(),
            redirect(route('broker.reservation'))
        );
    }
}
