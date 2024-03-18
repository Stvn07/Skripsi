@extends('layout')
@section('title', 'First Balance')
@section('content')
<form action="{{route('openFirstBalance.post')}}" method="POST">
    @csrf
    <div class="mb-3">
        <div class="mb-2">
            <label class="form-label">First Balance</label>
        </div>
        <input style="max-width: 270px; border: 2px solid black" type="number" class="form-control" name="first_balance_amount">
    </div>
    <div style="justify-content: center; align-items: center; margin: 50px 50px 20px;">
        <div>
            <button style="width: 170px; border: 2px solid black" type="submit" class="btn">Submit</button>
        </div>
        <div class="mt-2">
            <a style="width: 170px; border: 2px solid black" class="btn" href="{{route('home')}}">Back</a>
        </div>
    </div>
  </form>
@endsection
