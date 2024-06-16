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

        .header img {
            border-radius: 50%;
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
        }

        .button:hover {
            background-color: #218838;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <div class="profile-container">
        <!-- <div class="text-center mt-2">
                    <a href="{{ route('logout') }}" class="btn btn-primary">Logout</a>
                </div> -->

        <div class="main">
            <div class="header">
                <div class="left">
                    <a href="{{ route('home') }}"><i class="fas fa-arrow-left"></i></a>
                </div>

                <div class="middle">
                    <h1>{{ __('userProfile') }}</h1>
                </div>
            </div>
            <div class="card">
                <div class="info-profile">
                    <strong>{{ __('nameProfile') }}</strong>
                    <input type="text" class="form-control mt-2 mb-3" id="user_full_name" name="user_full_name"
                        value="{{ $userData->user_full_name ?? '' }}" disabled>
                    <strong>{{ __('emailProfile') }}</strong>
                    <input type="email" class="form-control mt-2 mb-3" id="user_email" name="user_email"
                        value="{{ $userData->user_email ?? '' }}" disabled>
                    <strong>{{ __('addressProfile') }}</strong>
                    <input type="text" class="form-control mt-2 mb-3" id="user_address" name="user_address"
                        value="{{ $userData->user_address ?? '' }}" disabled>
                    <strong>{{ __('phoneNumberProfile') }}</strong>
                    <input type="text" class="form-control mt-2" id="user_phone_number" name="user_phone_number"
                        value="{{ $userData->user_phone_number ?? '' }}" disabled>
                </div>

                <div class="text-center mt-3 mx-4">
                    <a href="{{ route('updateProfile', Auth::id()) }}" class="button">{{ __('updateProfile') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
