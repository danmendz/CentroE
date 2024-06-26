<x-app-layout>
    <div class="container mt-4">
        <h1>Cajones reservados</h1>
        <div class="row">
            @foreach ($cajones as $cajon)
                @php
                    switch ($cajon->estatus) {
                        case 0:
                            $color = 'green';
                            break;
                        case 1:
                            $color = 'red';
                            break;
                        case 2:
                            $color = 'orange';
                            break;
                        default:
                            $color = 'green';
                            break;
                    }
                @endphp

                <div class="col-md-3 mb-4">
                    <div class="card">
                        <div class="card-body" style="background-color: {{ $color }};">
                            <h5 class="card-title"><strong>Numero de cajon:</strong> {{ $cajon->numero }}</h5>
                            <h6 class="card-subtitle mb-2">Area: {{ $cajon->nombre }}</h6>
                            <h6 class="card-subtitle mb-2">Pasillo: {{ $cajon->pasillo }}</h6>
                            <h6 class="card-subtitle mb-2">Fecha de reserva: {{ $cajon->fecha }}</h6>
                            <h6 class="card-subtitle mb-2">Hora de inicio: {{ $cajon->inicio }}</h6>
                            <h6 class="card-subtitle mb-2">Hora de finalización: {{ $cajon->fin }}</h6>
                            <!-- Si quieres agregar un botón de información, descomenta la línea siguiente -->
                            {{-- <a href="{{ route('visualizar', ['id_cajon' => $cajon->id]) }}" class="btn btn-primary">Información del cajón</a> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>