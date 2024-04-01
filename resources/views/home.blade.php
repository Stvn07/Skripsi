@extends('sidebar.dashboard')
@section('content')
    {{-- Bagian First Balance  --}}
    <div class="mb-2">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#firstBalanceModal">
            Tambah First Balance
        </button>

        <div class="modal fade modal-form" id="firstBalanceModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <form action="{{ route('openFirstBalance.post') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <h2 style="text-align: center">Tambah First Balance</h2>
                            <div class="form-group">
                                <div class="filter-label">
                                    <label for="first_balance_amount">First Balance Amount</label>
                                </div>

                                <div class="filter-inputs">
                                    <input type="number" id="first_balance_amount" name="first_balance_amount">
                                </div>
                            </div>

                            <div class="buttons mt-4">
                                <button type="submit" class="send">Tambah</button>

                                <button type="button" data-bs-dismiss="modal" class="cancel">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Bagian Tambah Income --}}
    <div class="mb-2">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#incomeModal">
            Tambah Income
        </button>

        <div class="modal modal-form" id="incomeModal" tabindex="-1" aria-labelledby="incomeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('addIncome.post') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <h2 style="text-align: center">Tambah Income</h2>

                            <div class="form-group">
                                <div class="filter-label">
                                    <label for="income_name">Income Name</label>
                                </div>

                                <div class="filter-inputs">
                                    <input type="text" id="income_name" name="income_name">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="filter-label">
                                    <label for="income_date">Income Date</label>
                                </div>

                                <div class="filter-inputs">
                                    <input type="date" id="income_date" name="income_date">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="filter-label">
                                    <label for="income_amount">Income Amount</label>
                                </div>

                                <div class="filter-inputs">
                                    <input type="number" id="income_amount" name="income_amount">
                                </div>
                            </div>

                            <div class="buttons mt-4">
                                <button type="submit" class="send">Tambah</button>
                                <button type="button" data-bs-dismiss="modal" class="cancel">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Bagian Tambah Outcome --}}
    <div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#outcomeModal">
            Tambah Outcome
        </button>

        <div class="modal modal-form" id="outcomeModal" tabindex="-1" aria-labelledby="outcomeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('addOutcome.post') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <h2 style="text-align: center">Tambah Outcome</h2>

                            <div class="form-group">
                                <div class="filter-label">
                                    <label for="outcome_name">Outcome Name</label>
                                </div>

                                <div class="filter-inputs">
                                    <input type="text" id="outcome_name" name="outcome_name">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="filter-label">
                                    <label for="outcome_date">Outcome Date</label>
                                </div>

                                <div class="filter-inputs">
                                    <input type="date" id="outcome_date" name="outcome_date">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="filter-label">
                                    <label for="outcome_amount">Outcome Amount</label>
                                </div>

                                <div class="filter-inputs">
                                    <input type="number" id="outcome_amount" name="outcome_amount">
                                </div>
                            </div>

                            <div class="buttons mt-4">
                                <button type="submit" class="send">Tambah</button>
                                <button type="button" class="cancel" data-bs-dismiss="modal">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Income --}}
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

    {{-- Tabel Outcome --}}
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

    {{-- Tabel Transaksi --}}
    <div class="mt-3">
        <div class="container-table">
            <form action="/">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search..." name="search"
                        value="{{ request('search') }}">
                    <button class="btn btn-outline-dark" type="submit"><svg xmlns="http://www.w3.org/2000/svg"
                            width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </button>
                </div>
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
                            <button type="reset" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
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
                                    <div class="filter-label">
                                        <label for="start_date">Range Tanggal</label>
                                    </div>

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
                                    <div class="filter-label">
                                        <label for="start_month">Range Bulan</label>
                                    </div>

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
                                    <div class="filter-label">
                                        <label for="start_year">Range Tahun</label>
                                    </div>

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
                                    {{ $transaction->nomor_urut }}
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
            <div class="mt-2">
                {{ $searchResults->withQueryString()->links('pagination::bootstrap-4') }}
            </div>
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
                                    {{ $transaction->nomor_urut }}
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
            <div class="mt-2">
                {{ $results->withQueryString()->links('pagination::bootstrap-4') }}
            </div>
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
                                    {{ $transaction->nomor_urut }}
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
            <div class="mt-2">
                {{ $one_date_results->withQueryString()->links('pagination::bootstrap-4') }}
            </div>
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
                                    {{ $transaction->nomor_urut }}
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
            <div class="mt-2">
                {{ $month_only_results->withQueryString()->links('pagination::bootstrap-4') }}
            </div>
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
            <div class="mt-2">
                {{ $range_month_results->withQueryString()->links('pagination::bootstrap-4') }}
            </div>
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
                                    {{ $transaction->nomor_urut }}
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
            <div class="mt-2">
                {{ $year_only_results->withQueryString()->links('pagination::bootstrap-4') }}
            </div>
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
                                    {{ $transaction->nomor_urut }}
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
            <div class="mt-2">
                {{ $range_year_results->withQueryString()->links('pagination::bootstrap-4') }}
            </div>
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
                                    {{ $transaction->nomor_urut }}
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
            <div class="mt-2">
                {{ $transactionTable->withQueryString()->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>

    {{-- Mau Nunjukkin Total Balance --}}
    <div>
        Total Balance Anda =
        <span>{{ 'Rp' . number_format($totalBalance, 0, ',', '.') }}</span>
    </div>
@endsection
