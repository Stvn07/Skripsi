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
                <div class="mt-4 mb-4">
                    <label class="form-label">Email</label>
                    <input style="max-width: 270px; border: 2px solid black" type="email" class="form-control"
                        id="user_email" name="user_email">
                    <div class="error-message-2" id="user_email_empty"></div>
                </div>
                <div class="mt-4 mb-4">
                    <label class="form-label">Password</label>
                    <input style="max-width: 270px; border: 2px solid black" type="password" class="form-control"
                        id="password" name="password">
                    <div class="error-message-2" id="password_empty"></div>
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
                var user_email = document.getElementById("user_email");
                var password = document.getElementById("password");
                var user_email_empty = document.getElementById("user_email_empty");
                var password_empty = document.getElementById("password_empty");
                var emptyCount = 0;

                if (user_email.value.trim() === "") {
                    user_email_empty.textContent = "Email tidak boleh kosong";
                    user_email_empty.style.display = "block";
                    emptyCount++;
                } else {
                    user_email_empty.textContent = "";
                }

                if (password.value.trim() === "") {
                    password_empty.textContent = "Password tidak boleh kosong";
                    password_empty.style.display = "block";
                    emptyCount++;
                } else if (password.value.length < 8 || password.value.length > 25) {
                    password_empty.textContent = "Password harus terdiri dari 8 sampai 25 karakter";
                    password_empty.style.display = "block";
                    emptyCount++;
                } else if (!/[a-z]/.test(password.value)) {
                    password_empty.textContent = "Password harus mengandung setidaknya satu huruf kecil";
                    password_empty.style.display = "block";
                    emptyCount++;
                } else if (!/[A-Z]/.test(password.value)) {
                    password_empty.textContent = "Password harus mengandung setidaknya satu huruf besar";
                    password_empty.style.display = "block";
                    emptyCount++;
                } else if (!/[0-9]/.test(password.value)) {
                    password_empty.textContent = "Password harus mengandung setidaknya satu angka";
                    password_empty.style.display = "block";
                    emptyCount++;
                } else if (!/[@$!%*?&#]/.test(password)) {
                    password_empty.textContent = "Password harus mengandung setidaknya satu karakter khusus";
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
