@extends('admin.app')

@section('template_title')
    {{ $area->name ?? __('Show') . " " . __('Area') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Area</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('areas.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                        <div class="form-group mb-2 mb20">
                            <strong>Nombre:</strong>
                            {{ $area->nombre }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Capacidad:</strong>
                            {{ $area->capacidad }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Id Evento:</strong>
                            {{ $area->id_evento }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Id Salon:</strong>
                            {{ $area->id_salon }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
