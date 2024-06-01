@extends('sidebar.layout')
@section('content')
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
        }

        .content {
            flex-grow: 1;
            padding: 10px;
            background-color: #f6f8ef;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header .greeting {
            font-size: 24px;
        }

        .header .user-info {
            display: flex;
            align-items: center;
        }

        .header .user-info img {
            border-radius: 50%;
            margin-left: 10px;
        }

        .main-content {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .main-content .left,
        .main-content .right {
            width: 49%;
        }

        .box {
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid black;
            border-radius: 5px;
            text-align: center;
        }

        .box-left {
            width: 50%;
            background-color: white;
            padding: 20px;
            margin-bottom: 10px;
            margin-right: 15px;
            border: 1px solid black;
            border-radius: 5px;
            text-align: center;
        }

        .box-right {
            width: 50%;
            background-color: white;
            padding: 20px;
            margin-bottom: 10px;
            margin-left: 15px;
            border: 1px solid black;
            border-radius: 5px;
            text-align: center;
        }

        .outer-box {
            display: flex;
        }

        .box .status-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .box .status-bar div {
            margin: 5px 0;
        }

        .box,
        .button-box {
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid black;
            border-radius: 5px;
            text-align: center;
        }

        .total-balance {
            height: 100px;
        }

        .recent-transactions {
            height: 187px;
        }

        .buttons {
            display: flex;
            justify-content: center;
            text-align: center;
            margin-bottom: 20px;
            margin-right: 10px;
        }

        .buttons .button-boxleft {
            flex-grow: 1;
            width: 50%;
            margin-right: 10px;
            margin-left: 30px;
            cursor: pointer;
            background-color: #008312;
            color: white;
            border: none;
            padding: 10px;
            justify-content: center;
        }

        .buttons .button-boxright {
            flex-grow: 1;
            width: 50%;
            /* margin-left: 15px; */
            cursor: pointer;
            background-color: #008312;
            color: white;
            border: none;
            padding: 10px;
        }

        .chart {
            justify-content: center;
            align-items: center;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            max-width: 100%;
            margin: auto;
        }

        .chart-container {
            position: relative;
            width: 100%;
            height: 300px;
        }

        @media (max-width: 768px) {
            .chart-container {
                height: 300px;
            }
        }

        @media (max-width: 480px) {
            .chart-container {
                height: 200px;
            }
        }

        .small-button {
            font-size: 10px;
            padding: 5px 10px;
            margin: 5px;
        }

        .recent-transactions ul {
            list-style-type: none;
            padding: 0;
        }

        .recent-transactions ul li {
            margin-bottom: 10px;
        }
    </style>

    {{-- Bagian First Balance  --}}
    @if (!$hasFirstBalance)
        <div class="mb-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#firstBalanceModal">
                {{ __('addFirstBalance') }}
            </button>

            <div class="modal fade modal-form" id="firstBalanceModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <form id="firstBalanceForm" action="{{ route('openFirstBalance.post') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <h2 style="text-align: center">{{ __('addFirstBalance') }}</h2>
                                <div class="form-group">
                                    <div class="filter-label">
                                        <label for="first_balance_amount">{{ __('firstBalanceAmount') }}</label>
                                        <span class="error-message" id="first_balance_amount_empty"></span>
                                    </div>

                                    <div class="filter-inputs">
                                        <input type="number" id="first_balance_amount" name="first_balance_amount">
                                    </div>
                                </div>

                                <div class="buttons" style="margin-top: 50px;">
                                    <button type="submit" class="send">{{ __('addButton') }}</button>

                                    <button type="button" id="cancelBtn" data-bs-dismiss="modal"
                                        class="cancel">{{ __('backButton') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                document.getElementById("firstBalanceForm").addEventListener("submit", function(event) {
                    var firstBalanceAmount = document.getElementById("first_balance_amount");
                    var firstBalanceAmountEmpty = document.getElementById("first_balance_amount_empty");
                    var emptyCount = 0;
                    var firstBalanceEmpty = @json(__('errorFirstBalanceEmpty'))

                    if (firstBalanceAmount.value.trim() === "") {
                        firstBalanceAmountEmpty.textContent = firstBalanceEmpty;
                        firstBalanceAmountEmpty.style.display = "block";
                        emptyCount++;
                    } else {
                        firstBalanceAmountEmpty.style.display = "none";
                    }

                    if (emptyCount > 0) {
                        event.preventDefault();
                    }
                });

                document.getElementById("cancelBtn").addEventListener("click", function() {
                    document.getElementById("first_balance_amount").value = "";

                    document.getElementById("first_balance_amount_empty").innerText = "";
                });
            </script>
        </div>
    @endif

    <!-- Home Content -->
    <div class="content">
        <div class="header">
            <div class="greeting">{{ __('hello') }} {{ Auth::user()->user_full_name }}!</div>

            <div class="user-info">
                <a style="text-decoration: none; font-size: 10px" href="{{ url('locale/id') }}">ID</a>
                <div class="mx-1" style="font-size: 10px">
                    |
                </div>
                <a style="text-decoration: none; font-size: 10px" href="{{ url('locale/en') }}">EN</a>
                &nbsp;|&nbsp;
                <span>{{ Auth::user()->user_full_name }}</span>
                <a href="{{ route('profile', Auth::user()->id) }}">
                    <img src="/image/profile-picturelogo.jpg" alt="Profile Picture" style="width: 40px;">
                </a>
            </div>
        </div>
        <div class="main-content">
            <div class="left">
                <div class="box">
                    <div class="status-bar">
                        <div>Budget: 1000</div>
                        <div>Status:
                            @if ($statusName === 'High Spending' || $statusName === 'Pengeluaran Tinggi')
                                <span style="background-color: red; color: white; padding: 5px; border-radius: 5px;">
                                    {{ $statusName }}
                                </span>
                            @elseif ($statusName === 'Medium Spending' || $statusName === 'Pengeluaran Sedang')
                                <span style="background-color: orange; color: white; padding: 5px; border-radius: 5px;">
                                    {{ $statusName }}
                                </span>
                            @else
                                <span style="background-color: green; color: white; padding: 5px; border-radius: 5px;">
                                    {{ $statusName }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div>you can spend 500 more from your budget</div>
                </div>
                <div class="outer-box">
                    <!-- Total Income -->
                    <div class="box-left">
                        {{ __('totalIncomeMonth') }}
                        <div>
                            <span>{{ 'Rp' . number_format($total_income_per_month, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Total Outflow -->
                    <div class="box-right">
                        {{ __('totalOutcomeMonth') }}
                        <div>
                            <span>{{ 'Rp' . number_format($total_outcome_per_month, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="buttons">
                    <!-- Add Income Button -->
                    <button type="button" class="button-boxleft" data-bs-toggle="modal" data-bs-target="#incomeModal">
                        {{ __('addIncome') }}
                    </button>
                    <!-- Add Income Function -->
                    <div class="modal modal-form" id="incomeModal" tabindex="-1" aria-labelledby="incomeModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form id="incomeForm" action="{{ route('addIncome.post') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <h2 style="text-align: center">{{ __('addIncome') }}</h2>

                                        <div class="form-group mt-4 mb-4">
                                            <div class="filter-label">
                                                <label for="income_name">{{ __('incomeName') }}</label>
                                            </div>

                                            <div class="filter-inputs">
                                                <input type="text" id="income_name" name="income_name">
                                                <span class="error-message" id="income_name_empty"></span>
                                            </div>
                                        </div>

                                        <div class="form-group mt-4 mb-4">
                                            <div class="filter-label">
                                                <label for="income_date">{{ __('incomeDate') }}</label>
                                            </div>

                                            <div class="filter-inputs">
                                                <input type="date" id="income_date" min="{{ date('Y-m-d') }}"
                                                    name="income_date">
                                                <span class="error-message" id="income_date_empty"></span>
                                            </div>
                                        </div>

                                        <div class="form-group mt-4 mb-4">
                                            <div class="filter-label">
                                                <label for="income_amount">{{ __('incomeAmount') }}</label>
                                            </div>

                                            <div class="filter-inputs">
                                                <input type="number" id="income_amount" name="income_amount">
                                                <span class="error-message" id="income_amount_empty"></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="filter-label">
                                                <label for="income_category">{{ __('incomeCategory') }}</label>
                                            </div>

                                            <div class="filter-inputs">
                                                <select id="category" name="income_category" class="form-control"
                                                    aria-label="{{ __('selectCategory') }}">
                                                    <option value="" selected disabled>{{ __('selectCategory') }}
                                                    </option>
                                                    <option value="Gaji Tetap">{{ __('incomeCategory1') }}</option>
                                                    <option value="Pendapatan Pasif">{{ __('incomeCategory2') }}</option>
                                                    <option value="Pendapatan Penjualan">{{ __('incomeCategory3') }}
                                                    </option>
                                                    <option value="Pendapatan Bisnis">{{ __('incomeCategory4') }}</option>
                                                    <option value="Freelance">{{ __('incomeCategory5') }}</option>
                                                    <option value="Bonus">{{ __('incomeCategory6') }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="buttons" style="margin-top: 50px;">
                                            <button type="submit" class="send">{{ __('addButton') }}</button>
                                            <button type="button" id="incomeCancelBtn" data-bs-dismiss="modal"
                                                class="cancel">{{ __('backButton') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.getElementById("incomeCancelBtn").addEventListener("click", function() {
                            document.getElementById("income_name").value = "";
                            document.getElementById("income_date").value = "";
                            document.getElementById("income_amount").value = "";

                            document.getElementById("income_name_empty").textContent = "";
                            document.getElementById("income_date_empty").textContent = "";
                            document.getElementById("income_amount_empty").textContent = "";
                        });

                        document.getElementById("incomeForm").addEventListener("submit", function(event) {
                            var incomeName = document.getElementById("income_name");
                            var incomeDate = document.getElementById("income_date");
                            var incomeAmount = document.getElementById("income_amount");
                            var incomeNameEmpty = document.getElementById("income_name_empty");
                            var incomeDateEmpty = document.getElementById("income_date_empty");
                            var incomeAmountEmpty = document.getElementById("income_amount_empty");
                            var emptyCount = 0;
                            var translations = {
                                nameEmpty: @json(__('errorIncomeNameEmpty')),
                                dateEmpty: @json(__('errorIncomeDateEmpty')),
                                amountEmpty: @json(__('errorIncomeAmountEmpty'))
                            }

                            if (incomeName.value.trim() === "") {
                                incomeNameEmpty.textContent = translations.nameEmpty;
                                incomeNameEmpty.style.display = "block";
                                emptyCount++;
                            } else {
                                incomeNameEmpty.style.display = "none";
                            }

                            if (incomeDate.value.trim() === "") {
                                incomeDateEmpty.textContent = translations.dateEmpty;
                                incomeDateEmpty.style.display = "block";
                                emptyCount++;
                            } else {
                                incomeDateEmpty.style.display = "none";
                            }

                            if (incomeAmount.value.trim() === "") {
                                incomeAmountEmpty.textContent = translations.amountEmpty;
                                incomeAmountEmpty.style.display = "block";
                                emptyCount++;
                            } else {
                                incomeAmountEmpty.style.display = "none";
                            }

                            if (emptyCount > 0) {
                                event.preventDefault();
                            }
                        });
                    </script>
                    <!-- Add Outflow Button -->
                    <button type="button" class="button-boxright" data-bs-toggle="modal"
                        data-bs-target="#outcomeModal">
                        {{ __('addOutcome') }}
                    </button>

                    <!-- Add Outflow Function -->
                </div>
                <div class="box">
                    <div class="chart">
                        <h6>{{ __('incomeChart') }}</h6>
                        <div class="chart-container">
                            <canvas id="incomeChart"></canvas>
                        </div>
                        <button id="prevIncomeChart" class="small-button">{{ __('prevChart') }}</button>
                        <button id="nextIncomeChart" class="small-button">{{ __('nextChart') }}</button>

                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                            var ctxIncome = document.getElementById('incomeChart').getContext('2d');
                            var incomeChartsData = @json($incomeChart);
                            var currentIncomeChart = 0;
                            var incomeFundLabel = @json(__('incomeFund'));
                            var myIncomeChart;
                            var translationDayLabel = @json(__('days'));

                            function updateIncomeChart() {
                                if (myIncomeChart) {
                                    myIncomeChart.destroy();
                                }

                                var currentIncomeChartData = incomeChartsData.charts[currentIncomeChart];
                                var translatedLabels = translateDays(currentIncomeChartData.labels);

                                myIncomeChart = new Chart(ctxIncome, {
                                    type: 'bar',
                                    data: {
                                        labels: translatedLabels,
                                        datasets: [{
                                            label: incomeFundLabel,
                                            data: currentIncomeChartData.amount,
                                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                            borderColor: 'rgba(255, 99, 132, 1)',
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        scales: {
                                            x: {
                                                ticks: {
                                                    maxRotation: 45,
                                                    minRotation: 45,
                                                    autoSkip: true,
                                                    maxTicksLimit: 7
                                                }
                                            },
                                            y: {
                                                beginAtZero: true
                                            }
                                        },
                                        plugins: {
                                            legend: {
                                                display: true,
                                                position: 'top'
                                            }
                                        }
                                    }
                                });
                            }

                            updateIncomeChart();

                            document.getElementById('prevIncomeChart').addEventListener('click', function() {
                                if (currentIncomeChart > 0) {
                                    currentIncomeChart--;
                                    updateIncomeChart();
                                    document.getElementById('nextIncomeChart').disabled = false;
                                }

                                if (currentIncomeChart == 0) {
                                    this.disabled = true;
                                }
                            });

                            document.getElementById('nextIncomeChart').addEventListener('click', function() {
                                if (currentIncomeChart < incomeChartsData.charts.length - 1) {
                                    currentIncomeChart++;
                                    updateIncomeChart();
                                    document.getElementById('prevIncomeChart').disabled = false;
                                }

                                if (currentIncomeChart == incomeChartsData.charts.length - 1) {
                                    this.disabled = true;
                                }
                            });
                            window.addEventListener('resize', function() {
                                updateIncomeChart();
                            });
                        </script>
                    </div>
                </div>
            </div>
            <div class="right">
                <div class="box total-balance">
                    <div>
                        {{ __('totalBalance') }}
                        <div>
                            <span>{{ 'Rp' . number_format($totalBalanceTable, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                <div class="box recent-transactions">
                    <h5>{{ __('recentTransaction') }}</h5>
                    <ul>
                        @foreach ($transactionData as $key => $transaction)
                            <li>
                                Transaksi {{ $key + 1 }} -
                                {{ $transaction->transaction_date }} -
                                Rp{{ number_format($transaction->transaction_amount, 0, ',', '.') }} -
                                <span
                                    class="transaction-type {{ $transaction->transaction_type == 'income' ? 'text-success' : 'text-danger' }}">
                                    {{ ucfirst($transaction->transaction_type) }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="box">
                    <div class="chart">
                        <h6>{{ __('outcomeChart') }}</h6>
                        <div class="chart-container">
                            <canvas id="outcomeChart"></canvas>
                        </div>
                        <button id="prevOutcomeChart" class="small-button">{{ __('prevChart') }}</button>
                        <button id="nextOutcomeChart" class="small-button">{{ __('nextChart') }}</button>

                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                            var ctxOutcome = document.getElementById('outcomeChart').getContext('2d');
                            var outcomeChartsData = @json($outcomeChart);
                            var currentOutcomeChart = 0;
                            var outcomeFundLabel = @json(__('outcomeFund'));
                            var myOutcomeChart;
                            var translationDayLabel = @json(__('days'));

                            function updateOutcomeChart() {
                                if (myOutcomeChart) {
                                    myOutcomeChart.destroy();
                                }

                                var currentOutcomeChartData = outcomeChartsData.charts[currentOutcomeChart];
                                var translatedLabels = translateDays(currentOutcomeChartData.labels);

                                myOutcomeChart = new Chart(ctxOutcome, {
                                    type: 'bar',
                                    data: {
                                        labels: translatedLabels,
                                        datasets: [{
                                            label: outcomeFundLabel,
                                            data: currentOutcomeChartData.amount,
                                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                            borderColor: 'rgba(255, 99, 132, 1)',
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        scales: {
                                            x: {
                                                ticks: {
                                                    maxRotation: 45,
                                                    minRotation: 45,
                                                    autoSkip: true,
                                                    maxTicksLimit: 7
                                                }
                                            },
                                            y: {
                                                beginAtZero: true
                                            }
                                        },
                                        plugins: {
                                            legend: {
                                                display: true,
                                                position: 'top'
                                            }
                                        }
                                    }
                                });
                            }

                            updateOutcomeChart();

                            document.getElementById('prevOutcomeChart').addEventListener('click', function() {
                                if (currentOutcomeChart > 0) {
                                    currentOutcomeChart--;
                                    updateOutcomeChart();
                                    document.getElementById('nextOutcomeChart').disabled = false;
                                }

                                if (currentOutcomeChart == 0) {
                                    this.disabled = true;
                                }
                            });

                            document.getElementById('nextOutcomeChart').addEventListener('click', function() {
                                if (currentOutcomeChart < outcomeChartsData.charts.length - 1) {
                                    currentOutcomeChart++;
                                    updateOutcomeChart();
                                    document.getElementById('prevOutcomeChart').disabled = false;
                                }

                                if (currentOutcomeChart == outcomeChartsData.charts.length - 1) {
                                    this.disabled = true;
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Bagian Tambah Income --}}
    <div class="mb-2">
        {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#incomeModal">
            {{ __('addIncome') }}
        </button> --}}




    </div>

    {{-- Bagian Tambah Outcome --}}
    <div class="mb-2">
        {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#outcomeModal">
            {{ __('addOutcome') }}
        </button> --}}

        <div class="modal modal-form" id="outcomeModal" tabindex="-1" aria-labelledby="outcomeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="outcomeForm" action="{{ route('addOutcome.post') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <h2 style="text-align: center">{{ __('addOutcome') }}</h2>

                            <div class="form-group">
                                <div class="filter-label">
                                    <label for="outcome_name">{{ __('outcomeName') }}</label>
                                </div>

                                <div class="filter-inputs">
                                    <input type="text" id="outcome_name" name="outcome_name">
                                    <span class="error-message" id="outcome_name_empty"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="filter-label">
                                    <label for="outcome_date">{{ __('outcomeDate') }}</label>
                                </div>

                                <div class="filter-inputs">
                                    <input type="date" id="outcome_date" name="outcome_date"
                                        min="{{ date('Y-m-d') }}">
                                    <span class="error-message" id="outcome_date_empty"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="filter-label">
                                    <label for="outcome_amount">{{ __('outcomeAmount') }}</label>
                                </div>

                                <div class="filter-inputs">
                                    <input type="number" id="outcome_amount" name="outcome_amount">
                                    <span class="error-message" id="outcome_amount_empty"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="filter-label">
                                    <label for="outcome_category">{{ __('outcomeCategory') }}</label>
                                </div>

                                <div class="filter-inputs">
                                    <select id="category" name="outcome_category" class="form-control"
                                        aria-label="{{ __('selectCategory') }}">
                                        <option value="" selected disabled>{{ __('selectCategory') }}</option>
                                        <option value="Makanan dan Minuman">{{ __('outcomeCategory1') }}</option>
                                        <option value="Transportasi">{{ __('outcomeCategory2') }}</option>
                                        <option value="Hiburan">{{ __('outcomeCategory3') }}</option>
                                        <option value="Kesehatan">{{ __('outcomeCategory4') }}</option>
                                        <option value="Tempat Tinggal">{{ __('outcomeCategory5') }}</option>
                                        <option value="Pendidikan">{{ __('outcomeCategory6') }}</option>
                                        <option value="Belanja Pribadi">{{ __('outcomeCategory7') }}</option>
                                        <option value="Tagihan dan Pembayaran Rutin">{{ __('outcomeCategory8') }}
                                        </option>
                                        <option value="Liburan dan Wisata">{{ __('outcomeCategory9') }}</option>
                                        <option value="Tabungan dan Investasi">{{ __('outcomeCategory10') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="buttons" style="margin-top: 50px;">
                                <button type="submit" class="send">{{ __('addButton') }}</button>
                                <button type="button" id="outcomeCancelBtn" data-bs-dismiss="modal"
                                    class="cancel">{{ __('backButton') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            document.getElementById("outcomeCancelBtn").addEventListener("click", function() {
                document.getElementById("outcome_name").value = "";
                document.getElementById("outcome_date").value = "";
                document.getElementById("outcome_amount").value = "";

                document.getElementById("outcome_name_empty").textContent = "";
                document.getElementById("outcome_date_empty").textContent = "";
                document.getElementById("outcome_amount_empty").textContent = "";
            });

            document.getElementById("outcomeForm").addEventListener("submit", function(event) {
                var outcomeName = document.getElementById("outcome_name");
                var outcomeDate = document.getElementById("outcome_date");
                var outcomeAmount = document.getElementById("outcome_amount");
                var outcomeNameEmpty = document.getElementById("outcome_name_empty");
                var outcomeDateEmpty = document.getElementById("outcome_date_empty");
                var outcomeAmountEmpty = document.getElementById("outcome_amount_empty");
                var emptyCount = 0;
                var translations = {
                    nameEmpty: @json(__('errorOutcomeNameEmpty')),
                    dateEmpty: @json(__('errorOutcomeDateEmpty')),
                    amountEmpty: @json(__('errorOutcomeAmountEmpty'))
                }

                if (outcomeName.value.trim() === "") {
                    outcomeNameEmpty.textContent = translations.nameEmpty;
                    outcomeNameEmpty.style.display = "block";
                    emptyCount++;
                } else {
                    outcomeNameEmpty.style.display = "none";
                }

                if (outcomeDate.value.trim() === "") {
                    outcomeDateEmpty.textContent = translations.dateEmpty;
                    outcomeDateEmpty.style.display = "block";
                    emptyCount++;
                } else {
                    outcomeDateEmpty.style.display = "none";
                }

                if (outcomeAmount.value.trim() === "") {
                    outcomeAmountEmpty.textContent = translations.amountEmpty;
                    outcomeAmountEmpty.style.display = "block";
                    emptyCount++;
                } else {
                    outcomeAmountEmpty.style.display = "none";
                }

                if (emptyCount > 0) {
                    event.preventDefault();
                }
            });
        </script>
    </div>

    {{-- Bagian Mau Ganti Bahasa --}}
    {{-- <div class="mb-2">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                {{ session()->get('locale', config('app.locale')) }}
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ url('locale/id') }}">id</a></li>
                <li><a class="dropdown-item" href="{{ url('locale/en') }}">en</a></li>
            </ul>
        </div>
    </div> --}}

    <script>
        function translateDays(labels) {
            return labels.map(label => {
                var [day, date] = label.split(', ');
                var translatedDay = translationDayLabel[day] || day;
                var [dayNumber, month, year] = date.split(' ');
                var translatedMonth = translationMonthLabel[month] || month;
                return `${translatedDay}, ${dayNumber} ${translatedMonth} ${year}`;
            });
        }
    </script>

    {{-- Mau Nunjukkin Diagram Pendapatan --}}
    <div class="mt-3">
        {{-- <h1>{{ __('incomeChart') }}</h1>
        <div class="max-width: 600px; margin:auto;">
            <canvas id="incomeChart"></canvas>
        </div>
        <button id="prevIncomeChart">{{ __('prevChart') }}</button>
        <button id="nextIncomeChart">{{ __('nextChart') }}</button> --}}

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            var ctxIncome = document.getElementById('incomeChart').getContext('2d');
            var incomeChartsData = @json($incomeChart);
            var currentIncomeChart = 0;
            var incomeFundLabel = @json(__('incomeFund'));
            var myIncomeChart;
            var translationDayLabel = @json(__('days'));
            var translationMonthLabel = @json(__('months'));

            function updateIncomeChart() {
                if (myIncomeChart) {
                    myIncomeChart.destroy();
                }

                var currentIncomeChartData = incomeChartsData.charts[currentIncomeChart];
                var translatedLabels = translateDays(currentIncomeChartData.labels);

                myIncomeChart = new Chart(ctxIncome, {
                    type: 'bar',
                    data: {
                        labels: translatedLabels,
                        datasets: [{
                            label: incomeFundLabel,
                            data: currentIncomeChartData.amount,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }

            updateIncomeChart();

            document.getElementById('prevIncomeChart').addEventListener('click', function() {
                if (currentIncomeChart > 0) {
                    currentIncomeChart--;
                    updateIncomeChart();
                    document.getElementById('nextIncomeChart').disabled = false;
                }

                if (currentIncomeChart == 0) {
                    this.disabled = true;
                }
            });

            document.getElementById('nextIncomeChart').addEventListener('click', function() {
                if (currentIncomeChart < incomeChartsData.charts.length - 1) {
                    currentIncomeChart++;
                    updateIncomeChart();
                    document.getElementById('prevIncomeChart').disabled = false;
                }

                if (currentIncomeChart == incomeChartsData.charts.length - 1) {
                    this.disabled = true;
                }
            });
            window.addEventListener('resize', function() {
                updateIncomeChart();
            });
        </script>
    </div>

    {{-- Mau Nunjukkin Diagram Pengeluaran --}}
    <div class="mt-3">
        {{-- <h1>{{ __('outcomeChart') }}</h1> --}}
        {{-- <canvas id="outcomeChart" width="400" height="200"></canvas> --}}
        {{-- <button id="prevOutcomeChart">{{ __('prevChart') }}</button>
        <button id="nextOutcomeChart">{{ __('nextChart') }}</button> --}}

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            var ctxOutcome = document.getElementById('outcomeChart').getContext('2d');
            var outcomeChartsData = @json($outcomeChart);
            var currentOutcomeChart = 0;
            var outcomeFundLabel = @json(__('outcomeFund'));
            var myOutcomeChart;
            var translationDayLabel = @json(__('days'));

            function updateOutcomeChart() {
                if (myOutcomeChart) {
                    myOutcomeChart.destroy();
                }

                var currentOutcomeChartData = outcomeChartsData.charts[currentOutcomeChart];
                var translatedLabels = translateDays(currentOutcomeChartData.labels);

                myOutcomeChart = new Chart(ctxOutcome, {
                    type: 'bar',
                    data: {
                        labels: translatedLabels,
                        datasets: [{
                            label: outcomeFundLabel,
                            data: currentOutcomeChartData.amount,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }

            updateOutcomeChart();

            document.getElementById('prevOutcomeChart').addEventListener('click', function() {
                if (currentOutcomeChart > 0) {
                    currentOutcomeChart--;
                    updateOutcomeChart();
                    document.getElementById('nextOutcomeChart').disabled = false;
                }

                if (currentOutcomeChart == 0) {
                    this.disabled = true;
                }
            });

            document.getElementById('nextOutcomeChart').addEventListener('click', function() {
                if (currentOutcomeChart < outcomeChartsData.charts.length - 1) {
                    currentOutcomeChart++;
                    updateOutcomeChart();
                    document.getElementById('prevOutcomeChart').disabled = false;
                }

                if (currentOutcomeChart == outcomeChartsData.charts.length - 1) {
                    this.disabled = true;
                }
            });
        </script>
    </div>
@endsection
