@extends('layout')
@section('content')
    <style>
        body {
            background-color: #f6f8ef;
        }

        .main {
            flex-grow: 1;
            padding: 20px;
        }

        .header {
            background: linear-gradient(135deg, #782ec7 0%, #039018 100%);
            padding: 20px;
            color: white;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            width: 100%;
        }

        .left {
            width: 10%;
            margin-top: 10px;
        }

        .left a {
            color: white;
        }

        .middle {
            width: 80%;
            text-align: center;
            margin: 0;
        }

        .profile-container {
            border: none;
        }

        .card {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: 10px 0;
            width: 100%;
        }

        .card h2 {
            text-align: center;
        }

        .info-profile {
            margin: 15px 0;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            color: white;
            text-decoration: none;
            background-color: #28a745;
            cursor: pointer;
            border: none;
            margin-top: 10px;
        }

        .button:hover {
            background-color: #218838;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <div class="profile-container">
        <div class="main">
            <div class="header">
                <div class="left">
                    <a id="cancelBtn" href="{{ route('profile', Auth::id()) }}"><i class="fas fa-arrow-left"></i></a>
                </div>

                <div class="middle">
                    <h1>{{ __('userProfile') }}</h1>
                </div>
            </div>
            <div class="card">
                <div class="info-profile">
                    <form id="updateProfileForm" action="/profile/update/{{ $userData->id }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <strong><label for="user_full_name"
                                    class="form-label">{{ __('signUpFullName') }}</label></strong>
                            <input type="text" class="form-control" id="user_full_name" name="user_full_name"
                                value="{{ $userData->user_full_name ?? '' }}">
                            @error('user_full_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <strong><label for="user_email" class="form-label">{{ __('signUpEmail') }}</label></strong>
                            <input type="email" class="form-control" id="user_email" name="user_email"
                                value="{{ $userData->user_email ?? '' }}">
                            @error('user_email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <strong><label for="user_address" class="form-label">{{ __('signUpAddress') }}</label></strong>
                            <input type="text" class="form-control" id="user_address" name="user_address"
                                value="{{ $userData->user_address ?? '' }}">
                            @error('user_address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <strong><label for="user_phone_number"
                                    class="form-label">{{ __('signUpPhoneNumber') }}</label></strong>
                            <input type="text" class="form-control" id="user_phone_number" name="user_phone_number"
                                value="{{ $userData->user_phone_number ?? '' }}">
                            @error('user_phone_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="text-center mt-3 mx-4">
                            <button id="updateBtn" type="submit" class="button">{{ __('updateButton') }}</button>
                        </div>
                    </form>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const form = document.getElementById('updateProfileForm');
                            const cancelBtn = document.getElementById('cancelBtn');
                            const updateBtn = document.getElementById('updateBtn');
                            let isFormChanged = false;

                            form.addEventListener('input', function() {
                                isFormChanged = true;
                            });

                            cancelBtn.addEventListener('click', function(event) {
                                if (isFormChanged) {
                                    event.preventDefault();
                                    Swal.fire({
                                        title: '{{ __('confirmationMessageTitle') }}',
                                        text: '{{ __('updateProfileConfirmationMessage') }}',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonText: '{{ __('yes') }}',
                                        cancelButtonText: '{{ __('no') }}',
                                        confirmButtonColor: "#4caf50",
                                        cancelButtonColor: "#d33",
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = @json(route('profile', Auth::id()));
                                        }
                                    });
                                } else {
                                    window.location.href = @json(route('profile', Auth::id()));
                                }
                            });

                            updateBtn.addEventListener('click', function(event) {
                                if (!isFormChanged) {
                                    event.preventDefault();
                                    Swal.fire({
                                        title: '{{ __('profileNoChangesMessage') }}',
                                        icon: 'info',
                                        confirmButtonText: '{{ __('close') }}',
                                        customClass: {
                                            confirmButton: 'button send-button'
                                        },
                                        buttonsStyling: false
                                    });
                                } else {
                                    sessionStorage.setItem('profileChanged', 'true');
                                }
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
@endsection
