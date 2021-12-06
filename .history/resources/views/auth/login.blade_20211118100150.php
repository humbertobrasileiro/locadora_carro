@extends('layouts.app')

@section('content')
    <login-component
        email="{{ old('email') }}"
        remember={{ old('remember') ? 'checked' : '' }}>

    </login-component>
@endsection
