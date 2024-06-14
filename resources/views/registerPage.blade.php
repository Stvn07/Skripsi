@extends('layout')
@section('title', 'Register')
@section('content')
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow: auto;
        }

        .container {
            display: flex;
            flex-direction: column;
            max-width: 1000px;
            width: 100%;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin: 20px;
            padding: 0;
        }

        .form-container {
            flex: 1;
            background-color: #e0f5e9;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border: none;
        }

        .form-container h1 {
            font-size: 28px;
            margin-bottom: 10px;
            color: #333;
        }

        .form-container h6 {
            margin-bottom: 20px;
            color: #666;
        }

        .form-container form {
            display: flex;
            flex-direction: column;
        }

        .input-group {
            margin-bottom: 20px;
            position: relative;
        }

        .input-group label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        .input-group input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
            transition: border-color 0.3s;
        }

        .input-group input:focus {
            border-color: #007bff;
            outline: none;
        }

        .error-message-2 {
            color: red;
            font-size: 12px;
            margin-top: 5px;
            display: none;
            position: absolute;
            bottom: -20px;
            left: 0;
        }

        .button-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .button-container button {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button-container button:hover {
            background-color: #218838;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
        }

        .login-link a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s;
        }

        .login-link a:hover {
            color: #0056b3;
        }

        .image-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .image-container img {
            max-width: 100%;
            height: auto;
        }

        /* Responsive design */
        @media (min-width: 768px) {
            .container {
                flex-direction: row;
            }

            .form-container,
            .image-container {
                flex: 1;
            }

            .form-container {
                padding: 40px;
            }

            .image-container {
                padding: 20px;
            }
        }

        @media (max-width: 767px) {
            .form-container {
                padding: 20px;
            }

            .input-group input {
                width: calc(100% - 22px);
            }

            .button-container button {
                width: 100%;
            }

            .container {
                flex-direction: column;
                margin: 0 10px;
            }
        }
    </style>
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
                <div class="input-group">
                    <label class="form-label" for="user_full_name">{{ __('signUpFullName') }}</label>
                    <input type="text" id="user_full_name" name="user_full_name">
                    <span class="error-message-2" id="user_full_name_empty"></span>
                </div>
                <div class="input-group">
                    <label class="form-label" for="user_email">{{ __('signUpEmail') }}</label>
                    <input type="email" id="user_email" name="user_email">
                    <span class="error-message-2" id="user_email_empty"></span>
                </div>
                <div class="input-group">
                    <label class="form-label" for="password">{{ __('signUpPassword') }}</label>
                    <input type="password" id="password" name="password">
                    <span class="error-message-2" id="password_empty"></span>
                </div>
                <div class="input-group">
                    <label class="form-label" for="user_address">{{ __('signUpAddress') }}</label>
                    <input type="text" id="user_address" name="user_address">
                    <span class="error-message-2" id="user_address_empty"></span>
                </div>
                <div class="input-group">
                    <label class="form-label" for="user_phone_number">{{ __('signUpPhoneNumber') }}</label>
                    <input type="text" id="user_phone_number" name="user_phone_number"
                        onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                    <span class="error-message-2" id="user_phone_number_empty"></span>
                </div>
                <div class="button-container">
                    <button type="submit">{{ __('signUpSubmit') }}</button>
                </div>
            </form>
            <div class="login-link">
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
        <div class="image-container">
            <img src="/image/6333213.jpg" alt="Banner">
        </div>
    </div>

@endsection
