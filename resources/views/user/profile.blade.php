@extends('layout')
@section('content')
    <div class="profile-container">
        <div class="text-center mb-4">
            <h2>Profil Pengguna</h2>
            <!-- Tambahkan informasi profil lainnya di sini -->
        </div>
        <hr>
        <div>
            <h4>Informasi Profil</h4>
            <div>
                <p><strong>Nama Lengkap:</strong> {{ $userData->user_full_name }}</p>
                <p><strong>Email:</strong> {{ $userData->user_email }}</p>
                <p><strong>Alamat:</strong> {{ $userData->user_address }}</p>
                <p><strong>Nomor Telfon:</strong> {{ $userData->user_phone_number }}</p>
                <!-- Tambahkan informasi lainnya -->
            </div>
        </div>
        <hr>
        <!-- Tombol untuk mengupdate profil -->
        <div class="text-center mt-4">
            <a href="{{ route('updateProfile', Auth::id()) }}" class="btn btn-primary">Update Profil</a>
        </div>
        <div class="text-center mt-2">
            <a href="{{ route('home') }}" class="btn btn-primary">Back</a>
        </div>
        <div class="text-center mt-2">
            <a href="{{ route('logout') }}" class="btn btn-primary">Logout</a>
        </div>
    </div>
@endsection
