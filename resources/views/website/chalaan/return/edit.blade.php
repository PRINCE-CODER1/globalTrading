@extends('website.master')
@section('content')
<div>
    @livewire('crm.return-chalaan-edit', ['id' => $returnChalaanId])
</div>

@endsection