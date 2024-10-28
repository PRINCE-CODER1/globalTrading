@extends('website.master')
@section('content')
<div>
    @livewire('crm.internal-chalaan-edit', ['internalChalaanId' => $internalChalaanId])
</div>

@endsection 