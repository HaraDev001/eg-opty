@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row vh-100 align-items-center">
        <div class="col-md-8 offset-md-2">
            <div class="panel panel-default bg-white">
                <div class="panel-body">
                    <div class="row mx-0">
                        <div class="col-12 text-left pt-4 pl-4">
                            <img class="auth-icon mr-2" src="{{asset('/img/logo.png')}}">
                            <span style="color: #37C4DA">OPTY</span>
                        </div>
                        <div class="col-12 text-center font-weight-bold mt-3">
                            <h2 style="color: #37C4DA">新規登録</h2>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                            <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="form-group @error('name') has-error @enderror">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control auth-input" name="name" placeholder="Name" value="{{ old('name') }}" required autofocus>

                                        @error('name')
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @error('email') has-error @enderror">
                                    <div class="col-12">
                                        <input placeholder="E-mail" type="email" class="form-control auth-input" name="email" value="{{ old('email') }}" required>

                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group @error('password') has-error @enderror">
                                    <div class="col-12">
                                        <input placeholder="パスワード" type="password" class="form-control auth-input" name="password" value="{{old('password')}}" required>

                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-12">
                                        <input placeholder="パスワード確認" type="password" class="form-control auth-input" name="password_confirmation" value="{{old('password_confirmation')}}" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary">
                                            新規登録
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-12 text-center">
                                        <a class="btn btn-link" href="{{ route('login') }}">
                                            ログインはこちらから <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
