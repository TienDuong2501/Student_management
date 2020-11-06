@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if(Session::has('success'))
            <div class="col-md-12 alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        @if(Session::has('error'))
            <div class="col-md-12 alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif
        <div class="col-md-12">
            <form action="{{ route('users.update', ['id' => $user->id]) }}" method="POST">
              <input type="hidden" name="_method" value="PUT">
              @csrf
              @if ($authUser->role == 1)
              <div class="form-group">
                <label for="name">Tên đăng nhập</label>
                <input type="text" value="{{ old('name') ?? $user->name }}" name="name" class="form-control" id="name" placeholder="Tên đăng nhập">
                @if($errors->first('name'))
                  <p class="text-danger">
                    <strong>{{ $errors->first('name') }}</strong>
                  </p>
                @endif
              </div>
              <div class="form-group">
                <label for="fullname">Họ và tên</label>
                <input type="text" value="{{ old('fullname') ?? $user->fullname }}" class="form-control" id="fullname" name="fullname" placeholder="Họ và tên">
                @if($errors->first('fullname'))
                  <p class="text-danger">
                    <strong>{{ $errors->first('fullname') }}</strong>
                  </p>
                @endif
              </div>
              @endif
              <div class="form-group">
                <label for="phone">Phone</label>
                <input type="phone" name="phone" value="{{ old('phone') ?? $user->phone }}" class="form-control" id="phone" placeholder="Số điện thoại">
                @if($errors->first('phone'))
                  <p class="text-danger">
                    <strong>{{ $errors->first('phone') }}</strong>
                  </p>
                @endif
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" value="{{ old('email') ?? $user->email }}" class="form-control" id="role" placeholder="email">
                @if($errors->first('email'))
                  <p class="text-danger">
                    <strong>{{ $errors->first('email') }}</strong>
                  </p>
                @endif
              </div>
              @if ($authUser->role == 0)
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" name="password" value="{{ $user->password }}" class="form-control" value="{{old('password')}}" id="password" placeholder="Mật khẩu">
                  @if($errors->first('password'))
                    <p class="text-danger">
                      <strong>{{ $errors->first('password') }}</strong>
                    </p>
                  @endif
                </div>
                <div class="form-group">
                  <label for="password_confirmation">Xác nhận mật khẩu</label>
                  <input type="password" value="{{ $user->password }}" name="password_confirmation"value="{{old('password_confirmation')}}" class="form-control" id="password_confirmation" placeholder="Xác nhận mật khẩu">
                  @if($errors->first('confirm_password'))
                    <p class="text-danger">
                      <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </p>
                  @endif
                </div>
              @endif
              <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
