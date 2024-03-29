@extends('layouts.app')

@section('content')
    @role('admin')
        @include('layouts.headers.cards')
        <div class="container-fluid mt--7">
            
            <div class="row mt-5">
                <div class="col-6 mb-5 mb-xl-0">
                    <div class="card shadow">
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">{{__('Departments')}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <!-- Projects table -->
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">{{__('Name')}}</th>
                                        <th scope="col">{{__('Members')}}</th>
                                        <th scope="col">{{__('Department lead')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($departments as $dep)
                                        <tr>
                                            <th scope="row">
                                                <a href="{{route('department.edit',$dep->id)}}">
                                                    {{ __($dep->name) }}
                                                </a>
                                            </th>
                                            <td>
                                                {{ __($dep->count) }}
                                            </td>
                                            <td>
                                                {{ __($dep->lead) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card shadow">
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">{{__('Team Distribution')}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <!-- Projects table -->
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">{{__('Name')}}</th>
                                        <th scope="col">{{__('Department Composition')}}</th>
                                        <th scope="col">{{__('Team Lead')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($teams as $team)
                                        <tr>
                                            <th scope="row">
                                                <a href="{{route('team.edit',$team->id)}}">
                                                    {{__($team->name)}}
                                                </a>
                                            </th>
                                            <td>
                                                @foreach($team->dep_comp as $dep)
                                                    <span class="badge badge-pill badge-default">{{__($dep)}}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                {{__($team->lead)}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            @include('layouts.footers.auth')
        </div>
    @endrole
    
    @role(['team_worker','team_lead','dep_worker','dep_lead'])
        @include('layouts.headers.cards')
        <div class="container-fluid mt--7">
            
            <div class="row mt-5">
                <div class="col-6 mb-5 mb-xl-0">
                    <div class="card shadow">
                        <div class="card-header border-0">
                            {{__('Department')}}
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">{{__($departments->name)}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <!-- Projects table -->
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">{{__('Name')}}</th>
                                        <th scope="col">{{__('Action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($departments->users as $user)
                                        <tr>
                                            <th scope="row">
                                                {{ __($user->fist_name.' '.$user->last_name) }}
                                            </th>
                                            <td>
                                                <a href="{{route('feedback.create',['id' => $user->id])}}">
                                                    <button class='btn btn-success'>
                                                        <i class="fas fa-sticky-note"></i>
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class='row'>
                @foreach($teams as $team)
                    <div class="col-6">
                        <div class="card shadow">
                            <div class="card-header border-0">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="mb-0">{{__($team->name)}}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <!-- Projects table -->
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">{{__('Name')}}</th>
                                            <th scope="col">{{__('Department')}}</th>
                                            <th scope="col">{{__('Action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($team->users as $user)
                                            <tr>
                                                <td>
                                                    {{__($user->first_name.' '.$user->last_name)}}
                                                </td>
                                                <td>
                                                    {{__($user->department->name)}}
                                                </td>
                                                <td>
                                                    <a href="{{route('feedback.create',['id' => $user->id])}}">
                                                        <button class='btn btn-success'>
                                                            <i class="fas fa-sticky-note"></i>
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            @include('layouts.footers.auth')
        </div>
    @endrole

@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush