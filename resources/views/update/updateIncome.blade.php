@extends('sidebar.dashboard')
@section('content')
    <div class="profile-container">
        <form id="updateIncomeForm" action="/income/update/{{ $incomeData->id }}" method="POST">
            @csrf
            <h2 style="text-align: center">Tambah Income</h2>

            <div class="form-group">
                <div class="filter-label">
                    <label for="income_name">Income Name</label>
                </div>

                <div class="filter-inputs">
                    <input type="text" id="income_name" name="income_name" value="{{ $incomeData->income_name ?? '' }}">
                    <span class="error-message" id="income_name_empty"></span>
                </div>
            </div>

            <div class="form-group">
                <div class="filter-label">
                    <label for="income_date">Income Date</label>
                </div>

                <div class="filter-inputs">
                    <input type="date" id="income_date" name="income_date" value="{{ $incomeData->income_date }}">
                    <span class="error-message" id="income_date_empty"></span>
                </div>
            </div>

            <div class="form-group">
                <div class="filter-label">
                    <label for="income_amount">Income Amount</label>
                </div>

                <div class="filter-inputs">
                    <input type="number" id="income_amount" name="income_amount" value="{{ $incomeData->income_amount }}">
                    <span class="error-message" id="income_amount_empty"></span>
                </div>
            </div>

            <div class="buttons" style="margin-top: 50px;">
                <button type="submit" class="send">Update</button>
                <a href="{{ route('home') }}" id="cancelBtn" style="min-width: 252px; min-height: 44px"
                    class="btn btn-danger">Batal</a>
            </div>
        </form>
    </div>
@endsection
