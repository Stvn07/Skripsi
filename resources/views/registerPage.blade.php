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
                <div class="mb-3">
                    <div class="mb-2">
                        <label class="form-label">Full Name</label>
                    </div>
                    <input style="max-width: 270px; border: 2px solid black" type="text" class="form-control"
                        name="user_full_name" required>
                    <span class="error-message" id="nameError"></span>
                </div>
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
                <div class="mb-3">
                    <div class="mb-2">
                        <label class="form-label">Address</label>
                    </div>
                    <input style="max-width: 270px; border: 2px solid black" type="text" class="form-control"
                        name="user_address" required>
                    <div class="error-message" id="addressError"></div>
                </div>
                <div class="mb-3">
                    <div class="mb-2">
                        <label class="form-label">Phone Number</label>
                    </div>
                    <input style="max-width: 270px; border: 2px solid black" type="text" class="form-control"
                        name="user_phone_number" required>
                    <div class="error-message" id="phoneError"></div>
                </div>
                <div style="justify-content: center; align-items: center; margin: 50px 50px 20px;">
                    <button style="width: 170px; border: 2px solid black" type="submit" class="btn">Submit</button>
                </div>
            </form>
            <div style="margin: 0 25px">
                <p>Already have account ? <a href="/login"> sign in</a></p>
            </div>
        </div>

        <div class="banner">
            <img src="/image/6333213.jpg" alt="Banner">
        </div>

        <script>
            document.getElementById("signupForm").addEventListener("submit", function(event) {
                var name = document.getElementsByName("user_full_name")[0].value.trim();
                var email = document.getElementsByName("user_email")[0].value.trim();
                var password = document.getElementsByName("password")[0].value.trim();
                var address = document.getElementsByName("user_address")[0].value.trim();
                var phone = document.getElementsByName("user_phone_number")[0].value.trim();
                var valid = true;

                var nameError = document.getElementById("nameError");
                var emailError = document.getElementById("emailError");
                var passwordError = document.getElementById("passwordError");
                var addressError = document.getElementById("addressError");
                var phoneError = document.getElementById("phoneError");

                if (name === "") {
                    nameError.textContent = "Please enter your full name";
                    valid = false;
                } else {
                    nameError.textContent = "";
                }

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

                if (address === "") {
                    addressError.textContent = "Please enter your address";
                    valid = false;
                } else {
                    addressError.textContent = "";
                }

                if (phone === "") {
                    phoneError.textContent = "Please enter your phone number";
                    valid = false;
                } else {
                    phoneError.textContent = "";
                }

                if (!valid) {
                    event.preventDefault();
                }
            });
        </script>
    </div>
@endsection
