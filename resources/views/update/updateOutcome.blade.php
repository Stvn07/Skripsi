@extends('sidebar.layout')
@section('content')
    <div class="profile-container">
        <form id="updateOutcomeForm" action="/outcome/update/{{ $outcomeData->id }}" method="POST">
            @csrf
            <h2 style="text-align: center">{{ __('updateOutcome') }}</h2>

            <div class="form-group">
                <div class="filter-label">
                    <label for="outcome_name">{{ __('outcomeName') }}</label>
                </div>

                <div class="filter-inputs">
                    <input type="text" id="outcome_name" name="outcome_name"
                        value="{{ $outcomeData->outcome_name ?? '' }}">
                    <span class="error-message" id="outcome_name_empty"></span>
                </div>
            </div>

            <div class="form-group">
                <div class="filter-label">
                    <label for="outcome_date">{{ __('outcomeDate') }}</label>
                </div>

                <div class="filter-inputs">
                    <input type="date" id="outcome_date" name="outcome_date" value="{{ $outcomeData->outcome_date }}">
                    <span class="error-message" id="outcome_date_empty"></span>
                </div>
            </div>

            <div class="form-group">
                <div class="filter-label">
                    <label for="outcome_amount">{{ __('outcomeAmount') }}</label>
                </div>

                <div class="filter-inputs">
                    <input type="number" id="outcome_amount" name="outcome_amount"
                        value="{{ $outcomeData->outcome_amount }}">
                    <span class="error-message" id="outcome_amount_empty"></span>
                </div>
            </div>

            <div class="buttons" style="margin-top: 50px;">
                <button type="submit" class="send">{{ __('updateButton') }}</button>
                <a href="{{ route('openOutcomePage') }}" id="cancelBtn" style="min-width: 252px; min-height: 44px"
                    class="btn btn-danger">{{ __('backButton') }}</a>
            </div>
        </form>
    </div>
@endsection