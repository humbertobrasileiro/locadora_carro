@extends('layouts.app')

@section('content')
    @csrf
    {{ @csrf_token() }}
    <login-component
        old_email={{ old('email') }}
        old_remember={{ old('remember') ? 'checked' : '' }}>

    </login-component>
@endsection
