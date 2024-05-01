@extends('layout')
@section('title', 'Login Page')
@section('content')

    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="container">
        <div class="form-container">
            <div class="mb-4">
                <h1>SIGN IN</h1>
                <h6>To Get Back In Touch, Kindly Sign In Here</h6>
            </div>
            <form id="loginForm" action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <div class="mb-2">
                        <label class="form-label">Email</label>
                    </div>
                    <input style="max-width: 270px; border: 2px solid black" type="email" class="form-control"
                        name="user_email" required>
                    <div class="error-message" id="emailError"></div>
                </div>
                <div class="mb-3">
                    <div class="mb-2">
                        <label class="form-label">Password</label>
                    </div>
                    <input style="max-width: 270px; border: 2px solid black" type="password" class="form-control"
                        name="password" required>
                    <div class="error-message" id="passwordError"></div>
                </div>
                <div style="justify-content: center; align-items: center; margin: 50px 50px 20px;">
                    <button style="width: 170px; border: 2px solid black" type="submit" class="btn">Submit</button>
                </div>
            </form>
            <div style="margin: 0 25px">
                <p>Don't have an account? <a href="/register">Sign up</a></p>
            </div>
        </div>

        <div class="banner">
            <img src="/image/3094352.jpg" alt="Banner">
        </div>

        <script>
            document.getElementById("loginForm").addEventListener("submit", function(event) {
                var email = document.getElementsByName("user_email")[0].value.trim();
                var password = document.getElementsByName("password")[0].value.trim();
                var valid = true;

                var emailError = document.getElementById("emailError");
                var passwordError = document.getElementById("passwordError");

                if (email === "") {
                    emailError.textContent = "Please enter your email";
                    valid = false;
                } else {
                    emailError.textContent = "";
                }

                if (password === "") {
                    passwordError.textContent = "Please enter your password";
                    valid = false;
                } else {
                    passwordError.textContent = "";
                }

                if (!valid) {
                    event.preventDefault();
                }
            });
        </script>
    </div>
@endsection
