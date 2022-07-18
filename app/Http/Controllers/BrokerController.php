<?php

namespace App\Http\Controllers;

use App\Helpers\CalendarBuilder;
use App\Helpers\ReportBuilder;
use App\Http\Requests\Broker\RentRequest;
use App\Models\Commitment;
use App\Models\Property;
use App\Models\RentalInformation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class BrokerController extends Controller
{
    public function index()
    {
        $firstPropertyID = Property::published()->get()[0]->ID ? Property::published()->get()[0]->ID : null;
        $calendar = CalendarBuilder::create($firstPropertyID);
        setlocale(LC_TIME, 'pt_BR');
        $monthId = now()->month;
        $month = ucfirst(now()->localeMonth);
        $year = now()->year;

        return view('broker.broker')
            ->with('name', Auth::user()->display_name)
            ->with('properties', Property::published()->get())
            ->with('calendar', $calendar)
            ->with('month', "$month $year")
            ->with('monthId', "$monthId")
            ->with('yearId', "$year");
    }

    private function reservationsAsHtml($reservations)
    {
        $html = '';

        foreach ($reservations as $reservation) {
            $html .= "
                <tr>
                    <td> $reservation->post_title </td>
                    <td> $reservation->guest_name </td>
                    <td> R$ " . number_format($reservation->price, 2, ',', '') . " </td>
                    <td> " . Carbon::createFromFormat('Y-m-d', $reservation->checkin)->format('d/m/Y') . ' - ' . Carbon::createFromFormat('Y-m-d', $reservation->checkout)->format('d/m/Y') . "
                    </td>
                    <td>
                        <form action='/admin/reservations/" . $reservation->id . "' method='get'>
                            " . csrf_field() . "
                            <button type='submit' class='btn btn-light'>Visualizar</button>
                        </form>
                        <form action='" . route('admin.reservation_destroy', ['id' => $reservation->id]) . "'
                            method='post'>
                            <input type='hidden' name='_method' value='delete'>
                            " . csrf_field() . "
                            <button type='submit' class='btn btn-danger'>Excluir</button>
                        </form>
                    </td>
                </tr>
            ";
        }

        return $html;
    }

    public function getReservations($propertyId, $month, $year)
    {
        $reservations = RentalInformation::getReservations(Auth::id(), $propertyId, $month, $year);
        $html = $this->reservationsAsHtml($reservations);
        $data = ['data' => $html];

        return response()->json($data, 200);
    }

    public function reservations()
    {
        $reservations = RentalInformation::getReservations(Auth::id());

        return view('broker.broker-reservations')
            ->with('name', Auth::user()->display_name)
            ->with('reservations', $reservations)
            ->with('properties', Property::published()->get());
    }

    public function reservationDestroy(RentRequest $request)
    {
        RentalInformation::reservationDestroy($request->id);
        return redirect(route('broker.reservations'));
    }

    public function reservationDetails($id)
    {
        $reservation = RentalInformation::getReservationDetails($id);

        return view('broker.broker-reservation-details')
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

        return view('broker.broker-report')
            ->with('name', Auth::user()->display_name)
            ->with('report', $report);
    }

    public function getCalendarAsJson($propertyId, $monthId, $yearId)
    {
        setlocale(LC_TIME, 'pt_BR');
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
            str_replace(',', '.', $request->preco),
            $request->hospede,
            $request->telefone,
            $request->adultos,
            $request->criancas,
            $request->clean,
            $request->bail,
            $request->hasFile('contrato'),
            $request->file('contrato'),
            Auth::id(),
            redirect(route('broker.page'))
        );
    }
}
