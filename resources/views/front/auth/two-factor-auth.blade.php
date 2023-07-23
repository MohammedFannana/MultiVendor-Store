<x-front-layout title="Login">

    <!-- Start Account Login Area -->
    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <form class="card login-form" action="{{route('two-factor.enable')}}" method="post">
                        @csrf
                        <div class="card-body">
                            <!-- if need to show error in anthoer way from brezze -->

                            <div class="title">
                                <h3>Two Factor Authentication</h3>
                                <p>You can enable/disable 2FA.</p>
                            </div>

                            @if (session('status') == 'two-factor-authentication-enabled')
                            <div class="mb-4 font-medium text-sm">
                                Please finish configuring two factor authentication below.
                            </div>
                            @endif

                            <div class="button">
                                <!-- $user is pass from controller -->
                                <!-- two_factor_secret is column in user table -->
                                @if(!$user->two_factor_secret)
                                <button class="btn" type="submit">Enable</button>
                                @else

                                <!-- comment -->
                                {{-- because this function is return html code to print html code use {!!!!} 
                                    use to echo Qr code --}}

                                <div class="p-4">
                                    {!! $user->twoFactorQrCodeSvg()!!}
                                </div>
                                <!-- if not remmember the code you can use recovery code -->
                                <h3>Recovery Codes</h3>
                                <ul>
                                    @foreach($user->recoveryCodes() as $code)
                                    <li>{{$code}}</li>
                                    @endforeach

                                </ul>

                                @method('delete')
                                <button class="btn btn-danger" type="submit">Disable</button>
                                @endif
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Account Login Area -->

</x-front-layout>