@extends('layouts.app', ['title' => __('Transaction Management')])

@section('content')
    @include('users.partials.header', ['title' => __('Transaction transaction')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Transaction Sign') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('transaction.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="/transaction/{{ $transaction->id }}/sign" autocomplete="off">
                            @csrf
                            
                            <h6 class="heading-small text-muted mb-4">{{ __('Transaction information') }}</h6>
                            <div class="pl-lg-4">
                                <label class="form-control-label" for="input-first-name">{{ __('Type') }}</label>
                                <div class="form-group{{ $errors->has('token') ? ' has-danger' : '' }}">
                                    <input
                                        type="text" name="type" id="input-first-name"
                                        class="form-control form-control-alternative {{ $errors->has('type') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('type') }}" value="{{ $transaction->type }}" disabled
                                    >
                                    @if ($errors->has('type'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('type') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <label class="form-control-label" for="input-first-name">{{ __('Description') }}</label>
                                <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                    <input
                                        type="text" name="description" id="input-first-name"
                                        class="form-control form-control-alternative {{ $errors->has('description') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('description') }}" value="{{ $transaction->description }}" disabled
                                    >
                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <label class="form-control-label" for="input-first-name">{{ __('Token') }}</label>
                                <div class="form-group{{ $errors->has('token') ? ' has-danger' : '' }}">
                                    <input
                                        type="text" name="token" id="input-first-name"
                                        class="form-control form-control-alternative {{ $errors->has('token') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('token') }}" value="{{ old('token') }}" required
                                    >
                                    @if ($errors->has('token'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('token') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Sign') }}</button>
                                    <a href="/transaction" class="btn btn-sm btn-primary">{{ __('Sign later') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
           $('.focused').removeClass('focused');
        });
    </script>
@endpush
