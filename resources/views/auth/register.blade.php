@extends('layouts.app')

@section('contenido')
<div class="container">
    <div class="row justify-content-center d-flex align-items-center">
        <div class="col-md-6">
            <br>
            <img src="{{URL::asset('img/logo.png')}}" width="400" height="400" 
                class="img-fluid rounded mx-auto d-block" alt="logo">
        </div>
        <div class="col-md-6">
            <div class="card">
                <h4 class="card-header">{{ __('Registrarse') }}</h4>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="nomPer" class="col-md-4 col-form-label text-md-end">{{ __('Nombre (s)*') }}</label>

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
                            <label for="apePatPer" class="col-md-4 col-form-label text-md-end">{{ __('Apellido Paterno*') }}</label>

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
                            <label for="telPer" class="col-md-4 col-form-label text-md-end">{{ __('N??mero de contacto*') }}</label>

                            <div class="col-md-6">
                                <input :minlength="contacto==2 ? 7 : 10" id="telPer" placeholder="T??lefono" type="text" class="form-control @error('telPer') is-invalid @enderror" name="telPer" value="{{ old('telPer') }}" required autocomplete="telPer" autofocus placeholder="T??lefono">
                                @error('tipoTel')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input minlength="3" maxlength="5" :required="contacto==2" type="text" id="extension" name="extension" class="form-control @error('extension') is-invalid @enderror" value="{{ old('extension') }}"  placeholder="Extension" v-show="contacto==2">
                                @error('extension')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="form-check">
                                    <input v-on:click="contacto=2" class="form-check-input @error('telPer') is-invalid @enderror" value="2" type="radio" name="tipoTel" id="tipoTel" checked>
                                    <label class="form-check-label" for="tipoTel">
                                        Oficina
                                    </label>
                                </div>
                                <div class="form-check">
                                <input v-on:click="contacto=1" class="form-check-input @error('telPer') is-invalid @enderror" value="1" type="radio" name="tipoTel" id="tipoTel">
                                    <label class="form-check-label" for="tipoTel">
                                        Personal
                                    </label>
                                </div>
                                <div v-show="contacto==2">
                                    <p><small>Para n??mero de contacto de oficina, ingrese el t??lefono y extensi??n.</small></p>
                                    <p><small>Ejemplo: 1921200 es el t??lefono y 3271 la extensi??n.</small></p>
                                </div>
                                @error('telPer')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="idArea" class="col-md-4 col-form-label text-md-end">{{ __('??A qu?? ??rea, instituci??n o facultad pertenece?*') }}</label>

                            <div class="col-md-6">
                                <input id="idArea" type="text" class="form-control @error('idArea') is-invalid @enderror" name="idArea" value="{{ old('idArea') }}" required autocomplete="email">
                                @error('idArea')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Correo electr??nico*') }}</label>

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
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Contrase??a*') }}</label>

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
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirmar contrase??a*') }}</label>

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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
