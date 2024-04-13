<x-app-layout>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Create') }} Evento</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('eventos.insertar') }}" role="form" enctype="multipart/form-data">
                            @csrf
                            @include('usuario.evento.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>