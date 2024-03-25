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
                    <button class="btn btn-outline-dark" type="submit"><svg xmlns="http://www.w3.org/2000/svg"
                            width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </button>
                </div>
            </form>

            <form class="mt-3" action="/">
                <div class="input-group mb-3">
                    <input type="date" class="form-control" placeholder="Search..." name="first_date"
                        value="{{ request('first_date') }}">
                    <input type="date" class="form-control" placeholder="Search..." name="second_date"
                        value="{{ request('second_date') }}">
                    <button class="btn btn-outline-dark" type="submit"><svg xmlns="http://www.w3.org/2000/svg"
                            width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </button>
                </div>
            </form>
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
        @elseif (request('first_date') && request('second_date'))
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
