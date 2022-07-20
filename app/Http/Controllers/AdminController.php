<?php

namespace App\Http\Controllers;

use App\Helpers\CalendarBuilder;
use App\Helpers\ReportBuilder;
use App\Http\Requests\Broker\RentRequest;
use App\Http\Requests\Owner\BlockRequest;
use App\Models\Commitment;
use App\Models\Property;
use App\Models\PropertyInfo;
use App\Models\Receipt;
use App\Models\RegionalTax;
use App\Models\RentalInformation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AdminController extends Controller
{
    private function calendarPage($viewName)
    {
        $firstPropertyID = Property::published()->get()[0]->ID ? Property::published()->get()[0]->ID : null;
        $calendar = CalendarBuilder::create($firstPropertyID);
        setlocale(LC_TIME, 'pt_BR');
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
        return $this->calendarPage('admin.admin');
    }

    public function unblockPage()
    {
        return $this->calendarPage('admin.admin-unblock');
    }

    public function receipts()
    {
        $user = User::all();
        $owners = array_filter($user->all(), function ($user) {
            return $user->role == 'editor';
        });

        return view('admin.admin-receipts')
            ->with('name', Auth::user()->display_name)
            ->with('properties', Property::published()->get())
            ->with('users', $owners);
    }

    public function createReceipt(Request $request)
    {
        $fileNameToStore = '';

        if ($request->hasFile('receipt')) {
            $filenameWithExt = $request->file('receipt')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('receipt')->getClientOriginalExtension();

            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $request->file('receipt')->storeAs('public/receipts', $fileNameToStore);
        }

        $receipt = new Receipt([
            'user_id' => $request->owner,
            'month' => Carbon::createFromFormat('Y-m', $request->month)->format('Y-m-d'),
            'value' => $request->value,
            'reason' => $request->reason,
            'receipt' => $fileNameToStore
        ]);

        $receipt->save();

        return redirect(route('admin.receipts'));
    }

    public function reservation(Request $request)
    {
        $id = $request->query('id');

        $rentalInformation = '';
        $commitment = '';

        if ($id) {
            $rentalInformation = RentalInformation::find($id);
            $commitment = Commitment::find($rentalInformation->commitment_id);
        }

        return $this->calendarPage('admin.admin-reservation')
            ->with('rentalInformation', $rentalInformation)
            ->with('commitment', $commitment);
    }

    public function reservations()
    {
        $reservations = RentalInformation::getReservations();

        return view('admin.admin-reservations')
            ->with('properties', Property::all())
            ->with('name', Auth::user()->display_name)
            ->with('reservations', $reservations);
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
        $reservations = RentalInformation::getReservations(false, $propertyId, $month, $year);
        $html = $this->reservationsAsHtml($reservations);
        $data = ['data' => $html];

        return response()->json($data, 200);
    }

    public function reservationDestroy(RentRequest $request)
    {
        RentalInformation::reservationDestroy($request->id);
        return redirect(route('admin.reservations'));
    }

    public function reservationDetails($id)
    {
        $reservation = RentalInformation::getReservationDetails($id);

        return view('admin.admin-reservation-details')
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
        if ($request->rentalInformation) {
            return Commitment::updateRent(
                $request->rentalInformation,
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
                redirect(route('admin.reservations'))
            );
        }

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
            redirect(route('admin.reservation'))
        );
    }

    public function getReport($propertyId)
    {
        $report = ReportBuilder::report(Auth::id(), $propertyId, false, true);
        $data = ['data' => $report];

        return response()->json($data, 200);
    }

    public function report()
    {
        $report = ReportBuilder::report(Auth::id(), 0, false, true);

        return view('admin.admin-report')
            ->with('name', Auth::user()->display_name)
            ->with('properties', Property::published()->get())
            ->with('report', $report);
    }

    public function reportIndication()
    {
        return view('admin.admin-report-indication')
            ->with('name', Auth::user()->display_name)
            ->with('properties', PropertyInfo::all());
    }

    public function reportRegional()
    {
        return view('admin.admin-report-regional')
            ->with('name', Auth::user()->display_name)
            ->with('regional_tax', RegionalTax::all());
    }

    public function properties()
    {
        return view('admin.admin-properties')
            ->with('name', Auth::user()->display_name)
            ->with('properties', Property::all())
            ->with('users', User::all());
    }

    public function getProperty($propertyId)
    {
        $property = PropertyInfo::where('property_id', $propertyId)->first();

        $data = [
            'user_indication_id' => $property->user_indication_id ?? '',
            'contract' => $property->contract ?? ''
        ];

        return response()->json($data, 200);
    }

    public function propertyInfo(RentRequest $request)
    {
        $hasPropertyInfo = PropertyInfo::where('property_id', $request->propriedade)->first();

        $fileNameToStore = '';
        if ($request->hasFile('contrato')) {
            $filenameWithExt = $request->file('contrato')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('contrato')->getClientOriginalExtension();

            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $request->file('contrato')->storeAs('public/contracts', $fileNameToStore);
        }

        if (!$hasPropertyInfo) {
            $propertyInfo = new PropertyInfo([
                'property_id' => $request->propriedade,
                'user_indication_id' => $request->indicacao ?? null,
                'contract' => $fileNameToStore
            ]);

            $propertyInfo->save();
        } else {
            $hasPropertyInfo->update([
                'property_id' => $request->propriedade,
                'user_indication_id' =>  $request->indicacao && $request->indicacao != 0 ?
                    $request->indicacao : null,
                'contract' => empty($fileNameToStore) && $hasPropertyInfo->contract ?
                    $hasPropertyInfo->contract : $fileNameToStore
            ]);
        }

        return redirect(route('admin.properties'));
    }

    public function downloadContractProperty($propertyId)
    {
        $propertyInfo = PropertyInfo::where('property_id', $propertyId)->first();
        $filePath = public_path() . "/storage/contracts/$propertyInfo->contract";
        return Response::download($filePath, $propertyInfo->contract);
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
