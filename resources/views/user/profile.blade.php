@extends('layout')
@section('content')
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
    </div>
@endsection
