@extends('sidebar.layout')
@section('content')
    <style>
        .content {
            flex-grow: 1;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
        }

        .search-bar {
            display: flex;
            align-items: center;
            background-color: #e0e0e0;
            padding: 10px;
            border-radius: 5px;
        }

        .search-bar input {
            border: none;
            background: transparent;
            outline: none;
            flex-grow: 1;
        }

        .search-bar button {
            background: #007bff;
            border: none;
            color: white;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .search-bar button img {
            margin-right: 5px;
        }

        .transaction-table {
            width: 100%;
            border-collapse: collapse;
        }

        .transaction-table th,
        .transaction-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .transaction-table th {
            background-color: #f2f2f2;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 18px;
            text-align: left;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>

    <div class="content">
        <div class="header">
            <h2>{{ __('transactionHistory') }}</h2>
            <div class="search-bar">
                <form action="/transaction">
                    <input type="text" id="search" style="width: 700px" placeholder="Search..." name="search"
                        value="{{ request('search') }}">
                    <button style="display: none" type="submit">
                    </button>
                </form>

                <script>
                    var searchInput = document.getElementById('search');
                    searchInput.addEventListener('keydown', function(event) {
                        if (event.key === 'Enter') {
                            if (searchInput.value.trim() === '') {
                                window.location.href = '/transaction';
                            }
                        }
                    });

                    document.querySelector('button[type="submit"]').addEventListener('click', function(event) {
                        if (searchInput.value.trim() === '') {
                            window.location.href = '/transaction';
                            event.preventDefault();
                        }
                    });
                </script>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Filter
                </button>

                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Filter</h1>
                                {{-- <button type="reset" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button> --}}
                            </div>
                            <form action="/transaction" method="GET" id="filterForm" onsubmit="return cleanURL()">
                                <div class="modal-body">
                                    <h3>{{ __('filterDataBy') }}</h3>

                                    <div class="filter-container mt-4 mb-4">
                                        <div class="filter-label">
                                            <label for="one_date">{{ __('day') }}</label>
                                        </div>

                                        <div class="filter-inputs">
                                            <input type="date" class="form-control" id="one_date" name="one_date"
                                                value="{{ request('one_date') }}">
                                        </div>
                                    </div>

                                    <div class="filter-container mt-4 mb-4">
                                        <div class="filter-label">
                                            <label for="start_date">{{ __('rangeDay') }}</label>
                                        </div>

                                        <div class="filter-inputs">
                                            <input type="date" class="form-control" id="start_date" name="start_date"
                                                placeholder="Pilih tanggal awal" value="{{ request('start_date') }}">
                                        </div>
                                        <span class=>{{ __('until') }}</span>
                                        <div class="filter-inputs">
                                            <input type="date" class="form-control" id="end_date" name="end_date"
                                                placeholder="Pilih tanggal akhir" value="{{ request('end_date') }}">
                                        </div>
                                    </div>

                                    <div class="filter-container mt-4 mb-4">
                                        <div class="filter-label">
                                            <label for="month_only">{{ __('month') }}</label>
                                        </div>

                                        <div class="filter-inputs">
                                            <input type="month" class="form-control" id="month_only" name="month_only"
                                                value="{{ request('month_only') }}">
                                        </div>
                                    </div>

                                    <div class="filter-container mt-4 mb-4">
                                        <div class="filter-label">
                                            <label for="start_month">{{ __('rangeMonth') }}</label>
                                        </div>

                                        <div class="filter-inputs">
                                            <input type="month" class="form-control" id="start_month" name="start_month"
                                                value="{{ request('start_only') }}">
                                        </div>
                                        <span class=>{{ __('until') }}</span>
                                        <div class="filter-inputs">
                                            <input type="month" class="form-control" id="end_month" name="end_month"
                                                value="{{ request('end_only') }}">
                                        </div>
                                    </div>

                                    <div class="filter-container mt-4 mb-4">
                                        <div class="filter-label">
                                            <label for="year_only">{{ __('year') }}</label>
                                        </div>

                                        <div class="filter-inputs">
                                            <input type="number" min="1900" max="{{ date('Y') }}"
                                                class="form-control" id="year_only" name="year_only"
                                                value="{{ request('year_only') }}">
                                        </div>
                                    </div>

                                    <div class="filter-container mt-4 mb-4">
                                        <div class="filter-label">
                                            <label for="start_year">{{ __('rangeYear') }}</label>
                                        </div>

                                        <div class="filter-inputs">
                                            <input type="number" min="1900" max="{{ date('Y') }}"
                                                class="form-control" id="start_year" name="start_year"
                                                value="{{ request('start_year') }}">
                                        </div>
                                        <span class=>{{ __('until') }}</span>
                                        <div class="filter-inputs">
                                            <input type="number" min="1900" max="{{ date('Y') }}"
                                                class="form-control" id="end_year" name="end_year"
                                                value="{{ request('end_year') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="reset" class="btn btn-secondary"
                                        data-bs-dismiss="modal">{{ __('backButton') }}</button>
                                    <button type="button" class="btn btn-danger" value="Reset"
                                        onclick="resetData()">Reset</button>
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>

                                <script>
                                    function resetData() {
                                        document.getElementById('one_date').value = '';
                                        document.getElementById('start_date').value = '';
                                        document.getElementById('end_date').value = '';
                                        document.getElementById('month_only').value = '';
                                        document.getElementById('start_month').value = '';
                                        document.getElementById('end_month').value = '';
                                        document.getElementById('year_only').value = '';
                                        document.getElementById('start_year').value = '';
                                        document.getElementById('end_year').value = '';

                                    }
                                </script>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <table class="transaction-table">
            <thead>
                <tr>
                    <th>{{ __('number') }}</th>
                    <th>{{ __('transactionName') }}</th>
                    <th>{{ __('transactionDate') }}</th>
                    <th>{{ __('transactionAmount') }}</th>
                    <th>{{ __('transactionType') }}</th>
                </tr>
            </thead>
            <tbody>
                @if (count($results) === 0)
                    <tr>
                        <td style="height: 250px; background-color: white; text-align: center; vertical-align: middle;"
                            colspan="5">{{ $errorMessage }}
                        </td>
                    </tr>
                @else
                    @foreach ($results as $transaction)
                        <tr>
                            <td>
                                {{ $transaction->nomor_urut }}
                            </td>
                            <td>
                                {{ $transaction->transaction_name }}
                            </td>
                            <td>
                                {{ $transaction->transaction_date }}
                            </td>
                            <td>
                                {{ 'Rp' . number_format($transaction->transaction_amount, 0, ',', '.') }}
                            </td>
                            <td class="{{ $transaction->income_id ? 'green-text' : 'red-text' }}">
                                @if ($transaction->income_id)
                                    {{ __('income') }}
                                @else
                                    {{ __('outcome') }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="mt-2">
            {{ $results->withQueryString()->links('pagination::bootstrap-4') }}
        </div>
    </div>

    <script>
        function cleanURL() {
            var form = document.getElementById('filterForm');
            var formData = new FormData(form);
            var urlParams = new URLSearchParams(window.location.search);

            formData.forEach(function(value, key) {
                if (value === '') {
                    urlParams.delete(key);
                } else {
                    urlParams.set(key, value);
                }
            });

            window.location.href = '/transaction?' + urlParams.toString();
            return false;
        }
    </script>
@endsection
