@extends('layouts.app')

@section('content')
    <Room></Room>
@endsection

<script>
    window.roomId = {!! $roomId !!}
</script>
