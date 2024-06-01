@extends('layout')
@section('content')
    <style>
        .main {
            flex-grow: 1;
            padding: 20px;
        }

        .header {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            padding: 20px;
            color: white;
            text-align: center;
            border-radius: 10px;
            margin-bottom: 20px;
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
            text-align: center;
        }

        .form-group {
            margin: 15px 0;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
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


    <div class="profile-container">
        <div class="text-center mb-4">
            <h2>{{ __('userProfile') }}</h2>
        </div>
        <hr>
        <div>
            <h4>{{ __('informationProfile') }}</h4>
            <div>
                <p><strong>{{ __('nameProfile') }}</strong> {{ $userData->user_full_name }}</p>
                <p><strong>{{ __('emailProfile') }}</strong> {{ $userData->user_email }}</p>
                <p><strong>{{ __('addressProfile') }}</strong> {{ $userData->user_address }}</p>
                <p><strong>{{ __('phoneNumberProfile') }}</strong> {{ $userData->user_phone_number }}</p>
            </div>
        </div>
        <hr>
        <!-- Tombol untuk mengupdate profil -->
        <div class="text-center mt-4">
            <a href="{{ route('updateProfile', Auth::id()) }}" class="btn btn-primary">{{ __('updateProfile') }}</a>
        </div>
        <div class="text-center mt-2">
            <a href="{{ route('home') }}" class="btn btn-primary">{{ __('backButton') }}</a>
        </div>
        <div class="text-center mt-2">
            <a href="{{ route('logout') }}" class="btn btn-primary">Logout</a>
        </div>

        <div class="main">
            <div class="header">
                <h1>Profile Page</h1>
                <img src="profile-picture.png" alt="Profile Picture" width="100">
            </div>
            <div class="card">
                <h2>Edit Profile</h2>
                <form>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" value="Steven Tester 4">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="steven@tester.com">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password">
                    </div>
                    <button type="submit" class="button">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
@endsection
