@extends('layout')
@section('content')
    <div class="profile-container">
        <form action="/profile/update/{{ $userData->id }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="user_full_name" class="form-label">{{ __('signUpFullName') }}</label>
                <input type="text" class="form-control" id="user_full_name" name="user_full_name"
                    value="{{ $userData->user_full_name ?? '' }}">
                @error('user_full_name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="user_email" class="form-label">{{ __('signUpEmail') }}</label>
                <input type="email" class="form-control" id="user_email" name="user_email"
                    value="{{ $userData->user_email ?? '' }}">
                @error('user_email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="user_address" class="form-label">{{ __('signUpAddress') }}</label>
                <input type="text" class="form-control" id="user_address" name="user_address"
                    value="{{ $userData->user_address ?? '' }}">
                @error('user_address')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="user_phone_number" class="form-label">{{ __('signUpPhoneNumber') }}</label>
                <input type="text" class="form-control" id="user_phone_number" name="user_phone_number"
                    value="{{ $userData->user_phone_number ?? '' }}">
                @error('user_phone_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="text-center mb-3">
                <button type="submit" class="btn btn-primary">{{ __('updateButton') }}</button>
            </div>
            <div class="text-center mb-3">
                <a href="{{ route('profile', Auth::id()) }}" class="btn btn-primary">{{ __('backButton') }}</a>
            </div>
        </form>
    </div>
@endsection
