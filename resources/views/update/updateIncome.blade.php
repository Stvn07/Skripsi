@extends('sidebar.layoutIncome')
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
                </div>

                <div class="buttons" style="margin-top: 50px;">
                    <button id="updateBtn" type="submit" class="send">{{ __('updateButton') }}</button>
                    <a href="{{ route('openIncomePage') }}" id="cancelBtn" style="min-width: 252px; min-height: 44px"
                        class="btn btn-danger">{{ __('backButton') }}</a>
                </div>
            </form>

            {{-- <div class="modal fade" id="confirmCancelModal" tabindex="-1" aria-labelledby="confirmCancelModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h5 style="text-align: center">{{ __('updateIncomeConfirmationMessage') }}</h5>
                            <div class="buttons mt-4">
                                <button type="button" id="cancelConfirmYes" class="send">{{ __('yes') }}</button>
                                <button type="button" id="cancelConfirmNo" class="cancel"
                                    data-bs-dismiss="modal">{{ __('no') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="noChangesModal" tabindex="-1" aria-labelledby="noChangesModalLabel"
                aria-hidden="true">
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
                // document.addEventListener('DOMContentLoaded', function() {
                //     const form = document.getElementById('updateIncomeForm');
                //     const cancelBtn = document.getElementById('cancelBtn');
                //     const updateBtn = document.getElementById('updateBtn');
                //     const confirmCancelModal = new bootstrap.Modal(document.getElementById('confirmCancelModal'));
                //     const noChangesModal = new bootstrap.Modal(document.getElementById('noChangesModal'));
                //     let isFormChanged = false;

                //     form.addEventListener('input', function() {
                //         isFormChanged = true;
                //     });

                //     cancelBtn.addEventListener('click', function(event) {
                //         if (isFormChanged) {
                //             event.preventDefault();
                //             confirmCancelModal.show();
                //         } else {
                //             window.location.href = "{{ route('openIncomePage') }}";
                //         }
                //     });

                //     document.getElementById('cancelConfirmYes').addEventListener('click', function() {
                //         window.location.href = "{{ route('openIncomePage') }}";
                //     });

                //     document.getElementById('cancelConfirmNo').addEventListener('click', function() {
                //         confirmCancelModal.hide();
                //     });
                //     updateBtn.addEventListener('click', function(event) {
                //         if (!isFormChanged) {
                //             event.preventDefault();
                //             noChangesModal.show();
                //         }
                //     });
                // });

                document.addEventListener('DOMContentLoaded', function() {
                    const form = document.getElementById('updateIncomeForm');
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
                                text: '{{ __('updateIncomeConfirmationMessage') }}',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: '{{ __('yes') }}',
                                cancelButtonText: '{{ __('no') }}',
                                confirmButtonColor: "#4caf50",
                                cancelButtonColor: "#d33",
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "{{ route('openIncomePage') }}";
                                }
                            });
                        } else {
                            window.location.href = "{{ route('openIncomePage') }}";
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
                            sessionStorage.setItem('incomeChanged', 'true');
                        }
                    });
                });
            </script>
        </div>
    </div>
@endsection
