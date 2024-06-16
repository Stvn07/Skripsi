@extends('sidebar.layoutTransaction')
@section('content')
    <style>
        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f6f8ef;
        }

        .header {
            display: block;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
        }

        .search-bar input {
            /* border: none; */
            background: transparent;
            outline: none;
            flex-grow: 1;
        }

        .search-bar {
            width: 100%;
            display: flex;
            align-items: center;
            background-color: #f6f8ef;
            border-radius: 5px;
            justify-content: space-between;
            margin: 0;
            height: 15%;
        }

        .input-search {
            width: 94%;
        }

        .input-search button {
            height: 100%;
            background-color: rgb(70, 70, 70);
            border: none;
            width: 6%;
            border-radius: 0 5px 5px 0;
            margin-right: 0;
            color: white;
            margin-left: -5px;
            margin-top: 1px;
        }

        form {
            height: 45px;
        }

        form input {
            height: 100%;
            border: 1px solid;
            border-radius: 5px 0 0 5px;
            width: 90%;
            padding-left: 15px;
        }

        .filter-search {
            width: 15%;
            text-align: right;
        }

        .filter-search button {
            padding-left: 20px;
            padding-right: 20px;
            height: 45px;
            background-color: rgb(70, 70, 70);
            color: white;
        }

        .filter-search i {
            margin-right: 10px;
        }

        .modal-content {
            text-align: left;
            background-color: white;
        }

        .modal-header {
            justify-content: space-between;

        }

        .modal-body {
            background-color: white;
        }

        .modal-footer {
            background-color: white;
        }

        .modal-footer .transaction-table {
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
            <br>
            <div class="search-bar">
                <div class="input-search">
                    <form action="/transaction">
                        <input type="text" id="search" placeholder="Search..." name="search"
                            value="{{ request('search') }}">
                        <button type="submit"><i class="fa fa-search"></i></button>
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
                            searchInput.value = "";
                        });
                    </script>
                </div>

                <div class="filter-search">
                    <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <i class="fa fa-filter"></i>Filter
                    </button>

                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Filter</h1>
                                    {{-- <button type="reset" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button> --}}
                                    <button type="reset" data-bs-dismiss="modal"
                                        style="background-color: transparent; color: black; border: none;"><i
                                            class="fa fa-close"></i></button>
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
                                                <input type="month" class="form-control" id="start_month"
                                                    name="start_month" value="{{ request('start_only') }}">
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
                                        <button type="button" class="btn" value="Reset"
                                            onclick="resetData()">Reset</button>
                                        <button type="submit" class="btn">Filter</button>
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
