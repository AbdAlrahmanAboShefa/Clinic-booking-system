@extends('layouts.app')

@section('content')
    {{ $header ?? '' }}
    {{ $slot }}
@endsection
