@extends('website.master')

@section('content')



    @livewire('crm.manager-detail' , ['managerId' => $managerId])

    <!-- Teams and Agents Details -->
    {{-- <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Teams and Agents Under Manager</h5>
                </div>
                <div class="card-body">
                    @if($teams->isEmpty())
                        <p>No teams assigned to this manager.</p>
                    @else
                        <ul class="list-group">
                            @foreach($teams as $team)
                                <li class="list-group-item">
                                    <strong>{{ $team->name }}</strong>
                                    <ul>
                                        @foreach($team->agents as $agent)
                                            <li>{{ $agent->name }}</li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div> --}}
</div>


@endsection
