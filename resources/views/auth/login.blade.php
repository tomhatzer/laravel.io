@extends('layouts.small')

@section('small-content')
    <h1 class="text-center">Login</h1>
    {!! Form::open(['route' => 'login.post']) !!}
    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
        {!! Form::label('username') !!}
        {!! Form::text('username', null, ['class' => 'form-control', 'required']) !!}
        {!! $errors->first('username', '<span class="help-block">:message</span>') !!}
    </div>
    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        {!! Form::label('password') !!}
        {!! Form::password('password', ['class' => 'form-control', 'required']) !!}
        {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
    </div>
    {!! Form::submit('Login', ['class' => 'btn btn-primary btn-block']) !!}
    {!! Form::close() !!}
    <a href="#" class="btn btn-default btn-block">
        <i class="fa fa-github"></i> Github
    </a>
    <div class="text-center">
        <a href="{{ route('password.forgot') }}">Forgot your password?</a>
    </div>
@stop