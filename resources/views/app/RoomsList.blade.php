@extends('layouts.app')

@section('content')
    {{-- <rooms-list :rooms='@json($rooms)'></rooms-list> --}}
    <rooms-list :checkin='@json($checkin)' :checkout='@json($checkout)' :guests='@json($guests)'></rooms-list>
@endsection
