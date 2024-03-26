@extends('layout')
@section('title', 'Register Page')
@section('content')
    <div class="container">
        <div class="form-container">
            <div class="mb-4">
                <h1>SIGN UP</h1>
                <h6>To Enjoy the Feature, Kindly Sign Up Here</h6>
            </div>

            <div class="mt-2">
                @if ($errors->any())
                    <div class="col-12">
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endforeach
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

            </div>

            <form action="{{ route('register.post') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <div class="mb-2">
                        <label class="form-label">Full Name</label>
                    </div>
                    <input style="max-width: 270px; border: 2px solid black" type="text" class="form-control"
                        name="user_full_name">
                </div>
                <div class="mb-3">
                    <div class="mb-2">
                        <label class="form-label">Email</label>
                    </div>
                    <input style="max-width: 270px; border: 2px solid black" type="email" class="form-control"
                        name="user_email">
                </div>
                <div class="mb-3">
                    <div class="mb-2">
                        <label class="form-label">Password</label>
                    </div>
                    <input style="max-width: 270px; border: 2px solid black" type="password" class="form-control"
                        name="password">
                </div>
                <div class="mb-3">
                    <div class="mb-2">
                        <label class="form-label">Address</label>
                    </div>
                    <input style="max-width: 270px; border: 2px solid black" type="text" class="form-control"
                        name="user_address">
                </div>
                <div class="mb-3">
                    <div class="mb-2">
                        <label class="form-label">Phone Number</label>
                    </div>
                    <input style="max-width: 270px; border: 2px solid black" type="text" class="form-control"
                        name="user_phone_number">
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

    </div>
@endsection
