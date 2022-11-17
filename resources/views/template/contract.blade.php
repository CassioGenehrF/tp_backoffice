<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Contrato - Temporada Paulista</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-decoration: none;
        }

        body {
            line-height: 1.5;
            background-color: #fff;
            font-family: 'Nunito Sans', sans-serif;
            margin: 40px;
            width: 710px;
        }

        .text-center {
            text-align: center !important;
        }

        .assinaturas {
            display: flex;
            justify-content: space-around;
        }

        .locador,
        .locatario {
            flex: 1 1 auto;
            border: 1px #000 solid;
            text-align: center;
            margin: 5px;
        }

        .mt-2 {
            margin-top: 0.5rem !important;
        }

        .mt-5 {
            margin-top: 3rem !important;
        }

        .mb-3 {
            margin-bottom: 1rem !important;
        }

        .ml-10 {
            margin-left: 10rem !important;
        }

        .ml-12 {
            margin-left: 12rem !important;
        }

        .mt-10 {
            margin-top: 6rem !important;
        }

        p {
            margin-bottom: 1rem;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        h2 {
            font-size: 1.5rem;
            font-weight: 500;
        }

        h1 {
            font-size: 2rem;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <header>
        <h2 class="text-center mt-2 mb-3"><b>CONTRATO DE ALUGUEL DE IMÓVEL POR TEMPORADA</b></h2>
    </header>
    <main>
        <span>
            <p>
                <b>Cláusula 1° -</b>
                {{ $nome_proprietario }}, inscrito(a) no CPF sob o n° {{ $cpf_proprietario }}, situado no
                {{ $endereco_proprietario }}.
                Cep {{ $cep_proprietario }} - {{ $cidade_proprietario }} - {{ $estado_proprietario }}, que pode
                ser contatado pelos telefones {{ $telefone_proprietario }}, denominado <b>LOCADOR.</b>
            </p>
        </span>
        <span>
            <p>
                <b>Cláusula 2° -</b>
                {{ $nome_cliente }}, inscrito(a) no CPF de n° {{ $cpf_cliente }}, situado no
                {{ $endereco_cliente }}.
                Cep {{ $cep_cliente }} - {{ $cidade_cliente }} - {{ $estado_cliente }}, que pode
                ser contatado pelos telefones {{ $telefone_cliente }} denominado <b>LOCATÁRIO (A) / INQUILINO(A) DO
                    IMÓVEL.</b>
            </p>
        </span>
        <span>
            <p>
                <b>Cláusula 3° -</b>
                Será objeto de locação, por meio do presente instrumento, o imóvel localizado
                na {{ $endereco_imovel }}, {{ $cidade_imovel }} - {{ $estado_imovel }}, com as seguintes
                característica:
            </p>
        </span>
        <span>
            <p><b>DOS MÓVEIS E UTENSÍLIOS</b></p>
            <p class="mt-2">
                <b>Cláusula 4° -</b>
                O imóvel é guarnecido pelos seguintes móveis e utensílios, tudo em bom
                estado de conservação e funcionamento:
            </p>
            <p><b>Características</b></p>
            @if ($propriedade->externalArea)
                <p><b>Ar Livre</b></p>
                @foreach ($propriedade->externalArea as $item)
                    <p> - {{ $item->name }}</p>
                @endforeach
            @endif
            @if ($propriedade->kitchen)
                <p><b>Cozinha e sala de jantar</b></p>
                @foreach ($propriedade->kitchen as $item)
                    <p> - {{ $item->name }}</p>
                @endforeach
            @endif
            @if ($propriedade->entertainment)
                <p><b>Entretenimento</b></p>
                @foreach ($propriedade->entertainment as $item)
                    <p> - {{ $item->name }}</p>
                @endforeach
            @endif
            @if ($propriedade->internet)
                <p><b>Internet e escritório</b></p>
                @foreach ($propriedade->internet as $item)
                    <p> - {{ $item->name }}</p>
                @endforeach
            @endif
            @if ($propriedade->popularItens)
                <p><b>Itens populares</b></p>
                @foreach ($propriedade->popularItens as $item)
                    <p> - {{ $item->name }}</p>
                @endforeach
            @endif
            @if ($propriedade->location)
                <p><b>Localização e Transporte</b></p>
                @foreach ($propriedade->location as $item)
                    <p> - {{ $item->name }}</p>
                @endforeach
            @endif
            @if ($propriedade->pool)
                <p><b>Piscina e Bem Estar</b></p>
                @foreach ($propriedade->pool as $item)
                    <p> - {{ $item->name }}</p>
                @endforeach
            @endif
            @if ($propriedade->room)
                <p><b>Quarto e Lavanderia</b></p>
                @foreach ($propriedade->room as $item)
                    <p> - {{ $item->name }}</p>
                @endforeach
            @endif
            @if ($propriedade->sustainable)
                <p><b>Práticas Sustentáveis</b></p>
                @foreach ($propriedade->sustainable as $item)
                    <p> - {{ $item->name }}</p>
                @endforeach
            @endif
            <p>
                <b>Cláusula 5° -</b>
                Dá-se como necessário a realização do Checklist de todos os móveis e
                utensílios com a presença do responsável locador no momento do check-in e checkout,
                sendo o locador responsável pelo zelo e cuidado de todos os itens citados durante o
                período de locação.
            </p>
            <p>
                <b>Cláusula 6° -</b>
                Em caso de perdas e danos causados por falta de cuidado a algum dos
                móveis e utensílios vistoriado no check-in, assim também como as partes estruturais que
                compõem a casa como portas, janelas e pias, é de inteira responsabilidade do locatário, o
                ressarcimento do valor do objeto danificado de acordo com o preço atualizado de mercado.
            </p>
        </span>
        <span>
            <p><b>DO PRAZO DE LOCAÇÃO</b></p>
            <p class="mt-2">
                <b>Cláusula 7° -</b>
                O prazo estabelecido para a presente locação é de {{ $dias_locados }} dia (s),
                iniciando-se no dia {{ $data_checkin->day }} de
                {{ ucfirst($data_checkin->locale('pt-BR')->translatedFormat('F')) }} de
                {{ $data_checkin->year }} a partir das
                {{ $hora_checkin }} horas e saída as {{ $hora_checkout }} horas no dia
                {{ $data_checkout->day }} de {{ ucfirst($data_checkout->locale('pt-BR')->translatedFormat('F')) }}
                de {{ $data_checkout->year }},
                cessando nesta data, independentemente de
                avisos, notificações ou interpelações, conforme estabelecido no art. 1.194 do Código Civil
            </p>
            <p>
                <b>Cláusula 8ª - DO HORÁRIO ENTRADA.</b>
                Só será permitida entrada até às {{ $hora_limite_entrada }}, passando do mesmo só
                será autorizada a entrada no dia seguinte após às 08:00h.
            </p>
        </span>
        <span>
            <p class="ml-10"><b>DA DEMORA NA DESOCUPAÇÃO</b></p>
            <p class="ml-10">
                <b>Parágrafo 1º -</b>
                A rescisão do presente contrato ocorrerá no final do prazo estipulado
                na cláusula 7º, não podendo haver prorrogações.
            </p>
            <p class="ml-10">
                A permanência no imóvel após o prazo da vigência do contrato implicará no
                pagamento da diária no valor de 2x o valor pago por pessoa nessa proposta, até a
                efetiva desocupação, não sendo considerado a permanência como prorrogação da
                locação, salvo nos casos de renovação de contrato expressa. por pessoa, a título de
                aluguel, enquanto estiver ocupando o imóvel, conforme estabelecido no art. 1.196,
                do Código Civil, além de encargos judiciais, honorários advocatícios, advindos de
                ação judicial proposta pelo LOCADOR.
            </p>
        </span>
        <b>DA QUANTIDADE DE HÓSPEDES</b>
        <p class="mt-2">
            <b>Cláusula 9ª -</b>
            O presente contrato autoriza a hospedagem de, no máximo, {{ $numero_hospedes }} pessoas no imóvel,
            ainda que o imóvel tenha espaço para acomodar mais pessoas
        </p>
        <p class="ml-10">
            <b>Parágrafo Único -</b>
            Excedendo este número, será cobrado um valor adicional por
            pessoa/dia de R$ {{ number_format($valor_pessoa_excedente, 2, ',', '') }}, podendo o locador decidir se
            aceita
            ou não os hóspedes excedentes, assim como eventuais visitas que passarem a
            noite no imóvel também serão cobradas o mesmo valor.
        </p>
        <b>DO VALOR DA LOCAÇÃO</b>
        <p class="mt-2">
            <b>Cláusula 10° -</b>
            O valor total do aluguel para o período acima fica ajustado em R$
            {{ number_format($valor_locacao, 2, ',', '') }}
            Caso o pagamento não seja efetuado na data estipulada, o imóvel não será considerado
            reservado, e a pessoa interessada neste imóvel, deverá consultar o PROPRIETÁRIO,
            antes de efetuar o devido pagamento em atraso, para saber se o referido imóvel ainda está
            disponível para locação para a data desejada.
        </p>
        <b>DA FORMA DE PAGAMENTO</b>
        <span>
            <p class="ml-10">
                <b>Parágrafo 1° -</b>
                O pagamento do valor ajustado deverá ser realizado da seguinte
                maneira:
            </p>
            <p class="ml-12">
                <b>I.</b>
                O inquilino pagará como sinal garantidor da Reserva o valor de R$
                {{ number_format($valor_sinal, 2, ',', '') }}
            </p>
            <p class="ml-12">
                <b>II.</b>
                O valor do sinal será descontado do valor total do aluguel, e o saldo
                remanescente deverá ser pago 7 dias antes da data de entrada do imóvel, já
                acrescido de todas as taxas.
            </p>
            <p class="ml-12">
                <b>III.</b>
                No caso de desistência da locação, ou não utilização do imóvel na data
                consignada, o LOCATÁRIO perderá em favor do LOCADOR, as importâncias
                pagas a título de sinal, e se o LOCADOR desistir de locar o imóvel, deverá
                este devolver a quantia recebida a título de sinal em favor do LOCATÁRIO
            </p>
            <p class="ml-12">
                <b>IV.</b>
                Caso necessário remarcar a data de locação, o locatário deverá
                consultar o proprietário afim de chegarem num comum acordo, estando
                também sujeito a disponibilidade conforme a agenda de locações do sítio.
            </p>
        </span>
        <span>
            <p><b>Parágrafo único</b></p>
            <p>
                Estando locatário e locador em comum acordo, remarcação só poderá ser feita somente
                para dias comuns, não sendo possível a substituição da data para dias de feriados ou datas
                comemorativas.
            </p>
        </span>
        <span>
            <p><b>DAS OBRIGAÇÕES DO LOCATÁRIO</b></p>
            <p>
                O LOCATÁRIO está obrigado a respeitar as normas do LOCAL, podendo ser
                responsabilizado civil e criminalmente por eventuais infrações, na vigência deste contrato.
            </p>
            <p>
                É obrigação do LOCATÁRIO zelar pela conservação do imóvel, devendo entregá-lo nas
                mesmas condições em que o recebeu, ressalvando o desgaste natural.
            </p>
        </span>
        <span>
            <p><b>DAS REGRAS</b></p>
            <p>
                Sob pena de rescisão deste contrato e indenização por perdas e danos, segue as seguintes
                regras do contrato:
            </p>
        </span>
        <span>
            <p>
                Em caso de briga e confusão será solicitado ao locatário a entrega do local sem direito a
                ressarcimento. Proibido entrar molhado na casa, deitar molhados nos colchões e sofás, tirar
                os colchões para fora da casa, consumir bebidas e alimentos dentro da piscina, fumar
                dentro da casa, qualquer tipo de nudez no sítio, preserve o local e a natureza, mexer nos
                motores e nos ralos da piscina, tentar arrumar qualquer coisa que venha parar de funcionar
                do local, entrar em sítio vizinho para pegar bola ou qualquer outro objeto, não é permitido o
                uso de óleo bronzeador na piscina, não é permitido ouvir músicas com apologia ao crime.
            </p>
            <p class="text-danger"><b>USO E/OU PORTAR QUALQUER TIPO DE ENTORPECENTE.</b></p>
        </span>
        <span>
            <p><b>DA TAXA DE LIMPEZA</b></p>
            <p>
                <b>Cláusula 11ª -</b>
                Será cobrado de taxa de limpeza no valor de R$ {{ number_format($taxa_de_limpeza, 2, ',', '') }}
            </p>
        </span>
        <span>
            <p><b>DO CAUÇÃO</b></p>
            <p>
                <b>Cláusula 12ª -</b>
                Será exigido caução para o presente contrato no valor de R$
                {{ number_format($taxa_caucao, 2, ',', '') }}
            </p>
        </span>
        <span>
            <p><b>DOS ANIMAIS DE ESTIMAÇÃO</b></p>
            <p>
                <b>Cláusula 13ª -</b>
                O locatário {{ $pet ? '' : 'não' }} poderá trazer seus animais de
                estimação para o sítio.
            </p>
            <p>
                <b>Cláusula 14ª -</b>
                Em caso de surgimento de gatos e cachorros estranhos no interior do sítio, o
                locatário deverá notificar o locador da sua presença. A fim de tentar impedir a entrada deste
                no interior da casa e procurar o seu atual dono.
            </p>
        </span>
        <span>
            <p><b>DAS DESPESAS</b></p>
            <p>
                <b>Cláusula 15ª -</b>
                O valor da locação previsto anteriormente inclui todas essas despesas de
                despesas de água, luz, gás, impostos, condomínio, TV à cabo, internet, bem como outras
                não discriminadas expressamente neste contrato
            </p>
        </span>
        <span>
            <p><b>DAS RESPONSABILIDADES</b></p>
            <p>
                <b>Cláusula 16ª -</b>
                O locador não se responsabiliza por objetos deixados no imóvel ou no
                veículo, bem como por furtos/roubos dos bens do inquilino e outros danos causados por
                caso fortuito ou força maior que promovam danos. É vedada a entrada de qualquer pessoa
                no interior da casa que não seja hóspede. Exceto em casos extremos de manutenção, este
                deverá entrar acompanhado por um dos hóspedes da casa durante toda sua permanência.
            </p>
        </span>
        <span>
            <p><b>DAS OBRIGAÇÕES FINAIS DO INQUILINO</b></p>
            <p>
                <b>Cláusula 17ª -</b>
                O inquilino se obriga a:
            </p>
            <p>
                I. Não ceder ou franquear o imóvel para outrem, sem prévio e expresso consentimento
                da administradora, mesmo que temporariamente;
            </p>
            <p>
                II. Restituir o imóvel nas mesmas e perfeitas condições que lhe foi entregue: sem
                estragos avarias ou danos, inclusive aos móveis e utensílios, guarnições e demais
                pertences;
            </p>
            <p>
                III. Comunicar ao locador ou administradora quaisquer ocorrências imprevistas havidas
                no imóvel e seus utensílios.
            </p>
            <p>
                IV. Não é permitido o uso de óleo bronzeador na piscina, assim como jogar objetos na
                piscina que não fazem parte do seu uso comum.
            </p>
            <p>
                V. É obrigado o locatário respeitar as leis do silêncio nos seus determinados horários,
                sendo necessário a redução do volume do som das 22h às 8h. Em caso de notificação às
                autoridades locais, o locatário será inteiramente responsável pelas penalidades aplicadas
                por tal comportamento.
            </p>
            <p>
                VII. É proibido fumar no interior da casa.
            </p>
        </span>
        <span>
            <p>
                <b>Parágrafo único.</b>
                Em caso de descumprimento de quaisquer uma das cláusulas acima,
                estará o locatário sujeito a multa de 20% do valor total deste contrato, assim também como
                pedido de desocupação do imóvel caso este persista em descumprir alguma das regras ora
                aqui citadas.
            </p>
        </span>
        <span>
            <p><b>DA RESERVA E VALIDADE DA PROPOSTA</b></p>
            <p><b>Cláusula 18ª -</b></p>
            <p class="ml-10">
                <b>Parágrafo 1°:</b>
                Está proposta não caracteriza reserva do imóvel antes da assinatura
                deste e conclusão do depósito do sinal na conta abaixo citada
            </p>
            <p class="ml-10">
                <b>Parágrafo 2°:</b>
                Esta proposta é válida por 24 horas considerada a partir do momento
                do envio, em caso de depósito após este prazo, o locatário deverá consultar o
                Locador a fim de verificar a atual condição de disponibilidade do imóvel.
            </p>
            <p class="ml-10">
                <b>Parágrafo 3°:</b>
                Confirmação da reserva só é válida após a compensação do
                depósito, não aceitamos comprovante de transferência como comprovante de
                depósito, é necessário aguardar a conclusão da compensação, desta forma
                orientamos o locatário a realizar depósitos nos formatos de compensação mais
                rápido possível como o pix, para que se evite possíveis transtornos caso o depósito
                compense em um período longo onde o imóvel já poderá ter sido disponibilizado a
                outro inquilino.
            </p>
            <p class="ml-10">
                <b>Parágrafo 4°:</b>
                Em caso de depósito realizado após a validade desta proposta e que
                imóvel já tenha sido disponibilizado a outro inquilino, o depósito será devolvido na
                conta do locatário ora nomeado nesta minuta.
            </p>
            <p class="ml-10">
                <b>Cláusula 19ª -</b>
                DO SOM O LOCATÁRIO (A) e seus acompanhantes se
                responsabilizam a não fazer barulho acima do suportável e algazarras, após as
                22:00 horas um som ambiente, em respeito à lei do silêncio e em respeito aos
                vizinhos do local do imóvel, sob pena de rescisão deste contrato e indenização por
                perdas e danos.
            </p>
            <p class="ml-10">
                <b>Cláusula 20ª -</b>
                Da Luz e Água O LOCATÁRIO declara estar ciente que no local do
                imóvel não existe GERADOR DE ENERGIA, assumindo, portanto, o risco eventual
                de falta de energia elétrica em decorrência de não fornecimento pela fornecedora
                de energia. FICA POR CONTA DO LOCATÁRIO PROVIDENCIAR VELAS OU
                LAMPIÕES PARA O IMÓVEL, MEDIANTE FALTA DE LUZ;
            </p>
            <p class="ml-10">
                <b>Cláusula 21ª -</b>
                DIVERSOS
            </p>
            <p class="ml-10">
                <b>Parágrafo 1)</b>
                O (a) LOCATÁRIO (A) foi avisado dos riscos decorrentes da
                profundidade da piscina. Quanto ao uso da piscina é aconselhável que as crianças
                usem coletes salva vidas ou boias e ainda sejam supervisionadas por adulto
                responsável para se evitar acidentes. Em dias chuvosos, não é aconselhado o uso
                da mesma, por atrair facilmente raios, ou mesmo em campo de Futebol e campo
                aberto, ficando sob a responsabilidade do Locatário uso indevido nestes dias.
            </p>
            <p class="ml-10">
                <b>Parágrafo 2)</b>
                O(a) LOCATÁRIO(a), desde já está ciente que qualquer irregularidade
                e/ou dano, que possa acontecer dentro do imóvel, efetuados por ele ou algum de
                seus acompanhantes, os prejuízos ocasionados deverão ser ressarcidos ao
                proprietário, através do responsável, amigavelmente ou, em última hipótese,
                judicialmente.
            </p>
            <p class="ml-10">
                <b>Parágrafo 3)</b>
                O LOCADOR/ADMINISTRADOR não se responsabiliza por eventuais
                acidentes que porventura possam ocorrer nas dependências do imóvel e
                principalmente na piscina.
            </p>
        </span>
        <span>
            <p><b>DADOS PARA DEPÓSITO</b></p>
            <p>
                <b>Banco</b>
                {{ $banco }}
            </p>
            <p>
                <b>Agência</b>
                {{ $agencia }}
            </p>
            <p>
                <b>Conta-corrente</b>
                {{ $conta }}
            </p>
            <p>
                <b>Responsável</b>
                {{ $responsavel_banco }}
            </p>
            <p>
                <b>CPF</b>
                {{ $cpf_banco }}
            </p>
            <p>
                <b>PIX</b>
                {{ $pix }}
            </p>
        </span>
        <span>
            <p><b>DO FORO</b></p>
            <p><b>Cláusula 22ª -</b></p>
            <p>
                As partes declaram que a única relação jurídica que existe é entre LOCADOR e
                LOCATÁRIO (A); desta forma, caso o locatário não receba o imóvel em condições de uso e/
                ou nas condições contratadas, deverá reivindicar seus direitos diretamente contra o
                LOCADOR, e da mesma forma, na eventualidade do Locatário (a) não entregar o imóvel
                nas condições contratadas, causar eventual dano no imóvel ou ainda deixar de honrar com
                os pagamentos do aluguel, deverá reivindicar seus direitos diretamente contra o
                LOCATÁRIO (A).
            </p>
            <p>
                A citação, intimação e notificação, também poderão ser feitas por correspondência com
                aviso de recebimento, artigo 58, IV da Lei n. 8.245 de l8 de outubro de l.991. O presente
                contrato, que é regido pela legislação em vigor, especialmente a Lei n. 8.245/91, art. 48 a
                50, além das demais legislações aplicáveis com referência à desocupação, rescisão, direito
                de vizinhança, danos, etc. Fica eleito o Foro da Comarca de Itapecerica da Serra – SP,
                como competente para qualquer ação judicial oriunda do presente contrato, ainda que
                diversos seja o domicílio das partes e a localização do imóvel. E por estarem assim, justos e
                contratados, assinam a presente via de igual teor e forma.
            </p>
        </span>
        <span>
            <p><b>COMO PROCEDER</b></p>
            <p>
                Caso esteja de acordo com as condições acima, o locatário deverá datar e assinar o
                documento e retorná-lo ao locador através de e-mail, WhatsApp ou em mãos.
                Caso estas opções sejam inviáveis, também é válido aprovação formal por e-mail, em
                resposta ao envio desta proposta. Se comprometendo o locatário a trazer a sua via
                impressa e assinada no dia da ocupação do imóvel. Não aceitamos aprovação verbal.
            </p>
            <p><b>O QUE VEM DEPOIS?</b></p>
            <p>
                Após aprovação o locatário deve providenciar o pagamento da reserva para
                que este contrato seja validado.
            </p>
        </span>
        <span class="text-center">
            <p class="mt-10">
                {{ "$cidade_imovel, " .now()->day .' de ' .ucfirst(now()->locale('pt-BR')->translatedFormat('F')) .' de ' .now()->year }}
            </p>
            <div class="assinaturas">
                <div class="locador">
                    <p class="mt-2"><b>{!! $assinatura_proprietario ?? '&nbsp' !!}</b></p>
                    <hr style="width: 50%; margin: 0 auto;">
                    <p class="mt-2">{{ $nome_proprietario }}</p>
                    <p>CPF: {{ $cpf_proprietario }}</p>
                    <p>Locador</p>
                </div>
                <div class="locatario">
                    <p class="mt-2"><b>{!! $assinatura_cliente ?? '&nbsp' !!}</b></p>
                    <hr style="width: 50%; margin: 0 auto;">
                    <p class="mt-2">{{ $nome_cliente }}</p>
                    <p>CPF: {{ $cpf_cliente }}</p>
                    <p>Locatário</p>
                </div>
            </div>
        </span>
    </main>
</body>

</html>
