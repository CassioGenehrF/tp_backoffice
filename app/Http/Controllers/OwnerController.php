<?php

namespace App\Http\Controllers;

use App\Helpers\CalendarBuilder;
use App\Helpers\ReportBuilder;
use App\Http\Requests\Owner\BlockRequest;
use App\Models\Commitment;
use Illuminate\Support\Facades\Auth;

class OwnerController extends Controller
{
    private function calendarPage($viewName)
    {
        $firstPropertyID = Auth::user()->properties[0]->ID ? Auth::user()->properties[0]->ID : null;
        $calendar = CalendarBuilder::create($firstPropertyID);

        return view($viewName)
            ->with('name', Auth::user()->display_name)
            ->with('properties', Auth::user()->properties)
            ->with('calendar', $calendar);
    }

    public function index()
    {
        return $this->calendarPage('owner');
    }

    public function unblockPage()
    {
        return $this->calendarPage('owner-unblock');
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

        return view('owner-report')
            ->with('name', Auth::user()->display_name)
            ->with('properties', Auth::user()->properties)
            ->with('report', $report);
    }

    public function getCalendarAsJson($propertyId)
    {
        $row = CalendarBuilder::create($propertyId);
        $data = ['data' => $row];

        return response()->json($data, 200);
    }

    public function block(BlockRequest $request)
    {
        $data = $request->only(['checkin', 'checkout', 'propriedade']);

        return Commitment::block(
            $data['propriedade'],
            $data['checkin'],
            $data['checkout'],
            Auth::id(),
            redirect(route('owner.page'))
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
            redirect(route('owner.unblock_page'))
        );
    }
}
