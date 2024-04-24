@extends('sidebar.dashboard')
@section('content')
    <form action="/report">
        <label for="bulan">Pilih Bulan:</label>
        <input type="month" id="bulan" name="bulan" value="{{ request('bulan') }}">
        <button type="submit">Tampilkan</button>
    </form>

    @if (request('bulan'))

        <table style="border: 1px solid black">
            <thead style="text-align: center">
                <tr>
                    <th>
                        Transaction Date
                    </th>
                    <th>
                        Transaction Amount
                    </th>
                    <th>
                        Transaction Type
                    </th>
                    <th>
                        Income
                    </th>
                    <th>
                        Outcome
                    </th>
                    <th>
                        Saldo Akhir
                    </th>
                </tr>
            </thead>
            <tbody style="text-align: center">
                @if (count($hasil_bulan) === 0)
                    <tr>
                        <td style="height: 250px; background-color: white" colspan="6">Data tidak ditemukan.</td>
                    </tr>
                @else
                    @foreach ($hasil_bulan as $transaction)
                        <tr>
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
                            <td>
                                {{ $transaction->Income ? $transaction->Income->income_name : '-' }}
                            </td>
                            <td>
                                {{ $transaction->Outcome ? $transaction->Outcome->outcome_name : '-' }}
                            </td>
                            <td>
                                @if ($transaction->Income)
                                    {{ 'Rp' . number_format($transaction->TotalBalance->total_balance_amount, 0, ',', '.') }}
                                @elseif ($transaction->Outcome)
                                    {{ 'Rp' . number_format($transaction->TotalBalance->total_balance_amount, 0, ',', '.') }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <td colspan="3" style="text-align: center;"><b>Total</b></td>
                    <td>
                        {{ 'Rp' . number_format($total_income_bulan, 0, ',', '.') }}
                    </td>
                    <td>
                        {{ 'Rp' . number_format($total_outcome_bulan, 0, ',', '.') }}
                    </td>
                    <td>
                        {{ 'Rp' . number_format($total_final_balance_bulan->total_balance_amount, 0, ',', '.') }}
                    </td>
                @endif
            </tbody>
        </table>
    @endif
@endsection
