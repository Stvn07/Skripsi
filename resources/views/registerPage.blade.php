@extends('layout')
@section('title', 'Register Page')
@section('content')
    <div class="container">
        <div class="form-container">
            <div class="mb-4">
                <h1>{{ __('signUpTitle') }}</h1>
                <h6>{{ __('signUpDesc') }}</h6>
            </div>
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form id="signupForm" action="{{ route('register.post') }}" method="POST" novalidate>
                @csrf
                <div class="mt-4 mb-4">
                    <label class="form-label" for="user_full_name">{{ __('signUpFullName') }}</label>
                    <input style="max-width: 270px; border: 2px solid black" type="text" class="form-control"
                        id="user_full_name" name="user_full_name">
                    <span class="error-message-2" id="user_full_name_empty"></span>
                </div>
                <div class="mt-4 mb-4">
                    <label class="form-label" for="user_email">{{ __('signUpEmail') }}</label>
                    <input style="max-width: 270px; border: 2px solid black" type="email" class="form-control"
                        id="user_email" name="user_email">
                    <span class="error-message-2" id="user_email_empty"></span>
                </div>
                <div class="mt-4 mb-4">
                    <label class="form-label" for="password">{{ __('signUpPassword') }}</label>
                    <input style="max-width: 270px; border: 2px solid black" type="password" class="form-control"
                        id="password" name="password">
                    <span class="error-message-2" id="password_empty"></span>
                </div>
                <div class="mt-4 mb-4">
                    <label class="form-label" for="user_address">{{ __('signUpAddress') }}</label>
                    <input style="max-width: 270px; border: 2px solid black" type="text" class="form-control"
                        id="user_address" name="user_address">
                    <span class="error-message-2" id="user_address_empty"></span>
                </div>
                <div class="mt-4 mb-4">
                    <label class="form-label" for="user_phone_number">{{ __('signUpPhoneNumber') }}</label>
                    <input style="max-width: 270px; border: 2px solid black" type="text" class="form-control"
                        id="user_phone_number" name="user_phone_number"
                        onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                    <span class="error-message-2" id="user_phone_number_empty"></span>
                </div>
                <div style="justify-content: center; align-items: center; margin: 50px 50px 20px;">
                    <button style="width: 170px; border: 2px solid black" type="submit"
                        class="btn">{{ __('signUpSubmit') }}</button>
                </div>
            </form>
            <div style="margin: 0 25px">
                <p>{{ __('signUpHaveAcc1') }}<a href="{{ route('login') }}">{{ __('signUpHaveAcc2') }}</a></p>
            </div>

            <script>
                document.getElementById("signupForm").addEventListener("submit", function(event) {
                    var user_name = document.getElementById("user_full_name");
                    var user_email = document.getElementById("user_email");
                    var password = document.getElementById("password");
                    var user_address = document.getElementById("user_address");
                    var user_phone_number = document.getElementById("user_phone_number");
                    var user_name_empty = document.getElementById("user_full_name_empty");
                    var user_email_empty = document.getElementById("user_email_empty");
                    var password_empty = document.getElementById("password_empty");
                    var user_address_empty = document.getElementById("user_address_empty");
                    var user_phone_number_empty = document.getElementById("user_phone_number_empty");
                    var emptyCount = 0;

                    var translations = {
                        emptyName: @json(__('errorNameEmpty')),
                        emptyEmail: @json(__('errorEmailEmpty')),
                        emptyPassword: @json(__('errorPasswordEmpty')),
                        emptyAddress: @json(__('errorAddressEmpty')),
                        emptyPhoneNumber: @json(__('errorPhoneNumberEmpty')),
                        nameLength: @json(__('errorNameLength')),
                        passwordLength: @json(__('errorPasswordLength')),
                        addressLength: @json(__('errorAddressLength')),
                        phoneNumberLength: @json(__('errorPhoneNumberLength')),
                        noSmallChar: @json(__('errorPasswordNoSmallChar')),
                        noBigChar: @json(__('errorPasswordNoBigChar')),
                        noNumberChar: @json(__('errorPasswordNoNumber')),
                        noSpecialChar: @json(__('errorPasswordNoSpecialChar')),
                        emailInvalid: @json(__('errorEmailInvalid'))
                    };

                    if (user_name.value.trim() === "") {
                        user_name_empty.textContent = translations.emptyName;
                        user_name_empty.style.display = "block";
                        emptyCount++;
                    } else if (user_name.value.length < 3 || user_name.value.length > 25) {
                        user_name_empty.textContent = translations.nameLength;
                        user_name_empty.style.display = "block";
                        emptyCount++;
                    } else {
                        user_name_empty.textContent = "";
                    }

                    if (user_email.value.trim() === "") {
                        user_email_empty.textContent = translations.emptyEmail;
                        user_email_empty.style.display = "block";
                        emptyCount++;
                    } else if (!/\S+@\S+\.\S+/.test(user_email.value)) {
                        user_email_empty.textContent = translations.emailInvalid;
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
                        password_empty.textContent = translations.passwordLength;
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
                        password_empty.textContent = translations.noNumberChar;
                        password_empty.style.display = "block";
                        emptyCount++;
                    } else if (!/[@$!%*?&#]/.test(password.value)) {
                        password_empty.textContent = translations.noSpecialChar;
                        password_empty.style.display = "block";
                        emptyCount++;
                    } else {
                        password_empty.textContent = "";
                    }

                    if (user_address.value.trim() === "") {
                        user_address_empty.textContent = translations.emptyAddress;
                        user_address_empty.style.display = "block";
                        emptyCount++;
                    } else if (user_address.value.length < 10) {
                        user_address_empty.textContent = translations.addressLength;
                        user_address_empty.style.display = "block";
                        emptyCount++;
                    } else {
                        user_address_empty.textContent = "";
                    }

                    if (user_phone_number.value.trim() === "") {
                        user_phone_number_empty.textContent = translations.emptyPhoneNumber;
                        user_phone_number_empty.style.display = "block";
                        emptyCount++;
                    } else if (user_phone_number.value.length !== 12) {
                        user_phone_number_empty.textContent = translations.phoneNumberLength;
                        user_phone_number_empty.style.display = "block";
                        emptyCount++;
                    } else {
                        user_phone_number_empty.textContent = "";
                    }

                    if (emptyCount > 0) {
                        event.preventDefault();
                    }
                });
            </script>
        </div>
        <div class="banner">
            <img src="/image/6333213.jpg" alt="Banner">
        </div>
    </div>
@endsection
