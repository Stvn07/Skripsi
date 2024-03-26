@extends('sidebar.dashboard')
@section('content')
    <div class="mb-2">
        <a href="{{ route('openFirstBalance') }}" class="btn btn-primary">Input First Balance</a>
    </div>

    <div class="mb-2">
        <a href="{{ route('addIncome') }}" class="btn btn-primary">Add Income</a>
    </div>

    <div>
        <a href="{{ route('addOutcome') }}" class="btn btn-primary">Add Outcome</a>
    </div>
    {{-- @foreach ($firstBalances as $firstBalance)
<ul>
    <li>
        {{$firstBalance->first_balance_amount}}
    </li>
</ul>
@endforeach --}}


    {{-- Total Balance: {{ 'Rp' . number_format($totalBalance, 0, ',', '.') }} --}}

    <div class="mt-3">
        <table style="border: 1px solid black">
            <thead style="text-align: center">
                <tr>
                    <th>
                        No
                    </th>
                    <th>
                        Income Name
                    </th>
                    <th>
                        Income Date
                    </th>
                    <th>
                        Income Amount
                    </th>
                </tr>
            </thead>
            <tbody style="text-align: center">
                @if (count($incomeTable) === 0)
                    <tr>
                        <td colspan="4">Belum ada data income yang ditambahkan.</td>
                    </tr>
                @else
                    @foreach ($incomeTable as $income)
                        <tr>
                            <td>
                                {{ $income->id }}
                            </td>
                            <td>
                                {{ $income->income_name }}
                            </td>

                            <td>
                                {{ $income->income_date }}
                            </td>

                            <td>
                                {{ 'Rp' . number_format($income->income_amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        <table style="border: 1px solid black">
            <thead style="text-align: center">
                <tr>
                    <th>
                        No
                    </th>
                    <th>
                        Outcome Name
                    </th>
                    <th>
                        Outcome Date
                    </th>
                    <th>
                        Outcome Amount
                    </th>
                </tr>
            </thead>
            <tbody style="text-align: center">
                @if (count($outcomeTable) === 0)
                    <tr>
                        <td colspan="4">Belum ada data outcome yang ditambahkan.</td>
                    </tr>
                @else
                    @foreach ($outcomeTable as $outcome)
                        <tr>
                            <td>
                                {{ $outcome->id }}
                            </td>
                            <td>
                                {{ $outcome->outcome_name }}
                            </td>

                            <td>
                                {{ $outcome->outcome_date }}
                            </td>

                            <td>
                                {{ 'Rp' . number_format($outcome->outcome_amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        <div class="container-table">
            <form action="/">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search..." name="search"
                        value="{{ request('search') }}">
                    {{-- <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                    <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                    <input type="date" class="form-control" name="one_date" value="{{ request('one_date') }}">
                    <input type="month" class="form-control" name="month_only" value="{{ request('month_only') }}">
                    <input type="month" class="form-control" name="start_month" value="{{ request('start_only') }}">
                    <input type="month" class="form-control" name="end_month" value="{{ request('end_only') }}">
                    <input type="number" min="1900" max="{{ date('Y') }}" class="form-control" name="year_only"
                        value="{{ request('year_only') }}">
                    <input type="number" min="1900" max="{{ date('Y') }}" class="form-control" name="start_year"
                        value="{{ request('start_year') }}">
                    <input type="number" min="1900" max="{{ date('Y') }}" class="form-control" name="end_year"
                        value="{{ request('end_year') }}"> --}}
                    <button class="btn btn-outline-dark" type="submit"><svg xmlns="http://www.w3.org/2000/svg"
                            width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </button>
                </div>
            </form>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Filter
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Filter</h1>
                            <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/">
                            <div class="modal-body">
                                <h3>Filter Data Berdasarkan</h3>

                                <div class="filter-container mt-4 mb-4">
                                    <div class="filter-label">
                                        <label for="one_date">Hari</label>
                                    </div>

                                    <div class="filter-inputs">
                                        <input type="date" class="form-control" id="one_date" name="one_date"
                                            value="{{ request('one_date') }}">
                                    </div>
                                </div>

                                <div class="filter-container mt-4 mb-4">
                                    <!-- Label untuk filter -->
                                    <div class="filter-label">
                                        <label for="start_date">Range Tanggal</label>
                                    </div>

                                    <!-- Field tanggal awal dan akhir -->
                                    <div class="filter-inputs">
                                        <input type="date" class="form-control" id="start_date" name="start_date"
                                            placeholder="Pilih tanggal awal" value="{{ request('start_date') }}">
                                    </div>
                                    <span class=>sampai</span>
                                    <div class="filter-inputs">
                                        <input type="date" class="form-control" id="end_date" name="end_date"
                                            placeholder="Pilih tanggal akhir" value="{{ request('end_date') }}">
                                    </div>
                                </div>

                                <div class="filter-container mt-4 mb-4">
                                    <div class="filter-label">
                                        <label for="month_only">Bulan</label>
                                    </div>

                                    <div class="filter-inputs">
                                        <input type="month" class="form-control" id="month_only" name="month_only"
                                            value="{{ request('month_only') }}">
                                    </div>
                                </div>

                                <div class="filter-container mt-4 mb-4">
                                    <!-- Label untuk filter -->
                                    <div class="filter-label">
                                        <label for="start_month">Range Bulan</label>
                                    </div>

                                    <!-- Field tanggal awal dan akhir -->
                                    <div class="filter-inputs">
                                        <input type="month" class="form-control" id="start_month" name="start_month"
                                            value="{{ request('start_only') }}">
                                    </div>
                                    <span class=>sampai</span>
                                    <div class="filter-inputs">
                                        <input type="month" class="form-control" id="end_month" name="end_month"
                                            value="{{ request('end_only') }}">
                                    </div>
                                </div>

                                <div class="filter-container mt-4 mb-4">
                                    <div class="filter-label">
                                        <label for="year_only">Tahun</label>
                                    </div>

                                    <div class="filter-inputs">
                                        <input type="number" min="1900" max="{{ date('Y') }}"
                                            class="form-control" id="year_only" name="year_only"
                                            value="{{ request('year_only') }}">
                                    </div>
                                </div>

                                <div class="filter-container mt-4 mb-4">
                                    <!-- Label untuk filter -->
                                    <div class="filter-label">
                                        <label for="start_year">Range Tahun</label>
                                    </div>

                                    <!-- Field tanggal awal dan akhir -->
                                    <div class="filter-inputs">
                                        <input type="number" min="1900" max="{{ date('Y') }}"
                                            class="form-control" id="start_year" name="start_year"
                                            value="{{ request('start_year') }}">
                                    </div>
                                    <span class=>sampai</span>
                                    <div class="filter-inputs">
                                        <input type="number" min="1900" max="{{ date('Y') }}"
                                            class="form-control" id="end_year" name="end_year"
                                            value="{{ request('end_year') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
                            No
                        </th>
                        <th>
                            Transaction Date
                        </th>
                        <th>
                            Transaction Amount
                        </th>
                        <th>
                            Transaction Type
                        </th>
                    </tr>
                </thead>
                <tbody style="text-align: center">
                    @if (count($searchResults) === 0)
                        <tr>
                            <td style="height: 250px; background-color: white" colspan="4">Data tidak ditemukan.</td>
                        </tr>
                    @else
                        @foreach ($searchResults as $transaction)
                            <tr>
                                <td>
                                    {{ $transaction->id }}
                                </td>
                                <td>
                                    {{ $transaction->transaction_date }}
                                </td>

                                <td>
                                    {{ 'Rp' . number_format($transaction->transaction_amount, 0, ',', '.') }}
                                </td>

                                <td class="{{ $transaction->income_id ? 'green-text' : 'red-text' }}">
                                    @if ($transaction->income_id)
                                        INCOME
                                    @else
                                        OUTCOME
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        @elseif (request('start_date') && request('end_date'))
            <table style="border: 1px solid black">
                <thead style="text-align: center">
                    <tr>
                        <th>
                            No
                        </th>
                        <th>
                            Transaction Date
                        </th>
                        <th>
                            Transaction Amount
                        </th>
                        <th>
                            Transaction Type
                        </th>
                    </tr>
                </thead>
                <tbody style="text-align: center">
                    @if (count($results) === 0)
                        <tr>
                            <td style="height: 250px; background-color: white" colspan="4">Data tidak ditemukan.</td>
                        </tr>
                    @else
                        @foreach ($results as $transaction)
                            <tr>
                                <td>
                                    {{ $transaction->id }}
                                </td>
                                <td>
                                    {{ $transaction->transaction_date }}
                                </td>

                                <td>
                                    {{ 'Rp' . number_format($transaction->transaction_amount, 0, ',', '.') }}
                                </td>

                                <td class="{{ $transaction->income_id ? 'green-text' : 'red-text' }}">
                                    @if ($transaction->income_id)
                                        INCOME
                                    @else
                                        OUTCOME
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        @elseif (request('one_date'))
            <table style="border: 1px solid black">
                <thead style="text-align: center">
                    <tr>
                        <th>
                            No
                        </th>
                        <th>
                            Transaction Date
                        </th>
                        <th>
                            Transaction Amount
                        </th>
                        <th>
                            Transaction Type
                        </th>
                    </tr>
                </thead>
                <tbody style="text-align: center">
                    @if (count($one_date_results) === 0)
                        <tr>
                            <td style="height: 250px; background-color: white" colspan="4">Data tidak ditemukan.</td>
                        </tr>
                    @else
                        @foreach ($one_date_results as $transaction)
                            <tr>
                                <td>
                                    {{ $transaction->id }}
                                </td>
                                <td>
                                    {{ $transaction->transaction_date }}
                                </td>

                                <td>
                                    {{ 'Rp' . number_format($transaction->transaction_amount, 0, ',', '.') }}
                                </td>

                                <td class="{{ $transaction->income_id ? 'green-text' : 'red-text' }}">
                                    @if ($transaction->income_id)
                                        INCOME
                                    @else
                                        OUTCOME
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        @elseif (request('month_only'))
            <table style="border: 1px solid black">
                <thead style="text-align: center">
                    <tr>
                        <th>
                            No
                        </th>
                        <th>
                            Transaction Date
                        </th>
                        <th>
                            Transaction Amount
                        </th>
                        <th>
                            Transaction Type
                        </th>
                    </tr>
                </thead>
                <tbody style="text-align: center">
                    @if (count($month_only_results) === 0)
                        <tr>
                            <td style="height: 250px; background-color: white" colspan="4">Data tidak ditemukan.</td>
                        </tr>
                    @else
                        @foreach ($month_only_results as $transaction)
                            <tr>
                                <td>
                                    {{ $transaction->id }}
                                </td>
                                <td>
                                    {{ $transaction->transaction_date }}
                                </td>

                                <td>
                                    {{ 'Rp' . number_format($transaction->transaction_amount, 0, ',', '.') }}
                                </td>

                                <td class="{{ $transaction->income_id ? 'green-text' : 'red-text' }}">
                                    @if ($transaction->income_id)
                                        INCOME
                                    @else
                                        OUTCOME
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        @elseif (request('start_month') && request('end_month'))
            <table style="border: 1px solid black">
                <thead style="text-align: center">
                    <tr>
                        <th>
                            No
                        </th>
                        <th>
                            Transaction Date
                        </th>
                        <th>
                            Transaction Amount
                        </th>
                        <th>
                            Transaction Type
                        </th>
                    </tr>
                </thead>
                <tbody style="text-align: center">
                    @if (count($range_month_results) === 0)
                        <tr>
                            <td style="height: 250px; background-color: white" colspan="4">Data tidak ditemukan.</td>
                        </tr>
                    @else
                        @foreach ($range_month_results as $transaction)
                            <tr>
                                <td>
                                    {{ $transaction->id }}
                                </td>
                                <td>
                                    {{ $transaction->transaction_date }}
                                </td>

                                <td>
                                    {{ 'Rp' . number_format($transaction->transaction_amount, 0, ',', '.') }}
                                </td>

                                <td class="{{ $transaction->income_id ? 'green-text' : 'red-text' }}">
                                    @if ($transaction->income_id)
                                        INCOME
                                    @else
                                        OUTCOME
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        @elseif (request('year_only'))
            <table style="border: 1px solid black">
                <thead style="text-align: center">
                    <tr>
                        <th>
                            No
                        </th>
                        <th>
                            Transaction Date
                        </th>
                        <th>
                            Transaction Amount
                        </th>
                        <th>
                            Transaction Type
                        </th>
                    </tr>
                </thead>
                <tbody style="text-align: center">
                    @if (count($year_only_results) === 0)
                        <tr>
                            <td style="height: 250px; background-color: white" colspan="4">Data tidak ditemukan.</td>
                        </tr>
                    @else
                        @foreach ($year_only_results as $transaction)
                            <tr>
                                <td>
                                    {{ $transaction->id }}
                                </td>
                                <td>
                                    {{ $transaction->transaction_date }}
                                </td>

                                <td>
                                    {{ 'Rp' . number_format($transaction->transaction_amount, 0, ',', '.') }}
                                </td>

                                <td class="{{ $transaction->income_id ? 'green-text' : 'red-text' }}">
                                    @if ($transaction->income_id)
                                        INCOME
                                    @else
                                        OUTCOME
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        @elseif (request('start_year') && request('end_year'))
            <table style="border: 1px solid black">
                <thead style="text-align: center">
                    <tr>
                        <th>
                            No
                        </th>
                        <th>
                            Transaction Date
                        </th>
                        <th>
                            Transaction Amount
                        </th>
                        <th>
                            Transaction Type
                        </th>
                    </tr>
                </thead>
                <tbody style="text-align: center">
                    @if (count($range_year_results) === 0)
                        <tr>
                            <td style="height: 250px; background-color: white" colspan="4">Data tidak ditemukan.</td>
                        </tr>
                    @else
                        @foreach ($range_year_results as $transaction)
                            <tr>
                                <td>
                                    {{ $transaction->id }}
                                </td>
                                <td>
                                    {{ $transaction->transaction_date }}
                                </td>

                                <td>
                                    {{ 'Rp' . number_format($transaction->transaction_amount, 0, ',', '.') }}
                                </td>

                                <td class="{{ $transaction->income_id ? 'green-text' : 'red-text' }}">
                                    @if ($transaction->income_id)
                                        INCOME
                                    @else
                                        OUTCOME
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        @else
            <table style="border: 1px solid black">
                <thead style="text-align: center">
                    <tr>
                        <th>
                            No
                        </th>
                        <th>
                            Transaction Date
                        </th>
                        <th>
                            Transaction Amount
                        </th>
                        <th>
                            Transaction Type
                        </th>
                    </tr>
                </thead>
                <tbody style="text-align: center">
                    @if (count($transactionTable) === 0)
                        <tr>
                            <td colspan="4">Belum ada data transaction yang ditambahkan.</td>
                        </tr>
                    @else
                        @foreach ($transactionTable as $transaction)
                            <tr>
                                <td>
                                    {{ $transaction->id }}
                                </td>
                                <td>
                                    {{ $transaction->transaction_date }}
                                </td>

                                <td>
                                    {{ 'Rp' . number_format($transaction->transaction_amount, 0, ',', '.') }}
                                </td>

                                <td class="{{ $transaction->income_id ? 'green-text' : 'red-text' }}">
                                    @if ($transaction->income_id)
                                        INCOME
                                    @else
                                        OUTCOME
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        @endif
    </div>
@endsection
