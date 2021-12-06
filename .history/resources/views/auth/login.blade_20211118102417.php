@extends('layouts.app')

@section('content')
    <login-component
        csrf_token="{{ @csrf_token() }}"
        old_email="{{ old('email') }}"
        old_remember="{{ old('remember') ? 'checked' : '' }}">

    </login-component>
@endsection
