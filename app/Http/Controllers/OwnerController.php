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
use App\Models\Demand;
use App\Models\Property;
use App\Models\Receipt;
use App\Models\RentalInformation;
use App\Models\VerifiedProperty;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class OwnerController extends Controller
{
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

    public function propertyDocuments($propertyId)
    {
        $confirmation_code = Str::upper(Str::random(6));

        return view('owner.property-documents')
            ->with('name', Auth::user()->display_name)
            ->with('property', Property::find($propertyId))
            ->with('confirmation_code', $confirmation_code);
    }

    public function sendPropertyDocuments(Request $request)
    {
        $verified = VerifiedProperty::where('property_id', $request->property_id)->first();

        if ($verified)
            $verified->delete();

        $verified = new VerifiedProperty([
            'property_id' => $request->property_id,
            'code' => $request->code
        ]);

        $verified->setUserDocument($request);
        $verified->setUserConfirmation($request);
        $verified->setPropertyDocument($request);
        $verified->setPropertyRelation($request);
        $verified->save();

        return redirect(route('owner.properties'));
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

    public function demands()
    {
        $now = now();

        $demands = Demand::whereRaw('DATE_SUB(created_at, INTERVAL 2 HOUR) < "' . $now . '"')
            ->whereRaw('DATE_SUB(created_at, INTERVAL 2 HOUR) <= DATE_ADD(DATE_SUB(created_at, INTERVAL 2 HOUR), INTERVAL 3 DAY)')
            ->selectRaw('*, DATE_ADD(DATE_SUB(created_at, INTERVAL 2 HOUR), INTERVAL 3 DAY) as expired_at')
            ->get();

        $demands->map(function ($demand, $key) use ($now, $demands) {
            $demands[$key]->checkin = Carbon::createFromFormat('Y-m-d', $demand->checkin)->format('d/m/Y');
            $demands[$key]->checkout = Carbon::createFromFormat('Y-m-d', $demand->checkout)->format('d/m/Y');
        });

        return view('owner.owner-demands')
            ->with('name', Auth::user()->display_name)
            ->with('demands', $demands);
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
