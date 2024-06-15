@extends('sidebar.layoutReport')
@section('content')
    <style>
        .content {
            flex-grow: 1;
            padding: 10px;
            background-color: #f6f8ef;
        }
    </style>

    <div class="content">
        <form action="/report">
            <label for="bulan">{{ __('selectMonth') }}</label>
            <input type="month" id="bulan" name="bulan" value="{{ request('bulan') }}">
            <button type="submit">{{ __('show') }}</button>
        </form>

        <script>
            function translateCategories(categories) {
                return categories.map(category => {
                    var translatedCategory = translatedCategories[category] || category;
                    return translatedCategory;
                });
            }
        </script>

        <div class="mt-2 mb-2">
            <canvas id="expensesChart" width="400" height="400"></canvas>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                var currentChart = 0;
                var chartData = @json($expensesByCategory);
                var translatedCategories = @json(__('outcomeCategories'));
                var outcomeComment = @json(__('totalOutcome'));
                var newCategories = translateCategories(chartData.map(expense => expense.outcome_category), translatedCategories);
                var ctx = document.getElementById('expensesChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: newCategories,
                        datasets: [{
                            label: outcomeComment,
                            data: [
                                @foreach ($expensesByCategory as $expense)
                                    {{ $expense->total_amount }},
                                @endforeach
                            ],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.6)',
                                'rgba(54, 162, 235, 0.6)',
                                'rgba(255, 206, 86, 0.6)',
                                'rgba(75, 192, 192, 0.6)',
                                'rgba(153, 102, 255, 0.6)',
                                'rgba(255, 159, 64, 0.6)',
                                'rgba(255, 199, 150, 0.6)',
                                'rgba(54, 162, 235, 0.6)',
                                'rgba(255, 206, 86, 0.6)',
                                'rgba(75, 192, 192, 0.6)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(255, 199, 150, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        title: {
                            display: true,
                            text: 'Total Pengeluaran berdasarkan Kategori'
                        }
                    }
                });
            </script>
        </div>

        <div class="mt-2 mb-2">
            <canvas id="incomesChart" width="400" height="400"></canvas>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                var currentChart = 0;
                var chartData = @json($incomesByCategory);
                var translatedCategories = @json(__('incomeCategories'));
                var incomeComment = @json(__('totalIncome'));
                var newCategories = translateCategories(chartData.map(income => income.income_category), translatedCategories);
                var ctx = document.getElementById('incomesChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: newCategories,
                        datasets: [{
                            label: incomeComment,
                            data: [
                                @foreach ($incomesByCategory as $income)
                                    {{ $income->total_amount }},
                                @endforeach
                            ],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.6)',
                                'rgba(54, 162, 235, 0.6)',
                                'rgba(153, 102, 255, 0.6)',
                                'rgba(255, 159, 64, 0.6)',
                                'rgba(54, 162, 235, 0.6)',
                                'rgba(75, 192, 192, 0.6)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(75, 192, 192, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        title: {
                            display: true,
                            text: 'Total Pendapatan berdasarkan Kategori'
                        }
                    }
                });
            </script>
        </div>


        @if (request('bulan'))

            <table class="mt-3 mb-3" style="border: 1px solid black">
                <thead style="text-align: center">
                    <tr>
                        <th>
                            {{ __('transactionDate') }}
                        </th>
                        <th>
                            {{ __('transactionDate') }}
                        </th>
                        <th>
                            {{ __('transactionAmount') }}
                        </th>
                        <th>
                            {{ __('income') }}
                        </th>
                        <th>
                            {{ __('outcome') }}
                        </th>
                        <th>
                            {{ __('finalBalance') }}
                        </th>
                    </tr>
                </thead>
                <tbody style="text-align: center">
                    @if (count($hasil_bulan) === 0)
                        <tr>
                            <td style="height: 250px; background-color: white" colspan="6">{{ __('noDataFound') }}</td>
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
                                        {{ __('income') }}
                                    @else
                                        {{ __('outcome') }}
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
                                        {{ 'Rp' . number_format($transaction->total_balance_per_day, 0, ',', '.') }}
                                    @elseif ($transaction->Outcome)
                                        {{ 'Rp' . number_format($transaction->total_balance_per_day, 0, ',', '.') }}
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
    </div>

@endsection
