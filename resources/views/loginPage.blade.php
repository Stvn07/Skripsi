@extends('layout')
@section('title', 'Login Page')
@section('content')

    <div class="container">
        <div class="form-container">
            <div class="mb-4">
                <h1>{{ __('signInTitle') }}</h1>
                <h6>{{ __('signInDesc') }}</h6>
                {{ __('test') }} </br>
                {{ __('welcome') }} </br>
                {{ __('goodbye') }} </br>

            </div>

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form id="loginForm" action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="mt-4 mb-4">
                    <label class="form-label" for="user_email">{{ __('signInEmail') }}</label>
                    <input style="max-width: 270px; border: 2px solid black" type="email" class="form-control"
                        id="user_email" name="user_email">
                    <div class="error-message-2" id="user_email_empty"></div>
                </div>
                <div class="mt-4 mb-4">
                    <label class="form-label" for="password">{{ __('signInPassword') }}</label>
                    <input style="max-width: 270px; border: 2px solid black" type="password" class="form-control"
                        id="password" name="password">
                    <div class="error-message-2" id="password_empty"></div>
                </div>
                <div style="justify-content: center; align-items: center; margin: 50px 50px 20px;">
                    <button style="width: 170px; border: 2px solid black" type="submit"
                        class="btn">{{ __('signInSubmit') }}</button>
                </div>
            </form>
            <div style="margin: 0 25px">
                <p>{{ __('signInNoAcc') }}<a href="{{ route('register') }}">{{ __('signInNoAcc2') }}</a></p>
            </div>
        </div>

        <div class="banner">
            <img src="/image/3094352.jpg" alt="Banner">
        </div>

        <script>
            document.getElementById("loginForm").addEventListener("submit", function(event) {
                var user_email = document.getElementById("user_email");
                var password = document.getElementById("password");
                var user_email_empty = document.getElementById("user_email_empty");
                var password_empty = document.getElementById("password_empty");
                var emptyCount = 0;
                var translations = {
                    emptyEmail: @json(__('errorEmailEmpty')),
                    emptyPassword: @json(__('errorPasswordEmpty')),
                    passwordLength: @json(__('errorPasswordLength')),
                    noSmallChar: @json(__('errorPasswordNoSmallChar')),
                    noBigChar: @json(__('errorPasswordNoBigChar')),
                    noNumber: @json(__('errorPasswordNoNumber')),
                    noSpecialChar: @json(__('errorPasswordNoSpecialChar'))
                };

                if (user_email.value.trim() === "") {
                    user_email_empty.textContent = translations.emptyEmail;
                    user_email_empty.style.display = "block";
                    emptyCount++;
                } else {
                    user_email_empty.textContent = "";
                }

                if (password.value.trim() === "") {
                    password_empty.textContent = translations.emptyPassword;
                    password_empty.style.display = "block";
                    emptyCount++;
                } else if (password.value.length < 8 || password.value.length > 25) {
                    password_empty.textContent = translations.length;
                    password_empty.style.display = "block";
                    emptyCount++;
                } else if (!/[a-z]/.test(password.value)) {
                    password_empty.textContent = translations.noSmallChar;
                    password_empty.style.display = "block";
                    emptyCount++;
                } else if (!/[A-Z]/.test(password.value)) {
                    password_empty.textContent = translations.noBigChar;
                    password_empty.style.display = "block";
                    emptyCount++;
                } else if (!/[0-9]/.test(password.value)) {
                    password_empty.textContent = translations.noNumber;
                    password_empty.style.display = "block";
                    emptyCount++;
                } else if (!/[@$!%*?&#]/.test(password.value)) {
                    password_empty.textContent = translations.noSpecialChar;
                    password_empty.style.display = "block";
                    emptyCount++;
                } else {
                    password_empty.textContent = "";
                }

                if (emptyCount > 0) {
                    event.preventDefault();
                }
            });
        </script>
    </div>
@endsection
