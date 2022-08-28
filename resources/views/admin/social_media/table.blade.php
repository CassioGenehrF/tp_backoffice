<table class="table">
    <thead>
        <tr>
            <th><b>Hora:</b></th>
            @foreach ($days as $day)
                <th><b>Dia {{ $day }}</b></th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><b>06:00</b></td>
            @foreach ($properties[0] as $property)
                <td>{{ $property }}</td>
            @endforeach
        </tr>
        <tr>
            <td><b>12:00</b></td>
            @foreach ($properties[1] as $property)
                <td>{{ $property }}</td>
            @endforeach
        </tr>
        <tr>
            <td><b>15:00</b></td>
            @foreach ($properties[2] as $property)
                <td>{{ $property }}</td>
            @endforeach
        </tr>
        <tr>
            <td><b>19:00</b></td>
            @foreach ($properties[3] as $property)
                <td>{{ $property }}</td>
            @endforeach
        </tr>
        <tr>
            <td><b>21:00</b></td>
            @foreach ($properties[4] as $property)
                <td>{{ $property }}</td>
            @endforeach
        </tr>
    </tbody>
</table>
