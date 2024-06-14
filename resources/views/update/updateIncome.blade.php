@extends('sidebar.layout')
@section('content')
    <style>
        .content {
            flex-grow: 1;
            padding: 10px;
            background-color: #f6f8ef;
        }
    </style>
    <div class="content">
        <div class="profile-container">
            <form id="updateIncomeForm" action="/income/update/{{ $incomeData->id }}" method="POST">
                @csrf
                <h2 style="text-align: center">{{ __('updateIncome') }}</h2>

                <div class="form-group">
                    <div class="filter-label">
                        <label for="income_name">{{ __('incomeName') }}</label>
                    </div>

                    <div class="filter-inputs">
                        <input type="text" id="income_name" name="income_name"
                            value="{{ $incomeData->income_name ?? '' }}">
                        <span class="error-message" id="income_name_empty"></span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="filter-label">
                        <label for="income_date">{{ __('incomeDate') }}</label>
                    </div>

                    <div class="filter-inputs">
                        <input type="date" id="income_date" name="income_date" value="{{ $incomeData->income_date }}">
                        <span class="error-message" id="income_date_empty"></span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="filter-label">
                        <label for="income_amount">{{ __('incomeAmount') }}</label>
                    </div>

                    <div class="filter-inputs">
                        <input type="number" id="income_amount" name="income_amount"
                            value="{{ $incomeData->income_amount }}">
                        <span class="error-message" id="income_amount_empty"></span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="filter-label">
                        <label for="income_category">{{ __('incomeCategory') }}</label>
                    </div>

                    <div class="filter-inputs">
                        <select id="income-category" name="income_category" class="form-control"
                            aria-label="{{ __('selectCategory') }}">
                            <option value="" disabled {{ is_null($incomeData->income_category) ? 'selected' : '' }}>
                                {{ __('selectCategory') }}</option>
                            <option value="Gaji Tetap"
                                {{ $incomeData->income_category == 'Gaji Tetap' ? 'selected' : '' }}>
                                {{ __('incomeCategory1') }}</option>
                            <option value="Pendapatan Pasif"
                                {{ $incomeData->income_category == 'Pendapatan Pasif' ? 'selected' : '' }}>
                                {{ __('incomeCategory2') }}</option>
                            <option value="Pendapatan Penjualan"
                                {{ $incomeData->income_category == 'Pendapatan Penjualan' ? 'selected' : '' }}>
                                {{ __('incomeCategory3') }}</option>
                            <option value="Pendapatan Bisnis"
                                {{ $incomeData->income_category == 'Pendapatan Bisnis' ? 'selected' : '' }}>
                                {{ __('incomeCategory4') }}</option>
                            <option value="Freelance" {{ $incomeData->income_category == 'Freelance' ? 'selected' : '' }}>
                                {{ __('incomeCategory5') }}</option>
                            <option value="Bonus" {{ $incomeData->income_category == 'Bonus' ? 'selected' : '' }}>
                                {{ __('incomeCategory6') }}</option>
                        </select>
                        <span class="error-message" id="income_category_empty"></span>
                    </div>

                    <div class="buttons" style="margin-top: 50px;">
                        <button type="submit" class="send">{{ __('updateButton') }}</button>
                        <a href="{{ route('openIncomePage') }}" id="cancelBtn" style="min-width: 252px; min-height: 44px"
                            class="btn btn-danger">{{ __('backButton') }}</a>
                    </div>
            </form>
        </div>
    </div>
@endsection
