@extends('layouts.app', ['title' => __('User Profile')])

@section('card-header')
    <h1 class="text-underline">Mon profil</h1>
@endsection
@section('card-body')
<form method="post" action="{{ route('profile.update') }}" autocomplete="off">
    @csrf
    @method('put')

    <h6 class="heading-small text-muted mb-4">{{ __('Mes informations :') }}</h6>
    
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="pl-lg-4">
        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-name">{{ __('Nom') }}</label>
            <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name', auth()->user()->name) }}" required autofocus>

            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
            <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ old('email', auth()->user()->email) }}" required>

            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success mt-4">{{ __('Sauvegarder') }}</button>
        </div>
    </div>
</form>
<hr class="my-4" />
<form method="post" action="{{ route('profile.password') }}" autocomplete="off">
    @csrf
    @method('put')

    <h6 class="heading-small text-muted mb-4">{{ __('Mot de passe :') }}</h6>

    @if (session('password_status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('password_status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="pl-lg-4">
        <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-current-password">{{ __('Ancien mot de passe') }}</label>
            <input type="password" name="old_password" id="input-current-password" class="form-control form-control-alternative{{ $errors->has('old_password') ? ' is-invalid' : '' }}" value="" required>
            
            @if ($errors->has('old_password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('old_password') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-password">{{ __('Nouveau mot de passe') }}</label>
            <input type="password" name="password" id="input-password" class="form-control form-control-alternative{{ $errors->has('password') ? ' is-invalid' : '' }}" value="" required>
            
            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <label class="form-control-label" for="input-password-confirmation">{{ __('Confirmation du nouveau mot de passe') }}</label>
            <input type="password" name="password_confirmation" id="input-password-confirmation" class="form-control form-control-alternative" value="" required>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success mt-4">{{ __('Changer le mot de passe') }}</button>
        </div>
    </div>
</form>
@endsection