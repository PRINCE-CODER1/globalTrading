@extends('website.master')

@section('content')

@livewire('dar.user-dar-report',['userId' => $userId])

@endsection
