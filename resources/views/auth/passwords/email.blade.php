@extends('frontend.layouts.master')

@section('section')
    {{-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Reset Password') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Send Password Reset Link') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="page-header">
        <div class="container d-flex flex-column align-items-center">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="demo4.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="category.html">Shop</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Forgot Password
                        </li>
                    </ol>
                </div>
            </nav>

            <h1 class="mt-2">Forgot Password</h1>
        </div>
    </div>

    <div class="container reset-password-container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="feature-box border-top-primary">
                    <div class="feature-box-content">
                        <form class="mb-0" action="#">
                            <p>
                                Lost your password? Please enter your
                                username or email address. You will receive
                                a link to create a new password via email.
                            </p>
                            <div class="form-group mb-0">
                                <label for="reset-email" class="font-weight-normal">Username or email</label>
                                <input type="email" class="form-control" id="reset-email" name="reset-email" required />
                            </div>

                            <div class="form-footer mb-0">
                                <a href="login.html">Click here to login</a>

                                <button type="submit"
                                    class="btn btn-md btn-primary form-footer-right font-weight-normal text-transform-none mr-0">
                                    Reset Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
