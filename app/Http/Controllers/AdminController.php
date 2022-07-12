<?php

namespace App\Http\Controllers;

use App\Helpers\CalendarBuilder;
use App\Helpers\ReportBuilder;
use App\Http\Requests\Broker\RentRequest;
use App\Http\Requests\Owner\BlockRequest;
use App\Models\Commitment;
use App\Models\Property;
use App\Models\RentalInformation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AdminController extends Controller
{
    private function calendarPage($viewName)
    {
        $firstPropertyID = Property::published()->get()[0]->ID ? Property::published()->get()[0]->ID : null;
        $calendar = CalendarBuilder::create($firstPropertyID);
        setlocale(LC_TIME, 'ptb');
        $monthId = now()->month;
        $month = ucfirst(now()->localeMonth);
        $year = now()->year;

        return view($viewName)
            ->with('name', Auth::user()->display_name)
            ->with('properties', Property::published()->get())
            ->with('calendar', $calendar)
            ->with('month', "$month $year")
            ->with('monthId', "$monthId")
            ->with('yearId', "$year");
    }

    public function index()
    {
        return $this->calendarPage('admin');
    }

    public function unblockPage()
    {
        return $this->calendarPage('admin-unblock');
    }

    public function reservation()
    {
        return $this->calendarPage('admin-reservation');
    }

    public function reservations()
    {
        $reservations = RentalInformation::getReservations(Auth::id());

        return view('admin-reservations')
            ->with('name', Auth::user()->display_name)
            ->with('reservations', $reservations);
    }

    public function reservationDestroy(RentRequest $request)
    {
        RentalInformation::reservationDestroy($request->id);
        return redirect(route('admin.reservations'));
    }

    public function reservationDetails($id)
    {
        $reservation = RentalInformation::getReservationDetails($id);

        return view('admin-reservation-details')
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

    public function getCalendarAsJson($propertyId, $monthId, $yearId)
    {
        setlocale(LC_TIME, 'ptb');
        $date = Carbon::createFromDate($yearId, $monthId);
        $month = ucfirst($date->localeMonth);

        $row = CalendarBuilder::create($propertyId, $monthId, $yearId);

        $data = [
            'data' => $row,
            'month' => "$month $date->year"
        ];

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
            redirect(route('admin.reservation'))
        );
    }

    public function getReport($propertyId)
    {
        $report = ReportBuilder::report(Auth::id(), $propertyId);
        $data = ['data' => $report];

        return response()->json($data, 200);
    }

    public function report()
    {
        $report = ReportBuilder::report(Auth::id());

        return view('admin-report')
            ->with('name', Auth::user()->display_name)
            ->with('properties', Property::published()->get())
            ->with('report', $report);
    }

    public function block(BlockRequest $request)
    {
        $data = $request->only(['checkin', 'checkout', 'propriedade']);

        return Commitment::block(
            $data['propriedade'],
            $data['checkin'],
            $data['checkout'],
            Auth::id(),
            redirect(route('admin.page'))
        );
    }

    public function unblock(BlockRequest $request)
    {
        $data = $request->only(['checkin', 'checkout', 'propriedade']);

        return Commitment::unblock(
            $data['propriedade'],
            $data['checkin'],
            $data['checkout'],
            Auth::id(),
            redirect(route('admin.unblock_page'))
        );
    }
}
