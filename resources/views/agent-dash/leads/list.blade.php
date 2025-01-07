@extends('website.master')

@section('content')
    @if(auth()->user()->hasRole("Admin") && !request()->is('agent/leads*'))
    @livewire('crm.agent-detail-widget', ['userId' => $agentID ? $agentID : 0])
    @endif
    @livewire('crm.lead-list', ['userId' => $agentID ? $agentID : 0])
   

@endsection