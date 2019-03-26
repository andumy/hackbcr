@extends('layouts.app', ['title' => __('Transactions')])

@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Transactions') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('transaction.create') }}" class="btn btn-sm btn-primary">{{ __('Add transaction') }}</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('Type') }}</th>
                                    <th scope="col">{{ __('Description') }}</th>
                                    <th scope="col">{{ __('Status')  }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transcation)
                                    <tr>
                                        <td>{{ $transcation->type }}</td>
                                        <td>
                                            {{ $transcation->description }}
                                        </td>
                                        <td>
                                            {{ $transcation->status }}
                                        </td>
                                        <td>
                                            @if ($transcation->status != 'Signed')
                                                <a href="transaction/{{$transcation->id}}/sign"> Sign </a>
                                            @endif
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
@endsection
