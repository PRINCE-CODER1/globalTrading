@extends('website.master')

@section('title', 'Daily Activity Reports')
@section('content')
    <div>
        @livewire('dar.dar-list')
    </div>
@endsection