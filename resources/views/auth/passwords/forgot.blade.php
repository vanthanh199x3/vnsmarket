
@extends('frontend.layouts.master')
@section('main-content')
<section class="shop login section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-12">
                <div class="login-form">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h2>Khôi phục mật khẩu</h2>
                    <p>Đảm bảo rằng địa chỉ email là của bạn, chúng tôi sẽ gửi một liên kết thay đổi mật khẩu đến email của bạn</p>

                    @if(session('message'))
                        <div class="message fade show mb-4">
                            {!! session('message') !!}
                        </div>
                    @endif
                    <form id="formResetPassword" method="POST" class="form" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Xác nhận
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    $("#formResetPassword").validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
        }
    });
</script>
@endpush