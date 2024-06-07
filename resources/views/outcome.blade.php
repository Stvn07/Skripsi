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

            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .search-bar button img {
            margin-right: 5px;
        }

        .outcome-table {
            width: 100%;
            border-collapse: collapse;
        }

        .outcome-table th,
        .outcome-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .outcome-table th {
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
    {{-- <div class="content">
        <h1>{{ __('outcome') }}</h1>

        <div class="container-table">
            <form action="/outcome-table">
                <div class="input-group mb-3">
                    <input type="text" id="search" class="form-control" placeholder="Search..." name="search"
                        value="{{ request('search') }}">
                    <button class="btn btn-outline-dark" type="submit"><svg xmlns="http://www.w3.org/2000/svg"
                            width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </button>
                </div>
            </form>

            <script>
                var searchInput = document.getElementById('search');
                searchInput.addEventListener('keydown', function(event) {
                    if (event.key === 'Enter') {
                        if (searchInput.value.trim() === '') {
                            window.location.href = '/outcome-table';
                        }
                    }
                });

                document.querySelector('button[type="submit"]').addEventListener('click', function(event) {
                    if (searchInput.value.trim() === '') {
                        window.location.href = '/outcome-table';
                        event.preventDefault();
                    }
                });
            </script>

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Filter
            </button>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Filter</h1>
                            <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/outcome-table" method="GET" id="filterForm" onsubmit="return cleanURL()">
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
                                        <input type="number" min="1900" max="{{ date('Y') }}" class="form-control"
                                            id="year_only" name="year_only" value="{{ request('year_only') }}">
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
        @if (request('search'))
            <table style="border: 1px solid black">
                <thead style="text-align: center">
                    <tr>
                        <th>
                            {{ __('number') }}
                        </th>
                        <th>
                            {{ __('outcomeName') }}
                        </th>
                        <th>
                            {{ __('outcomeDate') }}
                        </th>
                        <th>
                            {{ __('outcomeAmount') }}
                        </th>
                        <th>
                            {{ __('outcomeCategory') }}
                        </th>
                        <th>
                            {{ __('action') }}
                        </th>
                    </tr>
                </thead>
                <tbody style="text-align: center">
                    @if (count($results) === 0)
                        <tr>
                            <td colspan="6">{{ __('noOutcomeData') }}</td>
                        </tr>
                    @else
                        @foreach ($results as $outcome)
                            <tr>
                                <td>
                                    {{ $outcome->nomor_urut }}
                                </td>
                                <td>
                                    {{ $outcome->Outcome->outcome_name }}
                                </td>
                                <td>
                                    {{ $outcome->Outcome->outcome_date }}
                                </td>
                                <td>
                                    {{ 'Rp' . number_format($outcome->Outcome->outcome_amount, 0, ',', '.') }}
                                </td>
                                <td class="outcome-category">
                                    {{ $outcome->Outcome->outcome_category }}
                                </td>
                                <td>
                                    <a href="{{ route('updateOutcome', ['outcomeId' => $outcome->outcome_id]) }}"
                                        class="btn btn-primary">
                                        {{ __('updateButton') }}
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
        @elseif (request('one_date'))
            <table style="border: 1px solid black">
                <thead style="text-align: center">
                    <tr>
                        <th>
                            {{ __('number') }}
                        </th>
                        <th>
                            {{ __('outcomeName') }}
                        </th>
                        <th>
                            {{ __('outcomeDate') }}
                        </th>
                        <th>
                            {{ __('outcomeAmount') }}
                        </th>
                        <th>
                            {{ __('outcomeCategory') }}
                        </th>
                        <th>
                            {{ __('action') }}
                        </th>
                    </tr>
                </thead>
                <tbody style="text-align: center">
                    @if (count($results) === 0)
                        <tr>
                            <td colspan="6">{{ __('noOutcomeData') }}</td>
                        </tr>
                    @else
                        @foreach ($results as $outcome)
                            <tr>
                                <td>
                                    {{ $outcome->nomor_urut }}
                                </td>
                                <td>
                                    {{ $outcome->Outcome->outcome_name }}
                                </td>
                                <td>
                                    {{ $outcome->Outcome->outcome_date }}
                                </td>
                                <td>
                                    {{ 'Rp' . number_format($outcome->Outcome->outcome_amount, 0, ',', '.') }}
                                </td>
                                <td class="outcome-category">
                                    {{ $outcome->Outcome->outcome_category }}
                                </td>
                                <td>
                                    <a href="{{ route('updateOutcome', ['outcomeId' => $outcome->outcome_id]) }}"
                                        class="btn btn-primary">
                                        {{ __('updateButton') }}
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
        @elseif (request('start_date') && request('end_date'))
            <table style="border: 1px solid black">
                <thead style="text-align: center">
                    <tr>
                        <th>
                            {{ __('number') }}
                        </th>
                        <th>
                            {{ __('outcomeName') }}
                        </th>
                        <th>
                            {{ __('outcomeDate') }}
                        </th>
                        <th>
                            {{ __('outcomeAmount') }}
                        </th>
                        <th>
                            {{ __('outcomeCategory') }}
                        </th>
                        <th>
                            {{ __('action') }}
                        </th>
                    </tr>
                </thead>
                <tbody style="text-align: center">
                    @if (count($results) === 0)
                        <tr>
                            <td colspan="6">{{ __('noOutcomeData') }}</td>
                        </tr>
                    @else
                        @foreach ($results as $outcome)
                            <tr>
                                <td>
                                    {{ $outcome->nomor_urut }}
                                </td>
                                <td>
                                    {{ $outcome->Outcome->outcome_name }}
                                </td>
                                <td>
                                    {{ $outcome->Outcome->outcome_date }}
                                </td>
                                <td>
                                    {{ 'Rp' . number_format($outcome->Outcome->outcome_amount, 0, ',', '.') }}
                                </td>
                                <td class="outcome-category">
                                    {{ $outcome->Outcome->outcome_category }}
                                </td>
                                <td>
                                    <a href="{{ route('updateOutcome', ['outcomeId' => $outcome->outcome_id]) }}"
                                        class="btn btn-primary">
                                        {{ __('updateButton') }}
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
        @elseif (request('month_only'))
            <table style="border: 1px solid black">
                <thead style="text-align: center">
                    <tr>
                        <th>
                            {{ __('number') }}
                        </th>
                        <th>
                            {{ __('outcomeName') }}
                        </th>
                        <th>
                            {{ __('outcomeDate') }}
                        </th>
                        <th>
                            {{ __('outcomeAmount') }}
                        </th>
                        <th>
                            {{ __('outcomeCategory') }}
                        </th>
                        <th>
                            {{ __('action') }}
                        </th>
                    </tr>
                </thead>
                <tbody style="text-align: center">
                    @if (count($results) === 0)
                        <tr>
                            <td colspan="6">{{ __('noOutcomeData') }}</td>
                        </tr>
                    @else
                        @foreach ($results as $outcome)
                            <tr>
                                <td>
                                    {{ $outcome->nomor_urut }}
                                </td>
                                <td>
                                    {{ $outcome->Outcome->outcome_name }}
                                </td>
                                <td>
                                    {{ $outcome->Outcome->outcome_date }}
                                </td>
                                <td>
                                    {{ 'Rp' . number_format($outcome->Outcome->outcome_amount, 0, ',', '.') }}
                                </td>
                                <td class="outcome-category">
                                    {{ $outcome->Outcome->outcome_category }}
                                </td>
                                <td>
                                    <a href="{{ route('updateOutcome', ['outcomeId' => $outcome->outcome_id]) }}"
                                        class="btn btn-primary">
                                        {{ __('updateButton') }}
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
        @elseif (request('start_month') && request('end_month'))
            <table style="border: 1px solid black">
                <thead style="text-align: center">
                    <tr>
                        <th>
                            {{ __('number') }}
                        </th>
                        <th>
                            {{ __('outcomeName') }}
                        </th>
                        <th>
                            {{ __('outcomeDate') }}
                        </th>
                        <th>
                            {{ __('outcomeAmount') }}
                        </th>
                        <th>
                            {{ __('outcomeCategory') }}
                        </th>
                        <th>
                            {{ __('action') }}
                        </th>
                    </tr>
                </thead>
                <tbody style="text-align: center">
                    @if (count($results) === 0)
                        <tr>
                            <td colspan="6">{{ __('noOutcomeData') }}</td>
                        </tr>
                    @else
                        @foreach ($results as $outcome)
                            <tr>
                                <td>
                                    {{ $outcome->nomor_urut }}
                                </td>
                                <td>
                                    {{ $outcome->Outcome->outcome_name }}
                                </td>
                                <td>
                                    {{ $outcome->Outcome->outcome_date }}
                                </td>
                                <td>
                                    {{ 'Rp' . number_format($outcome->Outcome->outcome_amount, 0, ',', '.') }}
                                </td>
                                <td class="outcome-category">
                                    {{ $outcome->Outcome->outcome_category }}
                                </td>
                                <td>
                                    <a href="{{ route('updateOutcome', ['outcomeId' => $outcome->outcome_id]) }}"
                                        class="btn btn-primary">
                                        {{ __('updateButton') }}
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
        @elseif (request('year_only'))
            <table style="border: 1px solid black">
                <thead style="text-align: center">
                    <tr>
                        <th>
                            {{ __('number') }}
                        </th>
                        <th>
                            {{ __('outcomeName') }}
                        </th>
                        <th>
                            {{ __('outcomeDate') }}
                        </th>
                        <th>
                            {{ __('outcomeAmount') }}
                        </th>
                        <th>
                            {{ __('outcomeCategory') }}
                        </th>
                        <th>
                            {{ __('action') }}
                        </th>
                    </tr>
                </thead>
                <tbody style="text-align: center">
                    @if (count($results) === 0)
                        <tr>
                            <td colspan="6">{{ __('noOutcomeData') }}</td>
                        </tr>
                    @else
                        @foreach ($results as $outcome)
                            <tr>
                                <td>
                                    {{ $outcome->nomor_urut }}
                                </td>
                                <td>
                                    {{ $outcome->Outcome->outcome_name }}
                                </td>
                                <td>
                                    {{ $outcome->Outcome->outcome_date }}
                                </td>
                                <td>
                                    {{ 'Rp' . number_format($outcome->Outcome->outcome_amount, 0, ',', '.') }}
                                </td>
                                <td class="outcome-category">
                                    {{ $outcome->Outcome->outcome_category }}
                                </td>
                                <td>
                                    <a href="{{ route('updateOutcome', ['outcomeId' => $outcome->outcome_id]) }}"
                                        class="btn btn-primary">
                                        {{ __('updateButton') }}
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
        @elseif (request('start_year') && request('end_year'))
            <table style="border: 1px solid black">
                <thead style="text-align: center">
                    <tr>
                        <th>
                            {{ __('number') }}
                        </th>
                        <th>
                            {{ __('outcomeName') }}
                        </th>
                        <th>
                            {{ __('outcomeDate') }}
                        </th>
                        <th>
                            {{ __('outcomeAmount') }}
                        </th>
                        <th>
                            {{ __('outcomeCategory') }}
                        </th>
                        <th>
                            {{ __('action') }}
                        </th>
                    </tr>
                </thead>
                <tbody style="text-align: center">
                    @if (count($results) === 0)
                        <tr>
                            <td colspan="6">{{ __('noOutcomeData') }}</td>
                        </tr>
                    @else
                        @foreach ($results as $outcome)
                            <tr>
                                <td>
                                    {{ $outcome->nomor_urut }}
                                </td>
                                <td>
                                    {{ $outcome->Outcome->outcome_name }}
                                </td>
                                <td>
                                    {{ $outcome->Outcome->outcome_date }}
                                </td>
                                <td>
                                    {{ 'Rp' . number_format($outcome->Outcome->outcome_amount, 0, ',', '.') }}
                                </td>
                                <td class="outcome-category">
                                    {{ $outcome->Outcome->outcome_category }}
                                </td>
                                <td>
                                    <a href="{{ route('updateOutcome', ['outcomeId' => $outcome->outcome_id]) }}"
                                        class="btn btn-primary">
                                        {{ __('updateButton') }}
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
        @else
            <table style="border: 1px solid black">
                <thead style="text-align: center">
                    <tr>
                        <th>
                            {{ __('number') }}
                        </th>
                        <th>
                            {{ __('outcomeName') }}
                        </th>
                        <th>
                            {{ __('outcomeDate') }}
                        </th>
                        <th>
                            {{ __('outcomeAmount') }}
                        </th>
                        <th>
                            {{ __('outcomeCategory') }}
                        </th>
                        <th>
                            {{ __('action') }}
                        </th>
                    </tr>
                </thead>
                <tbody style="text-align: center">
                    @if (count($results) === 0)
                        <tr>
                            <td colspan="6">{{ __('noOutcomeData') }}</td>
                        </tr>
                    @else
                        @foreach ($results as $outcome)
                            <tr>
                                <td>
                                    {{ $outcome->nomor_urut }}
                                </td>
                                <td>
                                    {{ $outcome->Outcome->outcome_name }}
                                </td>
                                <td>
                                    {{ $outcome->Outcome->outcome_date }}
                                </td>
                                <td>
                                    {{ 'Rp' . number_format($outcome->Outcome->outcome_amount, 0, ',', '.') }}
                                </td>
                                <td class="outcome-category">
                                    {{ $outcome->Outcome->outcome_category }}
                                </td>
                                <td>
                                    <a href="{{ route('updateOutcome', ['outcomeId' => $outcome->outcome_id]) }}"
                                        class="btn btn-primary">
                                        {{ __('updateButton') }}
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
        @endif

        <script>
            var currentLang = '{{ app()->getLocale() }}';
            var translations = @json(__('outcomeCategories'));

            function translateCategories(categories) {
                return categories.map(category => translations[category] || category);
            }

            var categoryElements = document.querySelectorAll('.outcome-category');
            categoryElements.forEach(function(element) {
                var originalCategory = element.innerText;
                element.innerText = translations[originalCategory] || originalCategory;
            });
        </script>

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

                window.location.href = '/outcome-table?' + urlParams.toString();
                return false;
            }
        </script>
    </div> --}}

    <div class="content">
        <div class="header">
            <div style="margin: 0 5px">
                <h1>{{ __('outcome') }}</h1>
            </div>
            <div class="search-bar">
                <form action="/outcome-table">
                    <input type="text" id="search" style="width: 750px" placeholder="Search..." name="search"
                        value="{{ request('search') }}">
                    <button style="display: none" type="submit">
                    </button>
                </form>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Filter
                </button>
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Filter</h1>
                            </div>
                            <form action="/outcome-table" method="GET" id="filterForm" onsubmit="return cleanURL()">
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

                <script>
                    var searchInput = document.getElementById('search');
                    searchInput.addEventListener('keydown', function(event) {
                        if (event.key === 'Enter') {
                            if (searchInput.value.trim() === '') {
                                window.location.href = '/outcome-table';
                            }
                        }
                    });

                    document.querySelector('button[type="submit"]').addEventListener('click', function(event) {
                        if (searchInput.value.trim() === '') {
                            window.location.href = '/outcome-table';
                            event.preventDefault();
                        }
                    });
                </script>
            </div>
        </div>
        <table class="outcome-table">
            <thead>
                <tr>
                <tr>
                    <th>
                        {{ __('number') }}
                    </th>
                    <th>
                        {{ __('outcomeName') }}
                    </th>
                    <th>
                        {{ __('outcomeDate') }}
                    </th>
                    <th>
                        {{ __('outcomeAmount') }}
                    </th>
                    <th>
                        {{ __('outcomeCategory') }}
                    </th>
                    <th>
                        {{ __('action') }}
                    </th>
                </tr>
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
                    @foreach ($results as $outcome)
                        <tr>
                            <td>
                                {{ $outcome->nomor_urut }}
                            </td>
                            <td>
                                {{ $outcome->Outcome->outcome_name }}
                            </td>
                            <td>
                                {{ $outcome->Outcome->outcome_date }}
                            </td>
                            <td>
                                {{ 'Rp' . number_format($outcome->Outcome->outcome_amount, 0, ',', '.') }}
                            </td>
                            <td class="outcome-category">
                                {{ $outcome->Outcome->outcome_category }}
                            </td>
                            <td>
                                <a href="{{ route('updateOutcome', ['outcomeId' => $outcome->outcome_id]) }}"
                                    class="btn btn-primary">
                                    {{ __('updateButton') }}
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

            window.location.href = '/outcome-table?' + urlParams.toString();
            return false;
        }
    </script>

    <script>
        var currentLang = '{{ app()->getLocale() }}';
        var translations = @json(__('outcomeCategories'));

        function translateCategories(categories) {
            return categories.map(category => translations[category] || category);
        }

        var categoryElements = document.querySelectorAll('.outcome-category');
        categoryElements.forEach(function(element) {
            var originalCategory = element.innerText;
            element.innerText = translations[originalCategory] || originalCategory;
        });
    </script>
@endsection
