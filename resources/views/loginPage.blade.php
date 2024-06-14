@extends('layout')
@section('title', 'Login')
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
            height: 100%;
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
                <h1>{{ __('signInTitle') }}</h1>
                <h6>{{ __('signInDesc') }}</h6>
            </div>

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form id="loginForm" action="{{ route('login.post') }}" method="POST" novalidate>
                @csrf
                <div class="input-group">
                    <label class="form-label" for="user_email">{{ __('signInEmail') }}</label>
                    <input type="email" id="user_email" name="user_email">
                    <span class="error-message-2" id="user_email_empty"></span>
                </div>
                <div class="input-group">
                    <label class="form-label" for="password">{{ __('signInPassword') }}</label>
                    <input type="password" id="password" name="password">
                    <span class="error-message-2" id="password_empty"></span>
                </div>
                <div class="button-container">
                    <button type="submit" class="btn">{{ __('signInSubmit') }}</button>
                </div>
            </form>
            <div class="login-link">
                <p>{{ __('signInNoAcc') }}<a href="{{ route('register') }}">{{ __('signInNoAcc2') }}</a></p>
            </div>
        </div>

        <div class="image-container">
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
                    noSpecialChar: @json(__('errorPasswordNoSpecialChar')),
                    emailInvalid: @json(__('errorEmailInvalid'))
                };

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
