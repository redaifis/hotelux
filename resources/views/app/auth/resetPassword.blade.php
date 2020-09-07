@extends('layouts.app')

@section('content')
    <reset-password :token='@json(request()->get('token'))'/>
@endsection
