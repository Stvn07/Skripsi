@extends('sidebar.layoutIncome')
@section('content')
    <style>
        .content {
            flex-grow: 1;
            padding: 20px;
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

        .filter-inputs {
            width: 20%;
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

        .income-table {
            width: 100%;
            border-radius: 5px;
        }

        .income-table th,
        .income-table td {
            padding: 10px;
            text-align: left;
        }

        .income-table th {
            background-color: rgb(70, 70, 70);
            color: white;
            border: none;
            font-weight: normal;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 18px;
            text-align: left;
            border-radius: 5px;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        td.action {
            text-align: center;
        }

        .far {
            color: #28a745;
            text-align: center;
        }

        .pagination {
            --bs-pagination-color: #595858;
            --bs-pagination-active-bg: rgb(70, 70, 70);
            --bs-pagination-active-border-color: none;
        }
    </style>

    <div class="content">
        <div class="header">
            <div style="margin: 0 5px">
                <h1>{{ __('income') }}</h1>
            </div>
            <div class="search-bar">
                <div class="input-search">
                    <form action="/income-table">
                        <input type="text" id="search" placeholder="Search..." name="search"
                            value="{{ request('search') }}">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>

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
                                    <button type="reset" data-bs-dismiss="modal"
                                        style="background-color: transparent; color: black; border: none;"><i
                                            class="fa fa-close"></i></button>
                                </div>
                                <form action="/income-table" method="GET" id="filterForm" onsubmit="return cleanURL()">
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

                    <script>
                        var searchInput = document.getElementById('search');
                        searchInput.addEventListener('keydown', function(event) {
                            if (event.key === 'Enter') {
                                if (searchInput.value.trim() === '') {
                                    window.location.href = '/income-table';
                                }
                            }
                        });

                        document.querySelector('button[type="submit"]').addEventListener('click', function(event) {
                            if (searchInput.value.trim() === '') {
                                window.location.href = '/income-table';
                                event.preventDefault();
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
        <table class="income-table">
            <thead>
                <tr>
                    <th>
                        {{ __('number') }}
                    </th>
                    <th>
                        {{ __('incomeName') }}
                    </th>
                    <th>
                        {{ __('incomeDate') }}
                    </th>
                    <th>
                        {{ __('incomeAmount') }}
                    </th>
                    <th>
                        {{ __('incomeCategory') }}
                    </th>
                    <th>
                        {{ __('action') }}
                    </th>
                </tr>
            </thead>
            <tbody>
                @if (count($results) === 0)
                    <tr>
                        <td style="height: 250px; background-color: white; text-align: center; vertical-align: middle;"
                            colspan="6">{{ $errorMessage }}
                        </td>
                    </tr>
                @else
                    @foreach ($results as $income)
                        <tr>
                            <td>
                                {{ $income->nomor_urut }}
                            </td>
                            <td>
                                {{ $income->Income->income_name }}
                            </td>
                            <td>
                                {{ $income->Income->income_date }}
                            </td>
                            <td>
                                {{ 'Rp' . number_format($income->Income->income_amount, 0, ',', '.') }}
                            </td>
                            <td class="income-category">
                                {{ $income->Income->income_category }}
                            </td>
                            <td class="action">
                                <a href="{{ route('updateIncome', ['incomeId' => $income->income_id]) }}">
                                    <i class="far fa-edit"></i>
                                </a>
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

            window.location.href = '/income-table?' + urlParams.toString();
            return false;
        }
    </script>

    <script>
        var currentLang = '{{ app()->getLocale() }}';
        var translations = @json(__('incomeCategories'));

        function translateCategories(categories) {
            return categories.map(category => translations[category] || category);
        }

        var categoryElements = document.querySelectorAll('.income-category');
        categoryElements.forEach(function(element) {
            var originalCategory = element.innerText;
            element.innerText = translations[originalCategory] || originalCategory;
        });

        document.addEventListener('DOMContentLoaded', function() {
            console.log(sessionStorage.getItem('incomeChanged'));
            if (sessionStorage.getItem('incomeChanged') === 'true') {
                Swal.fire({
                    icon: 'success',
                    title: '{{ __('incomeChangedSuccessMessage') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
                sessionStorage.removeItem('incomeChanged');
            }
        });
    </script>
@endsection
