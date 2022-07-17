<?php

namespace App\Http\Controllers;

use App\Helpers\CalendarBuilder;
use App\Helpers\Enums\BankEnum;
use App\Helpers\Enums\StateEnum;
use App\Helpers\ReportBuilder;
use App\Http\Requests\Owner\BlockRequest;
use App\Http\Requests\Owner\ContractRequest;
use App\Models\Commitment;
use App\Models\Property;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class OwnerController extends Controller
{
    private function calendarPage($viewName)
    {
        $firstPropertyID = Auth::user()->properties[0]->ID ? Auth::user()->properties[0]->ID : null;
        $calendar = CalendarBuilder::create($firstPropertyID);
        setlocale(LC_TIME, 'pt_BR');
        $monthId = now()->month;
        $month = ucfirst(now()->localeMonth);
        $year = now()->year;

        return view($viewName)
            ->with('name', Auth::user()->display_name)
            ->with('properties', Auth::user()->properties)
            ->with('calendar', $calendar)
            ->with('month', "$month $year")
            ->with('monthId', "$monthId")
            ->with('yearId', "$year");
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

    public function properties()
    {
        return view('owner-properties')
            ->with('name', Auth::user()->display_name)
            ->with('properties', Auth::user()->properties);
    }

    public function contract($propertyId)
    {
        return view('owner-contract')
            ->with('name', Auth::user()->display_name)
            ->with('property', Property::find($propertyId))
            ->with('banks', BankEnum::bankList)
            ->with('states', StateEnum::stateList);
    }

    public function createContract(ContractRequest $request)
    {
        $property = Property::find($request->property_id);

        $data = [
            'propriedade' => $property,
            'nome_proprietario' => $property->user->display_name,
            'cpf_proprietario' => $property->user->cpf,
            'endereco_proprietario' => $property->user->street . ", " . $property->user->streetNumber,
            'cep_proprietario' => $property->user->cep,
            'cidade_proprietario' => $property->user->city,
            'estado_proprietario' => $property->user->state,
            'telefone_proprietario' => $property->user->phone,
            'nome_cliente' => $request->client ?? '',
            'cpf_cliente' => $request->cpf ?? '',
            'endereco_cliente' => $request->street ?? '',
            'cep_cliente' => $request->cep ?? '',
            'cidade_cliente' => $request->city ?? '',
            'estado_cliente' => $request->state ? StateEnum::stateList[$request->state] : '',
            'telefone_cliente' => $request->phone ?? '',
            'endereco_imovel' => $property->street,
            'cidade_imovel' => $property->city,
            'estado_imovel' => $property->state,
            'dias_locados' => Carbon::createFromFormat('Y-m-d', $request->checkout)->diffInDays(Carbon::createFromFormat('Y-m-d', $request->checkin)),
            'data_checkin' => Carbon::createFromFormat('Y-m-d', $request->checkin),
            'hora_checkin' => $request->checkin_hour,
            'data_checkout' => Carbon::createFromFormat('Y-m-d', $request->checkout),
            'hora_checkout' => $request->checkout_hour,
            'hora_limite_entrada' => $request->entry ?? '',
            'numero_hospedes' => $request->guests ?? 0,
            'valor_pessoa_excedente' => $request->excess ?? 0,
            'valor_locacao' => $request->rent ?? 0,
            'valor_sinal' => $request->sinal ?? 0,
            'taxa_de_limpeza' => $request->clean ?? 0,
            'taxa_caucao' => $request->bail ?? 0,
            'pet' => $request->pet,
            'banco' => $request->bank ? BankEnum::bankList[$request->bank] : '',
            'agencia' => $request->agency ?? '',
            'conta' => $request->account ?? '',
            'responsavel_banco' => $request->responsible ?? '',
            'cpf_banco' => $request->cpf_bank ?? '',
            'pix' => $request->pix ?? ''
        ];

        $pdf = PDF::loadView('template.contract', $data);
        $fileName = "contrato_" . str_replace(' ', '_', strtolower($property->post_title)) . ".pdf";
        return $pdf->download($fileName);
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
