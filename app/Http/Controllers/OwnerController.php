<?php

namespace App\Http\Controllers;

use App\Helpers\CalendarBuilder;
use App\Helpers\Enums\BankEnum;
use App\Helpers\Enums\StateEnum;
use App\Helpers\ReportBuilder;
use App\Http\Requests\Broker\RentRequest;
use App\Http\Requests\Owner\BlockRequest;
use App\Http\Requests\Owner\ContractRequest;
use App\Models\Commitment;
use App\Models\Property;
use App\Models\Receipt;
use App\Models\RentalInformation;
use App\Models\VerifiedProperty;
use App\Models\VerifiedUser;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class OwnerController extends Controller
{
    private $extensions = ['png', 'jpg', 'jpeg', 'jfif'];

    private function calendarPage($viewName)
    {
        $properties = Auth::user()->properties->reject(function ($property) {
            return !($property->verified && $property->verified->verified);
        });

        $firstPropertyID = count($properties) > 0 ? $properties[0]->ID : null;
        $calendar = CalendarBuilder::create($firstPropertyID);
        setlocale(LC_TIME, 'pt_BR');
        $monthId = now()->month;
        $month = ucfirst(now()->localeMonth);
        $year = now()->year;

        return view($viewName)
            ->with('name', Auth::user()->display_name)
            ->with('properties', $properties)
            ->with('calendar', $calendar)
            ->with('month', "$month $year")
            ->with('monthId', "$monthId")
            ->with('yearId', "$year");
    }

    public function notVerified()
    {
        $verified = VerifiedUser::where('user_id', Auth::id())
            ->where('verified', 1)
            ->first();

        if ($verified)
            return redirect('/');

        return view('owner.not-verified');
    }

    public function documents()
    {
        $confirmation_code = Str::upper(Str::random(6));

        return view('owner.send-documents')
            ->with('name', Auth::user()->display_name)
            ->with('confirmation_code', $confirmation_code);
    }

    public function documentsRefuse()
    {
        return view('owner.refuse-documents')
            ->with('name', Auth::user()->display_name)
            ->with('reason', Auth::user()->verified->reason);
    }

    public function sendDocuments(Request $request)
    {
        $fileNameDocument = '';
        $fileNameConfirmation = '';

        if ($request->hasFile('document') && $request->hasFile('confirmation')) {
            $document = $request->file('document');
            $confirmation = $request->file('confirmation');

            if (
                !in_array($document->getClientOriginalExtension(), $this->extensions) ||
                !in_array($confirmation->getClientOriginalExtension(), $this->extensions)
            )
                return back()->withErrors([
                    'document' => 'O Documento informado n??o ?? de um tipo v??lido.',
                ]);

            $documentWithExt = $document->getClientOriginalName();
            $confirmationWithExt = $confirmation->getClientOriginalName();

            $fileDocument = pathinfo($documentWithExt, PATHINFO_FILENAME);
            $fileConfirmation = pathinfo($confirmationWithExt, PATHINFO_FILENAME);

            $fileNameDocument = $fileDocument . '_' . time() . '.' . $document->getClientOriginalExtension();
            $fileNameConfirmation = $fileConfirmation . '_' . time() . '.' . $confirmation->getClientOriginalExtension();

            $document->storeAs('public/documents', $fileNameDocument);
            $confirmation->storeAs('public/documents', $fileNameConfirmation);
        }

        $verified = VerifiedUser::where('user_id', Auth::id())->first();

        if ($verified)
            $verified->delete();

        $verified = new VerifiedUser([
            'user_id' => Auth::id(),
            'document' => $fileNameDocument,
            'confirmation' => $fileNameConfirmation,
            'code' => $request->code
        ]);

        $verified->save();

        return redirect('/');
    }

    public function propertyDocuments($propertyId)
    {
        return view('owner.property-documents')
            ->with('name', Auth::user()->display_name)
            ->with('property', Property::find($propertyId));
    }

    public function sendPropertyDocuments(Request $request)
    {
        $fileNameDocument = '';
        $fileNameRelation = '';

        $document = $request->file('document');

        if (!in_array($document->getClientOriginalExtension(), $this->extensions))
            return back()->withErrors([
                'document' => 'O Documento informado n??o ?? de um tipo v??lido.',
            ]);

        $documentWithExt = $document->getClientOriginalName();
        $fileDocument = pathinfo($documentWithExt, PATHINFO_FILENAME);
        $fileNameDocument = $fileDocument . '_' . time() . '.' . $document->getClientOriginalExtension();

        $document->storeAs('public/property/documents', $fileNameDocument);

        if ($request->hasFile('relation')) {
            $relation = $request->file('relation');

            if (!in_array($relation->getClientOriginalExtension(), $this->extensions))
                return back()->withErrors([
                    'relation' => 'O Comprovante de V??nculo informado n??o ?? de um tipo v??lido.',
                ]);

            $confirmationWithExt = $relation->getClientOriginalName();
            $fileConfirmation = pathinfo($confirmationWithExt, PATHINFO_FILENAME);
            $fileNameRelation = $fileConfirmation . '_' . time() . '.' . $relation->getClientOriginalExtension();

            $relation->storeAs('public/property/documents', $fileNameRelation);
        }

        $verified = VerifiedProperty::where('property_id', $request->property_id)->first();

        if ($verified)
            $verified->delete();

        $verified = new VerifiedProperty([
            'property_id' => $request->property_id,
            'document' => $fileNameDocument,
            'relation' => $fileNameRelation
        ]);

        $verified->save();

        return redirect('/');
    }

    public function index()
    {
        return $this->calendarPage('owner.owner');
    }

    public function unblockPage()
    {
        return $this->calendarPage('owner.owner-unblock');
    }

    private function reservationsAsHtml($reservations)
    {
        $html = '';

        foreach ($reservations as $reservation) {
            $delete = "";

            $delete = !(Auth::id() == $reservation->user_id) ? '' :
                "<form action='" . route('admin.reservation_destroy', ['id' => $reservation->id]) . "'
                    method='post'>
                    <input type='hidden' name='_method' value='delete'>
                    " . csrf_field() . "
                    <button type='submit' class='btn btn-danger'>Excluir</button>
                </form>";

            $color = (Auth::id() == $reservation->post_author) ? '' :
                'style="background-color: #ff9900;"';

            $html .= "
                <tr $color>
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
                        $delete
                    </td>
                </tr>
            ";
        }

        return $html;
    }

    public function getReservations($propertyId, $month, $year)
    {
        $reservations = RentalInformation::getReservations(Auth::id(), $propertyId, $month, $year, true);
        $html = $this->reservationsAsHtml($reservations);
        $data = ['data' => $html];

        return response()->json($data, 200);
    }

    public function reservations()
    {
        $reservations = RentalInformation::getReservations(Auth::id(), false, false, false, true);

        return view('owner.owner-reservations')
            ->with('name', Auth::user()->display_name)
            ->with('reservations', $reservations)
            ->with('properties', Property::published()->get());
    }

    public function reservationDestroy(RentRequest $request)
    {
        RentalInformation::reservationDestroy($request->id);
        return redirect(route('owner.reservations'));
    }

    public function reservationDetails($id)
    {
        $reservation = RentalInformation::getReservationDetails($id);

        return view('owner.owner-reservation-details')
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

    public function downloadReceipt($id)
    {
        $receipt = Receipt::find($id);
        $filePath = public_path() . "/storage/receipts/$receipt->receipt";
        return Response::download($filePath, $receipt->receipt);
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

        return view('owner.owner-report')
            ->with('name', Auth::user()->display_name)
            ->with('properties', Auth::user()->properties)
            ->with('report', $report);
    }

    public function properties()
    {
        return view('owner.owner-properties')
            ->with('name', Auth::user()->display_name)
            ->with('properties', Auth::user()->properties);
    }

    public function contract($propertyId)
    {
        return view('owner.owner-contract')
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
