<?php

namespace App\Http\Controllers;

use App\Helpers\CalendarBuilder;
use App\Helpers\ReportBuilder;
use App\Http\Requests\Broker\RentRequest;
use App\Http\Requests\Owner\BlockRequest;
use App\Models\Commitment;
use App\Models\Property;
use App\Models\PropertyInfo;
use App\Models\RentalInformation;
use App\Models\User;
use Carbon\Carbon;
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

    public function properties()
    {
        return view('admin-properties')
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
