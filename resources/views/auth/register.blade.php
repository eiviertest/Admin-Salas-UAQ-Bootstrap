@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registrarse') }}</div>

                <div class="card-body">
                    @if(count($areas) == 0)
                        <div class="alert alert-warning" role="alert">
                            <p>Disculpe los incovenientes.</p>
                            <p>No hay área/institución/facultad registradas, en consecuencia, no puede registrarse.</p>
                            <p>Póngase en contacto con el administrador.</p>
                        </div>
                    @else
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="nomPer" class="col-md-4 col-form-label text-md-end">{{ __('Nombre (s)') }}</label>

                                <div class="col-md-6">
                                    <input id="nomPer" type="text" class="form-control @error('nomPer') is-invalid @enderror" name="nomPer" value="{{ old('nomPer') }}" required autocomplete="nomPer" autofocus>

                                    @error('nomPer')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="apePatPer" class="col-md-4 col-form-label text-md-end">{{ __('Apellido Paterno') }}</label>

                                <div class="col-md-6">
                                    <input id="apePatPer" type="text" class="form-control @error('apePatPer') is-invalid @enderror" name="apePatPer" value="{{ old('apePatPer') }}" required autocomplete="apePatPer" autofocus>

                                    @error('apePatPer')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="apeMatPer" class="col-md-4 col-form-label text-md-end">{{ __('Apellido Materno') }}</label>

                                <div class="col-md-6">
                                    <input id="apeMatPer" type="text" class="form-control @error('apeMatPer') is-invalid @enderror" name="apeMatPer" value="{{ old('apeMatPer') }}" autocomplete="apeMatPer" autofocus>

                                    @error('apeMatPer')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="telPer" class="col-md-4 col-form-label text-md-end">{{ __('Número de contacto') }}</label>

                                <div class="col-md-6">
                                    <input id="telPer" type="number" class="form-control @error('telPer') is-invalid @enderror" name="telPer" value="{{ old('telPer') }}" required autocomplete="telPer" autofocus>

                                    @error('telPer')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="idArea" class="col-md-4 col-form-label text-md-end">{{ __('¿A qué área, institución o facultad pertenece?') }}</label>

                                <div class="col-md-6">
                                    <select class="form-select @error('idArea') is-invalid @enderror" aria-label="Default select example" id="idArea" name="idArea">
                                        @foreach ($areas as $area)
                                        <option value={{$area->idArea}}>{{$area->nomArea}}</option>
                                        @endforeach                                
                                    </select>
                                    @error('idArea')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Correo electrónico') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Contraseña') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirmar contraseña') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Registrarse') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection