@extends('layout')
@section('title', 'Outcome')
@section('content')
<form action="{{route('addOutcome.post')}}" method="POST">
    @csrf
    <div class="mb-3">
        <div class="mb-2">
            <label class="form-label">Outcome Name</label>
        </div>
        <input style="max-width: 270px; border: 2px solid black" type="text" class="form-control" name="outcome_name">
    </div>
    <div class="mb-3">
        <div class="mb-2">
            <label class="form-label">Outcome Date</label>
        </div>
        <input style="max-width: 270px; border: 2px solid black" type="date" class="form-control" name="outcome_date">
    </div>
    <div class="mb-3">
        <div class="mb-2">
            <label class="form-label">Outcome Amount</label>
        </div>
        <input style="max-width: 270px; border: 2px solid black" type="number" class="form-control" name="outcome_amount">
    </div>
    <div style="justify-content: center; align-items: center; margin: 50px 50px 20px;">
        <div>
            <button style="width: 170px; border: 2px solid black" type="submit" class="btn">Input</button>
        </div>
        <div class="mt-2">
            <a style="width: 170px; border: 2px solid black" class="btn" href="{{route('home')}}">Back</a>
        </div>
    </div>
  </form>
@endsection
