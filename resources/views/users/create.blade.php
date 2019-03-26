@extends('layouts.app', ['title' => __('User Management')])

@section('content')
    @include('users.partials.header', ['title' => __('Add User')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('User Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('user.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('user.store') }}" autocomplete="off">
                            @csrf
                            
                            <h6 class="heading-small text-muted mb-4">{{ __('User information') }}</h6>
                            <div class="pl-lg-4">
                                <label class="form-control-label" for="input-first-name">{{ __('First Name') }}</label>
                                <div class="form-group{{ $errors->has('first_name') ? ' has-danger' : '' }}">
                                    <input
                                        type="text" name="first_name" id="input-first-name"
                                        class="form-control form-control-alternative {{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('First Name') }}" value="{{ old('first_name') }}" required
                                    >
                                    @if ($errors->has('first_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <label class="form-control-label" for="input-last-name">{{ __('Last Name') }}</label>
                                <div class="form-group{{ $errors->has('last_name') ? ' has-danger' : '' }}">
                                    <input
                                        type="text" name="last_name" id="input-last-name"
                                        class="form-control form-control-alternative {{ $errors->has('last_name') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Last Name') }}" value="{{ old('last_name') }}" required
                                    >

                                    @if ($errors->has('last_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <label class="form-control-label" for="input-email">{{ __('Phone') }}</label>
                                <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                    <input
                                        type="text" name="phone" id="input-email"
                                        class="form-control form-control-alternative {{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Phone') }}" value="{{ old('phone') }}" required
                                    >

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <input
                                        type="email" name="email" id="input-email"
                                        class="form-control form-control-alternative {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Email') }}" value="{{ old('email') }}" required
                                    >

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <label class="form-control-label" for="input-password">{{ __('Password') }}</label>
                                <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <input
                                        type="password" name="password" id="input-password"
                                        class="form-control form-control-alternative {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Password') }}" value="" required
                                    >
                                    
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <label class="form-control-label" for="input-password-confirmation">{{ __('Confirm Password') }}</label>
                                <div class="form-group">
                                    <input
                                        type="password" name="password_confirmation" id="input-password-confirmation"
                                        class="form-control form-control-alternative"
                                        placeholder="{{ __('Confirm Password') }}" value="" required
                                    >
                                </div>
                            </div>
                            <div class="pl-lg-4">
                                <label class="form-control-label" for="select-department">{{ __('Department') }}</label>
                                <div class="form-group">
                                    <select
                                        name="department_id" id="select-department"
                                        class="form-control form-control-alternative" required
                                    >
                                        e
                                        @foreach ($departments as $department)
                                            <option
                                                value="{{ $department->id  }}"
                                                @if(old('department_id') === $department->id)
                                                selected
                                                @endif
                                            >
                                                {{ $department->name  }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Add') }}</button>
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
