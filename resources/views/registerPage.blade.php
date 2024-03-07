@extends('layout')
@section('title', 'Register Page')
@section('content')
<div class="container">
    <div class="form-container">
        <div class="mb-4">
            <h1>SIGN UP</h1>
            <h6>To Enjoy the Feature, Kindly Sign Up Here</h6>
        </div>

        <form>
            <div class="mb-3">
                <div class="mb-2">
                    <label for="fullName" class="form-label">Full Name</label>
                </div>
                <input style="max-width: 270px; border: 2px solid black" type="text" class="form-control" id="fullName">
              </div>
            <div class="mb-3">
                <div class="mb-2">
                    <label for="fullName" class="form-label">Email</label>
                </div>
                <input style="max-width: 270px; border: 2px solid black" type="email" class="form-control" id="email">
            </div>
            <div class="mb-3">
                <div class="mb-2">
                    <label for="fullName" class="form-label">Password</label>
                </div>
              <input style="max-width: 270px; border: 2px solid black" type="password" class="form-control" id="password">
            </div>
            <div class="mb-3">
                <div class="mb-2">
                    <label for="fullName" class="form-label">Address</label>
                </div>
                <input style="max-width: 270px; border: 2px solid black" type="text" class="form-control" id="address">
              </div>
            <div class="mb-3">
                <div class="mb-2">
                    <label for="fullName" class="form-label">Phone Number</label>
                </div>
                <input style="max-width: 270px; border: 2px solid black" type="text" class="form-control" id="phoneNumber">
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
