<?php

namespace App\Http\Controllers;

use App\Helpers\CalendarBuilder;
use App\Helpers\Enums\BankEnum;
use App\Helpers\Enums\StateEnum;
use App\Helpers\ReportBuilder;
use App\Http\Requests\Broker\RentRequest;
use App\Http\Requests\Owner\BlockRequest;
use App\Http\Requests\Owner\ContractRequest;
use App\Models\Client;
use App\Models\Commitment;
use App\Models\ContractClient;
use App\Models\ContractDeposit;
use App\Models\Demand;
use App\Models\Indication;
use App\Models\Property;
use App\Models\PropertyValue;
use App\Models\Receipt;
use App\Models\RentalInformation;
use App\Models\VerifiedProperty;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
            ->with('properties', Auth::user()->properties);
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

    public function propertiesContracts()
    {
        return view('owner.owner-properties-contracts')
            ->with('name', Auth::user()->display_name)
            ->with('contracts', ContractClient::all());
    }

    public function contract($propertyId)
    {
        return view('owner.owner-contract')
            ->with('name', Auth::user()->display_name)
            ->with('property', Property::find($propertyId))
            ->with('banks', BankEnum::bankList)
            ->with('states', StateEnum::stateList);
    }

    public function value($propertyId)
    {
        return view('owner.owner-value')
            ->with('name', Auth::user()->display_name)
            ->with('property', Property::find($propertyId))
            ->with('value', PropertyValue::where('property_id', $propertyId)->first());
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

    public function saveValue(Request $request)
    {
        $data = $request->all();
        $data['monday'] = $data['monday'] ?? 0;
        $data['tuesday'] = $data['tuesday'] ?? 0;
        $data['wednesday'] = $data['wednesday'] ?? 0;
        $data['thursday'] = $data['thursday'] ?? 0;
        $data['friday'] = $data['friday'] ?? 0;

        PropertyValue::updateOrCreate([
            'property_id' => $data['property_id']
        ], $data);

        return view('owner.owner-properties')
            ->with('name', Auth::user()->display_name)
            ->with('properties', Auth::user()->properties);
    }

    private function calculateRentedDays($checkin, $checkout)
    {
        try {
            return Carbon::createFromFormat('Y-m-d', $checkout)
                ->diffInDays(Carbon::createFromFormat('Y-m-d', $checkin));
        } catch (\Exception $e) {
            Log::error("$checkin - $checkout");
            Log::error($e->getMessage());
            return 0;
        }
    }

    public function createContract(ContractRequest $request)
    {
        $property = Property::find($request->property_id);

        $checkin_hour = substr($request->checkin_hour, 0, strpos($request->checkin_hour, ':'));
        $checkin_minute = substr($request->checkin_hour, strpos($request->checkin_hour, ':') + 1);
        $checkin_limit_hour = substr($request->entry, 0, strpos($request->entry, ':'));
        $checkin_limit_minute = substr($request->entry, strpos($request->entry, ':') + 1);
        $checkout_hour = substr($request->checkout_hour, 0, strpos($request->checkout_hour, ':'));
        $checkout_minute = substr($request->checkout_hour, strpos($request->checkout_hour, ':') + 1);

        $contractDeposit = ContractDeposit::create([
            'bank' => $request->bank ? BankEnum::bankList[$request->bank] : null,
            'agency' => $request->agency ?? null,
            'account' => $request->account ?? null,
            'responsible' => $request->responsible ?? null,
            'responsible_cpf' => $request->cpf_bank ?? null,
            'pix' => $request->pix ?? null
        ]);

        ContractClient::create([
            'property_id' => $property->ID,
            'owner_name' => "{$property->user->firstName} {$property->user->lastName}",
            'owner_cpf' => $property->user->cpf,
            'owner_address' => $property->user->street . ", " . $property->user->streetNumber,
            'owner_cep' => $property->user->cep,
            'owner_city' => $property->user->city,
            'owner_uf' => $property->user->state,
            'owner_phone_number' => $property->user->phone,
            'client_name' => $request->client ?? null,
            'client_cpf' => $request->cpf ?? null,
            'client_address' => $request->street ?? null,
            'client_cep' => $request->cep ?? null,
            'client_city' => $request->city ?? null,
            'client_uf' => $request->state ? StateEnum::stateList[$request->state] : null,
            'client_phone_number' => $request->phone ?? null,
            'property_address' => $property->street,
            'property_city' => $property->city,
            'property_uf' => $property->state,
            'rented_days' => $this->calculateRentedDays($request->checkin, $request->checkout),
            'checkin_date' => Carbon::createFromFormat('Y-m-d', $request->checkin),
            'checkin_hour' => Carbon::createFromFormat('Y-m-d', $request->checkin)->setHour($checkin_hour)->setMinute($checkin_minute),
            'checkin_limit_hour' => Carbon::createFromFormat('Y-m-d', $request->checkin)->setHour($checkin_limit_hour)->setMinute($checkin_limit_minute),
            'checkout_date' => Carbon::createFromFormat('Y-m-d', $request->checkout),
            'checkout_hour' => Carbon::createFromFormat('Y-m-d', $request->checkout)->setHour($checkout_hour)->setMinute($checkout_minute),
            'guests_number' => $request->guests ?? 0,
            'excess_value' => $request->excess ?? 0,
            'rent_value' => $request->rent ?? 0,
            'signal_value' => $request->sinal ?? 0,
            'clean_tax' => $request->clean ?? 0,
            'bail_tax' => $request->bail ?? 0,
            'allow_pet' => $request->pet,
            'contract_deposit_id' => $contractDeposit->id
        ]);

        return $this->propertiesContracts();
    }

    public function downloadPropertyContract($contractId)
    {
        $contract = ContractClient::find($contractId);

        $property = Property::find($contract->property_id);

        $data = [
            'propriedade' => $property,
            'nome_proprietario' => $contract->owner_name,
            'cpf_proprietario' => $contract->owner_cpf,
            'endereco_proprietario' => $contract->owner_address,
            'cep_proprietario' => $contract->owner_cep,
            'cidade_proprietario' => $contract->owner_city,
            'estado_proprietario' => $contract->owner_uf,
            'telefone_proprietario' => $contract->phone_number,
            'nome_cliente' => $contract->client_name,
            'cpf_cliente' => $contract->client_cpf,
            'endereco_cliente' => $contract->client_address,
            'cep_cliente' => $contract->client_cep,
            'cidade_cliente' => $contract->client_city,
            'estado_cliente' => $contract->client_uf,
            'telefone_cliente' => $contract->phone_number,
            'endereco_imovel' => $contract->property_address,
            'cidade_imovel' => $contract->property_city,
            'estado_imovel' => $contract->property_uf,
            'dias_locados' => $contract->rented_days,
            'data_checkin' => Carbon::createFromFormat('Y-m-d', $contract->checkin_date),
            'hora_checkin' => $contract->checkin_hour,
            'hora_limite_entrada' => $contract->checkin_limit_hour,
            'data_checkout' => Carbon::createFromFormat('Y-m-d', $contract->checkout_date),
            'hora_checkout' => $contract->checkout_hour,
            'numero_hospedes' => $contract->guests_number,
            'valor_pessoa_excedente' => $contract->excess_value,
            'valor_locacao' => $contract->rent,
            'valor_sinal' => $contract->sinal,
            'taxa_de_limpeza' => $contract->clean,
            'taxa_caucao' => $contract->bail,
            'pet' => $contract->pet,
            'banco' => $contract->contractDeposit->bank,
            'agencia' => $contract->contractDeposit->agency,
            'conta' => $contract->contractDeposit->account,
            'responsavel_banco' => $contract->contractDeposit->responsible,
            'cpf_banco' => $contract->contractDeposit->cpf_bank,
            'pix' => $contract->contractDeposit->pix
        ];

        $pdf = PDF::loadView('template.contract', $data);
        $fileName = "contrato_" . str_replace(' ', '_', strtolower($property->post_title)) . ".pdf";
        return $pdf->download($fileName);
    }

    public function contractOwner($contractId)
    {
        $contract = ContractClient::find($contractId);

        if ($contract->owner_signature) {
            return $this->downloadPropertyContract($contractId);
        }

        return view('owner.owner-property-contract')
            ->with('name', Auth::user()->display_name)
            ->with('contractId', $contractId);
    }

    public function saveContractOwner(ContractRequest $request, $contractId)
    {
        $contract = ContractClient::find($contractId);

        $contract->owner_signature = $request->owner;
        $contract->owner_signature_at = now();
        $contract->save();

        return $this->propertiesContracts();
    }

    public function contractClient($contractId)
    {
        $contract = ContractClient::find($contractId);

        if ($contract->client_signature) {
            return $this->downloadPropertyContract($contractId);
        }

        return view('owner.owner-property-contract-client')
            ->with('name', Auth::user()->display_name ?? 'Convidado')
            ->with('contractId', $contractId);
    }

    public function saveContractClient(ContractRequest $request, $contractId)
    {
        $contract = ContractClient::find($contractId);

        $contract->client_signature = $request->client;
        $contract->client_signature_at = now();
        $contract->save();

        return redirect()->back();
    }

    public function destroyContract($contractId)
    {
        $contract = ContractClient::find($contractId);
        $contract->delete();

        $contractDeposit = ContractDeposit::find($contract->contract_deposit_id);
        $contractDeposit->delete();

        return $this->propertiesContracts();
    }

    public function viewClients()
    {
        $clients = Client::query()
            ->where('user_id', auth()->user()->ID)
            ->whereNotIn('status', ['Deletando'])
            ->get();

        return view('owner.owner-clients')
            ->with('name', Auth::user()->display_name)
            ->with('clients', $clients);
    }

    public function createClient()
    {
        return view('owner.owner-create-client')
            ->with('name', Auth::user()->display_name)
            ->with('client', null);
    }

    public function showClient($clientId)
    {
        $client = Client::find($clientId);

        return view('owner.owner-create-client')
            ->with('name', Auth::user()->display_name)
            ->with('client', $client);
    }

    public function saveClient(Request $request)
    {
        $data = array_merge(
            [
                'user_id' => auth()->user()->ID,
                'status' => 'Pendente'
            ],
            $request->all()
        );

        if ($request->client_id) {
            $client = Client::find($request->client_id);
        } else {
            $client = new Client();
        }

        $client->fill($data);
        $client->save();

        return redirect(route('owner.clients'));
    }

    public function destroyClient($clientId)
    {
        $client = Client::find($clientId);
        $client->status = 'Deletando';
        $client->save();

        return redirect(route('owner.clients'));
    }

    public function viewIndications()
    {
        $indications = Indication::query()
            ->where('user_id', auth()->user()->ID)
            ->get();

        return view('owner.owner-indications')
            ->with('name', Auth::user()->display_name)
            ->with('indications', $indications);
    }

    public function createIndication()
    {
        return view('owner.owner-create-indication')
            ->with('name', Auth::user()->display_name)
            ->with('indication', null);
    }

    public function showIndication($indicationId)
    {
        $indication = Indication::find($indicationId);

        return view('owner.owner-create-indication')
            ->with('name', Auth::user()->display_name)
            ->with('indication', $indication);
    }

    public function saveIndication(Request $request)
    {
        $data = array_merge(
            ['user_id' => auth()->user()->ID],
            $request->all()
        );

        if ($request->indication_id) {
            $indication = Indication::find($request->indication_id);
        } else {
            $indication = new Indication();
        }

        $indication->fill($data);
        $indication->save();

        return redirect(route('owner.indications'));
    }

    public function destroyIndication($indicationId)
    {
        $indication = Indication::find($indicationId);

        if ($indication && $indication->status === 'Aguardando Atendimento') {
            $indication->delete();
        }

        return redirect(route('owner.indications'));
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
