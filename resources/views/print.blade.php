<h1>Printers</h1>
<ul>
    @foreach($printers as $printer)
        <li>
            Name: {{ $printer->name() }} (ID: {{ $printer->id }})
        </li>
    @endforeach
</ul>
