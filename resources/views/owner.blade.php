<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="https://temporadapaulista.com.br/wp-content/uploads/2022/06/FAVICON-36x36.png"
        sizes="32x32">

    <title>Proprietário - Temporada Paulista</title>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.2.0/mdb.min.css" rel="stylesheet" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owner.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
</head>

<body>
    <header class="menu-content">
        <img class="menu-logo" src="{{ asset('images/Logopaulista.png') }}" alt="">
        <nav class="cabecalho-menu">
            <ul class="list-itens">
                <li class="menu-item">
                    <a href="#">Bloquear Agenda</a>
                </li>
                <li class="menu-item">
                    <a href="#">Desbloquear Agenda</a>
                </li>
                <li class="menu-item">
                    <p>{{ $name }}</p>
                </li>
                <li class="menu-item">
                    <form action="{{ route('logout.user') }}" method="post">
                        @csrf
                        <button type="submit">Sair</button>
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    <main class="conteudo">
        <section class="p-4 mw-60">
            <div class="calendar">
                <div class="calendar-tools">
                    <div class="d-flex flex-column flex-lg-row justify-content-center align-items-center">
                        <span class="calendar-heading">Julho 2022</span>
                    </div>
                </div>
                <table class="month">
                    <thead>
                        <tr>
                            <th>Domingo</th>
                            <th>Segunda</th>
                            <th>Terça</th>
                            <th>Quarta</th>
                            <th>Quinta</th>
                            <th>Sexta</th>
                            <th>Sábado</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- <tr>
                            <td data-date="26/06/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">26</div>
                                </div>
                                <div class="events-wrapper"></div>
                            </td>
                            <td data-date="27/06/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">27</div>
                                </div>
                                <div class="events-wrapper"></div>
                            </td>
                            <td data-date="28/06/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">28</div>
                                </div>
                                <div class="events-wrapper"></div>
                            </td>
                            <td data-date="29/06/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">29</div>
                                </div>
                                <div class="events-wrapper"></div>
                            </td>
                            <td data-date="30/06/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">30</div>
                                </div>
                                <div class="events-wrapper">
                                    <div class="event event-1 event-readonly" data-mdb-event-key="1"
                                        data-mdb-event-order="0" data-mdb-toggle="tooltip" data-mdb-offset="0,10"
                                        data-mdb-html="true" title=""
                                        style="order: 1; background: rgb(199, 245, 217); color: rgb(11, 65, 33);"
                                        data-mdb-original-title="<h6><strong>Alugado</strong></h6><p class='mb-0'><small>
          <i class='fas fa-calendar-alt pr-1'></i>
          30/06/2022 -
          06/07/2022</small></p>">
                                        Alugado</div>
                                </div>
                            </td>
                            <td data-date="01/07/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">1</div>
                                </div>
                                <div class="events-wrapper">
                                    <div data-mdb-event-key="1" data-mdb-event-order="0"
                                        class="event event-1 event-long event-readonly" data-mdb-toggle="tooltip"
                                        data-mdb-offset="0,10" data-mdb-html="true" title=""
                                        style="order: 1; background: rgb(199, 245, 217); color: rgb(11, 65, 33);"
                                        data-mdb-original-title="<h6><strong>Alugado</strong></h6><p class='mb-0'><small>
          <i class='fas fa-calendar-alt pr-1'></i>
          30/06/2022 -
          06/07/2022</small></p>">
                                        &nbsp;</div>
                                </div>
                            </td>
                            <td data-date="02/07/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">2</div>
                                </div>
                                <div class="events-wrapper">
                                    <div data-mdb-event-key="1" data-mdb-event-order="0"
                                        class="event event-1 event-long event-readonly" data-mdb-toggle="tooltip"
                                        data-mdb-offset="0,10" data-mdb-html="true" title=""
                                        style="order: 1; background: rgb(199, 245, 217); color: rgb(11, 65, 33);"
                                        data-mdb-original-title="<h6><strong>Alugado</strong></h6><p class='mb-0'><small>
          <i class='fas fa-calendar-alt pr-1'></i>
          30/06/2022 -
          06/07/2022</small></p>">
                                        &nbsp;</div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td data-date="03/07/2022" class="today">
                                <div class="day-field-wrapper">
                                    <div class="day-field">3</div>
                                </div>
                                <div class="events-wrapper">
                                    <div data-mdb-event-key="1" data-mdb-event-order="0"
                                        class="event event-1 event-long event-readonly" data-mdb-toggle="tooltip"
                                        data-mdb-offset="0,10" data-mdb-html="true" title=""
                                        style="order: 1; background: rgb(199, 245, 217); color: rgb(11, 65, 33); padding-left: 7px;"
                                        data-mdb-original-title="<h6><strong>Alugado</strong></h6><p class='mb-0'><small>
          <i class='fas fa-calendar-alt pr-1'></i>
          30/06/2022 -
          06/07/2022</small></p>">
                                        Alugado</div>
                            </td>
                            <td data-date="04/07/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">4</div>
                                </div>
                                <div class="events-wrapper">
                                    <div data-mdb-event-key="1" data-mdb-event-order="0"
                                        class="event event-1 event-long event-readonly" data-mdb-toggle="tooltip"
                                        data-mdb-offset="0,10" data-mdb-html="true" title=""
                                        style="order: 1; background: rgb(199, 245, 217); color: rgb(11, 65, 33);"
                                        data-mdb-original-title="<h6><strong>Alugado</strong></h6><p class='mb-0'><small>
          <i class='fas fa-calendar-alt pr-1'></i>
          30/06/2022 -
          06/07/2022</small></p>">
                                        &nbsp;</div>
                            </td>
                            <td data-date="05/07/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">5</div>
                                </div>
                                <div class="events-wrapper">
                                    <div data-mdb-event-key="1" data-mdb-event-order="0"
                                        class="event event-1 event-long event-readonly" data-mdb-toggle="tooltip"
                                        data-mdb-offset="0,10" data-mdb-html="true" title=""
                                        style="order: 1; background: rgb(199, 245, 217); color: rgb(11, 65, 33);"
                                        data-mdb-original-title="<h6><strong>Alugado</strong></h6><p class='mb-0'><small>
          <i class='fas fa-calendar-alt pr-1'></i>
          30/06/2022 -
          06/07/2022</small></p>">
                                        &nbsp;</div>
                            </td>
                            <td data-date="06/07/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">6</div>
                                </div>
                                <div class="events-wrapper">
                                    <div data-mdb-event-key="1" data-mdb-event-order="0"
                                        class="event event-1 event-long event-end event-readonly"
                                        data-mdb-toggle="tooltip" data-mdb-offset="0,10" data-mdb-html="true"
                                        title=""
                                        style="order: 1; background: rgb(199, 245, 217); color: rgb(11, 65, 33);"
                                        data-mdb-original-title="<h6><strong>Alugado</strong></h6><p class='mb-0'><small>
          <i class='fas fa-calendar-alt pr-1'></i>
          30/06/2022 -
          06/07/2022</small></p>">
                                        &nbsp;</div>
                            </td>
                            <td data-date="07/07/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">7</div>
                                </div>
                                <div class="events-wrapper">
                                    <div class="fake-event" style="order: 1;">&nbsp;</div>

                            </td>
                            <td data-date="08/07/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">8</div>
                                </div>
                                <div class="events-wrapper">
                                    <div class="fake-event" style="order: 1;">&nbsp;</div>
                                    <div class="event event-6 event-readonly" data-mdb-event-key="6"
                                        data-mdb-event-order="1" data-mdb-toggle="tooltip" data-mdb-offset="0,10"
                                        data-mdb-html="true" title=""
                                        style="order: 6; background: rgb(253, 216, 222); color: rgb(121, 6, 25);"
                                        data-mdb-original-title="<h6><strong>Bloqueado</strong></h6><p class='mb-0'><small>
          <i class='fas fa-calendar-alt pr-1'></i>
          08/07/2022 -
          11/07/2022</small></p>">
                                        Bloqueado</div>
                                </div>
                            </td>
                            <td data-date="09/07/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">9</div>
                                </div>
                                <div class="events-wrapper">
                                    <div class="fake-event" style="order: 1;">&nbsp;</div>
                                    <div data-mdb-event-key="6" data-mdb-event-order="1"
                                        class="event event-6 event-long event-readonly" data-mdb-toggle="tooltip"
                                        data-mdb-offset="0,10" data-mdb-html="true" title=""
                                        style="order: 6; background: rgb(253, 216, 222); color: rgb(121, 6, 25);"
                                        data-mdb-original-title="<h6><strong>Bloqueado</strong></h6><p class='mb-0'><small>
          <i class='fas fa-calendar-alt pr-1'></i>
          08/07/2022 -
          11/07/2022</small></p>">
                                        &nbsp;</div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td data-date="10/07/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">10</div>
                                </div>
                                <div class="events-wrapper">
                                    <div class="fake-event" style="order: 1;">&nbsp;</div>
                                    <div data-mdb-event-key="6" data-mdb-event-order="1"
                                        class="event event-6 event-long event-readonly" data-mdb-toggle="tooltip"
                                        data-mdb-offset="0,10" data-mdb-html="true" title=""
                                        style="order: 6; background: rgb(253, 216, 222); color: rgb(121, 6, 25); padding-left: 7px;"
                                        data-mdb-original-title="<h6><strong>Bloqueado</strong></h6><p class='mb-0'><small>
          <i class='fas fa-calendar-alt pr-1'></i>
          08/07/2022 -
          11/07/2022</small></p>">
                                        Bloqueado</div>
                                </div>
                            </td>
                            <td data-date="11/07/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">11</div>
                                </div>
                                <div class="events-wrapper">
                                    <div class="fake-event" style="order: 1;">&nbsp;</div>
                                    <div data-mdb-event-key="6" data-mdb-event-order="1"
                                        class="event event-6 event-long event-end event-readonly"
                                        data-mdb-toggle="tooltip" data-mdb-offset="0,10" data-mdb-html="true"
                                        title=""
                                        style="order: 6; background: rgb(253, 216, 222); color: rgb(121, 6, 25);"
                                        data-mdb-original-title="<h6><strong>Bloqueado</strong></h6><p class='mb-0'><small>
          <i class='fas fa-calendar-alt pr-1'></i>
          08/07/2022 -
          11/07/2022</small></p>">
                                        &nbsp;</div>
                                </div>
                            </td>
                            <td data-date="12/07/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">12</div>
                                </div>
                                <div class="events-wrapper"></div>
                            </td>
                            <td data-date="13/07/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">13</div>
                                </div>
                                <div class="events-wrapper"></div>
                            </td>
                            <td data-date="14/07/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">14</div>
                                </div>
                                <div class="events-wrapper"></div>
                            </td>
                            <td data-date="15/07/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">15</div>
                                </div>
                                <div class="events-wrapper"></div>
                            </td>
                            <td data-date="16/07/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">16</div>
                                </div>
                                <div class="events-wrapper"></div>
                            </td>
                        </tr>
                        <tr>
                            <td data-date="17/07/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">17</div>
                                </div>
                                <div class="events-wrapper"></div>
                            </td>
                            <td data-date="18/07/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">18</div>
                                </div>
                                <div class="events-wrapper"></div>
                            </td>
                            <td data-date="19/07/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">19</div>
                                </div>
                                <div class="events-wrapper"></div>
                            </td>
                            <td data-date="20/07/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">20</div>
                                </div>
                                <div class="events-wrapper"></div>
                            </td>
                            <td data-date="21/07/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">21</div>
                                </div>
                                <div class="events-wrapper"></div>
                            </td>
                            <td data-date="22/07/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">22</div>
                                </div>
                                <div class="events-wrapper"></div>
                            </td>
                            <td data-date="23/07/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">23</div>
                                </div>
                                <div class="events-wrapper"></div>
                            </td>
                        </tr>
                        <tr>
                            <td data-date="24/07/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">24</div>
                                </div>
                                <div class="events-wrapper"></div>
                            </td>
                            <td data-date="25/07/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">25</div>
                                </div>
                                <div class="events-wrapper"></div>
                            </td>
                            <td data-date="26/07/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">26</div>
                                </div>
                                <div class="events-wrapper"></div>
                            </td>
                            <td data-date="27/07/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">27</div>
                                </div>
                                <div class="events-wrapper"></div>
                            </td>
                            <td data-date="28/07/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">28</div>
                                </div>
                                <div class="events-wrapper"></div>
                            </td>
                            <td data-date="29/07/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">29</div>
                                </div>
                                <div class="events-wrapper"></div>
                            </td>
                            <td data-date="30/07/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">30</div>
                                </div>
                                <div class="events-wrapper"></div>
                            </td>
                        </tr>
                        <tr>
                            <td data-date="31/07/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">31</div>
                                </div>
                                <div class="events-wrapper"></div>
                            </td>
                            <td data-date="01/08/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">1</div>
                                </div>
                                <div class="events-wrapper"></div>
                            </td>
                            <td data-date="02/08/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">2</div>
                                </div>
                                <div class="events-wrapper"></div>
                            </td>
                            <td data-date="03/08/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">3</div>
                                </div>
                                <div class="events-wrapper"></div>
                            </td>
                            <td data-date="04/08/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">4</div>
                                </div>
                                <div class="events-wrapper"></div>
                            </td>
                            <td data-date="05/08/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">5</div>
                                </div>
                                <div class="events-wrapper"></div>
                            </td>
                            <td data-date="06/08/2022">
                                <div class="day-field-wrapper">
                                    <div class="day-field">6</div>
                                </div>
                                <div class="events-wrapper"></div>
                            </td>
                        </tr> --}}
                        {!! $calendar !!}
                    </tbody>
                </table>
            </div>
        </section>
        <form action="{{ route('owner.block') }}" method="POST">
            @if ($errors->any())
                <ul class="list-group mt-4 w-75 mx-auto">
                    @foreach ($errors->all() as $error)
                        <li class="list-group-item list-group-item-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            @csrf
            <div class="input-box">
                <label for="checkin">Check-in:</label>
                <input type="date" id="checkin" name="checkin" placeholder="xx/xx/xxxx" required>
            </div>
            <div class="input-box">
                <label for="checkout">Check-out:</label>
                <input type="date" id="checkout" name="checkout" placeholder="xx/xx/xxxx" required>
            </div>
            <div class="input-box">
                <label for="propriedade">Propriedade:</label>
                <select name="propriedade" id="propriedade">
                    @foreach ($properties as $property)
                        <option value="{{ $property->ID }}">{{ $property->post_title }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="block-button">Bloquear</button>
        </form>
    </main>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.2.0/mdb.min.js"></script>
    <script type="text/javascript"></script>
</body>

</html>
