@extends('admin.auth.auth-layout')

@section('title')
    Password Reset
@endsection

@section('style')
@endsection

@section('content')
<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    {{-- <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1> --}}
                                    <p class="mb-4">Please reset your password</p>
                                    @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                    <p class="text-danger">{{ $error }}</p>
                                    @endforeach
                                @endif
                                </div>
                                <form method="post" action="{{ route('admin.password-reset-submit') }}" class="user">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <div class="form-group">
                                        <input name="email" type="email" class="form-control form-control-user"
                                            id="exampleInputEmail" aria-describedby="emailHelp"
                                            placeholder="Enter Email Address">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control form-control-user"
                                            id="exampleInputEmail" aria-describedby="emailHelp"
                                            placeholder="Enter new password">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password_confirmation" class="form-control form-control-user"
                                            id="exampleInputEmail" aria-describedby="emailHelp"
                                            placeholder="Confirm the password">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Submit
                                    </button>
                                </form>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection

@section('script')
@endsection
