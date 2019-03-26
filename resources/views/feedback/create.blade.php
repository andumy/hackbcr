@extends('layouts.app', ['title' => __('Feedback Management')])

@section('content')
    @include('users.partials.header', ['title' => __('Feedback')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Send feedback') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('feedback.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('feedback.store') }}" id="feedbackForm" autocomplete="off">
                            @csrf
                            
                            <h6 class="heading-small text-muted mb-4">{{ __('Send feedback') }}</h6>
                            <div class="pl-lg-4">
                                <input type="hidden" name="to_id" value="{{ $id }}">
                                <label class="form-control-label" for="input-first-name">{{ __('Message') }}</label>
                                <div class="form-group{{ $errors->has('type') ? ' has-danger' : '' }}">
                                    <textarea name="feedback" class="form-control form-control-alternative" form="feedbackForm" placeholder="Enter feedback here...." required></textarea>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Send') }}</button>
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
