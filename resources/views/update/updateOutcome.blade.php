@extends('sidebar.layoutOutflow')
@section('content')
    <style>
        .content {
            flex-grow: 1;
            padding: 10px;
            background-color: #f6f8ef;
        }
    </style>

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

            <div class="form-group">
                <div class="filter-label">
                    <label for="outcome_category">{{ __('outcomeCategory') }}</label>
                </div>

                <div class="filter-inputs">
                    <select id="outcome-category" name="outcome_category" class="form-control"
                        aria-label="{{ __('selectCategory') }}">
                        <option value="" disabled {{ is_null($outcomeData->outcome_category) ? 'selected' : '' }}>
                            {{ __('selectCategory') }}</option>
                        <option value="Makanan dan Minuman"
                            {{ $outcomeData->outcome_category == 'Makanan dan Minuman' ? 'selected' : '' }}>
                            {{ __('outcomeCategory1') }}
                        </option>
                        <option value="Transportasi"
                            {{ $outcomeData->outcome_category == 'Transportasi' ? 'selected' : '' }}>
                            {{ __('outcomeCategory2') }}</option>
                        <option value="Hiburan" {{ $outcomeData->outcome_category == 'Hiburan' ? 'selected' : '' }}>
                            {{ __('outcomeCategory3') }}</option>
                        <option value="Kesehatan" {{ $outcomeData->outcome_category == 'Kesehatan' ? 'selected' : '' }}>
                            {{ __('outcomeCategory4') }}</option>
                        <option value="Tempat Tinggal"
                            {{ $outcomeData->outcome_category == 'Tempat Tinggal' ? 'selected' : '' }}>
                            {{ __('outcomeCategory5') }}
                        </option>
                        <option value="Pendidikan" {{ $outcomeData->outcome_category == 'Pendidikan' ? 'selected' : '' }}>
                            {{ __('outcomeCategory6') }}</option>
                        <option value="Belanja Pribadi"
                            {{ $outcomeData->outcome_category == 'Belanja Pribadi' ? 'selected' : '' }}>
                            {{ __('outcomeCategory7') }}
                        </option>
                        <option value="Tagihan dan Pembayaran Rutin"
                            {{ $outcomeData->outcome_category == 'Tagihan dan Pembayaran Rutin' ? 'selected' : '' }}>
                            {{ __('outcomeCategory8') }}
                        </option>
                        <option value="Liburan dan Wisata"
                            {{ $outcomeData->outcome_category == 'Liburan dan Wisata' ? 'selected' : '' }}>
                            {{ __('outcomeCategory9') }}
                        </option>
                        <option value="Tabungan dan Investasi"
                            {{ $outcomeData->outcome_category == 'Tabungan dan Investasi' ? 'selected' : '' }}>
                            {{ __('outcomeCategory10') }}</option>
                    </select>
                    <span class="error-message" id="income_category_empty"></span>
                </div>
            </div>

            <div class="buttons" style="margin-top: 50px;">
                <button id="updateBtn" type="submit" class="send">{{ __('updateButton') }}</button>
                <a href="{{ route('openOutcomePage') }}" id="cancelBtn" style="min-width: 252px; min-height: 44px"
                    class="btn btn-danger">{{ __('backButton') }}</a>
            </div>
        </form>

        {{-- <div class="modal fade" id="confirmCancelModal" tabindex="-1" aria-labelledby="confirmCancelModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <h5 style="text-align: center">{{ __('updateOutcomeConfirmationMessage') }}</h5>
                        <div class="buttons mt-4">
                            <button type="button" id="cancelConfirmYes" class="send">{{ __('yes') }}</button>
                            <button type="button" id="cancelConfirmNo" class="cancel"
                                data-bs-dismiss="modal">{{ __('no') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="noChangesModal" tabindex="-1" aria-labelledby="noChangesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <h5 style="text-align: center">{{ __('noChangesMessage') }}</h5>
                        <div style="justify-content: center; align-content: center" class="buttons mt-4">
                            <button type="button" class="send" data-bs-dismiss="modal">{{ __('close') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('updateOutcomeForm');
                const cancelBtn = document.getElementById('cancelBtn');
                const updateBtn = document.getElementById('updateBtn');
                let isFormChanged = false;

                form.addEventListener('input', function() {
                    isFormChanged = true;
                });

                cancelBtn.addEventListener('click', function(event) {
                    if (isFormChanged) {
                        event.preventDefault();
                        Swal.fire({
                            title: '{{ __('confirmationMessageTitle') }}',
                            text: '{{ __('updateOutcomeConfirmationMessage') }}',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: '{{ __('yes') }}',
                            cancelButtonText: '{{ __('no') }}',
                            confirmButtonColor: "#4caf50",
                            cancelButtonColor: "#d33",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('openOutcomePage') }}";
                            }
                        });
                    } else {
                        window.location.href = "{{ route('openOutcomePage') }}";
                    }
                });

                updateBtn.addEventListener('click', function(event) {
                    if (!isFormChanged) {
                        event.preventDefault();
                        Swal.fire({
                            title: '{{ __('noChangesMessage') }}',
                            icon: 'info',
                            confirmButtonText: '{{ __('close') }}',
                            customClass: {
                                confirmButton: 'button send-button'
                            },
                            buttonsStyling: false
                        });
                    } else {
                        sessionStorage.setItem('outcomeChanged', 'true');
                    }
                });
            });
        </script>
    </div>
@endsection
