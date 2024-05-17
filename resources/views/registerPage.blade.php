@extends('layout')
@section('title', 'Register Page')
@section('content')
    <div class="container">
        <div class="form-container">
            <div class="mb-4">
                <h1>SIGN UP</h1>
                <h6>To Enjoy the Feature, Kindly Sign Up Here</h6>
            </div>

            <form id="signupForm" action="{{ route('register.post') }}" method="POST">
                @csrf
                <div class="mt-4 mb-4">
                    <label class="form-label">Full Name</label>
                    <input style="max-width: 270px; border: 2px solid black" type="text" class="form-control"
                        id="user_full_name" name="user_full_name">
                    <span class="error-message-2" id="user_full_name_empty"></span>
                </div>
                <div class="mt-4 mb-4">
                    <label class="form-label">Email</label>
                    <input style="max-width: 270px; border: 2px solid black" type="email" class="form-control"
                        id="user_email" name="user_email">
                    <span class="error-message-2" id="user_email_empty"></span>
                </div>
                <div class="mt-4 mb-4">
                    <label class="form-label">Password</label>
                    <input style="max-width: 270px; border: 2px solid black" type="password" class="form-control"
                        id="password" name="password">
                    <span class="error-message-2" id="password_empty"></span>
                </div>
                <div class="mt-4 mb-4">
                    <label class="form-label">Address</label>
                    <input style="max-width: 270px; border: 2px solid black" type="text" class="form-control"
                        id="user_address" name="user_address">
                    <span class="error-message-2" id="user_address_empty"></span>
                </div>
                <div class="mt-4 mb-4">
                    <label class="form-label">Phone Number</label>
                    <input style="max-width: 270px; border: 2px solid black" type="text" class="form-control"
                        id="user_phone_number" name="user_phone_number"
                        onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                    <span class="error-message-2" id="user_phone_number_empty"></span>
                </div>
                <div style="justify-content: center; align-items: center; margin: 50px 50px 20px;">
                    <button style="width: 170px; border: 2px solid black" type="submit" class="btn">Submit</button>
                </div>
            </form>
            <div style="margin: 0 25px">
                <p>Already have account ? <a href="/login"> sign in</a></p>
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

                    if (user_name.value.trim() === "") {
                        user_name_empty.textContent = "Full Name tidak boleh kosong";
                        user_name_empty.style.display = "block";
                        emptyCount++;
                    } else if (user_name.value.length < 3 || user_name.value.length > 25) {
                        user_name_empty.textContent = "Full Name hanya bisa terdiri dari 3 sampai 25 kata";
                        user_name_empty.style.display = "block";
                        emptyCount++;
                    } else {
                        user_name_empty.textContent = "";
                    }

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
                    } else if (!/[@$!%*?&#]/.test(password.value)) {
                        password_empty.textContent = "Password harus mengandung setidaknya satu karakter khusus";
                        password_empty.style.display = "block";
                        emptyCount++;
                    } else {
                        password_empty.textContent = "";
                    }

                    if (user_address.value.trim() === "") {
                        user_address_empty.textContent = "Alamat tidak boleh kosong";
                        user_address_empty.style.display = "block";
                        emptyCount++;
                    } else if (user_address.value.length < 10) {
                        user_address_empty.textContent = "Alamat setidaknya harus terdiri dari 10 karakter";
                        user_address_empty.style.display = "block";
                        emptyCount++;
                    } else {
                        user_address_empty.textContent = "";
                    }

                    if (user_phone_number.value.trim() === "") {
                        user_phone_number_empty.textContent = "Nomor Handphone tidak boleh kosong";
                        user_phone_number_empty.style.display = "block";
                        emptyCount++;
                    } else if (user_phone_number.value.length < 12 || user_phone_number.value.length > 12) {
                        user_phone_number_empty.textContent = "Nomor Handphone harus terdiri dari 12 nomor";
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

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
        </div>
        <div class="banner">
            <img src="/image/6333213.jpg" alt="Banner">
        </div>
    </div>
@endsection
