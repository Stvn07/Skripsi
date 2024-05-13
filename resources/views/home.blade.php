@extends('sidebar.dashboard')
@section('content')
    {{-- Bagian First Balance  --}}
    @if (!$hasFirstBalance)
        <div class="mb-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#firstBalanceModal">
                Tambah First Balance
            </button>

            <div class="modal fade modal-form" id="firstBalanceModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <form id="firstBalanceForm" action="{{ route('openFirstBalance.post') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <h2 style="text-align: center">Tambah First Balance</h2>
                                <div class="form-group">
                                    <div class="filter-label">
                                        <label for="first_balance_amount">First Balance Amount</label>
                                        <span class="error-message" id="first_balance_amount_empty"></span>
                                    </div>

                                    <div class="filter-inputs">
                                        <input type="number" id="first_balance_amount" name="first_balance_amount">
                                    </div>
                                </div>

                                <div class="buttons" style="margin-top: 50px;">
                                    <button type="submit" class="send">Tambah</button>

                                    <button type="button" id="cancelBtn" data-bs-dismiss="modal"
                                        class="cancel">Batal</button>
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

                    if (firstBalanceAmount.value.trim() === "") {
                        firstBalanceAmountEmpty.textContent = "First Balance tidak boleh kosong";
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

    {{-- Bagian Tambah Income --}}
    <div class="mb-2">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#incomeModal">
            Tambah Income
        </button>

        <div class="modal modal-form" id="incomeModal" tabindex="-1" aria-labelledby="incomeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="incomeForm" action="{{ route('addIncome.post') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <h2 style="text-align: center">Tambah Income</h2>

                            <div class="form-group">
                                <div class="filter-label">
                                    <label for="income_name">Income Name</label>
                                </div>

                                <div class="filter-inputs">
                                    <input type="text" id="income_name" name="income_name">
                                    <span class="error-message" id="income_name_empty"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="filter-label">
                                    <label for="income_date">Income Date</label>
                                </div>

                                <div class="filter-inputs">
                                    <input type="date" id="income_date" name="income_date">
                                    <span class="error-message" id="income_date_empty"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="filter-label">
                                    <label for="income_amount">Income Amount</label>
                                </div>

                                <div class="filter-inputs">
                                    <input type="number" id="income_amount" name="income_amount">
                                    <span class="error-message" id="income_amount_empty"></span>
                                </div>
                            </div>

                            <div class="buttons" style="margin-top: 50px;">
                                <button type="submit" class="send">Tambah</button>
                                <button type="button" id="cancelBtn" data-bs-dismiss="modal" class="cancel">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            document.getElementById("cancelBtn").addEventListener("click", function() {
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

                if (incomeName.value.trim() === "") {
                    incomeNameEmpty.textContent = "Income Name tidak boleh kosong";
                    incomeNameEmpty.style.display = "block";
                    emptyCount++;
                } else {
                    incomeNameEmpty.style.display = "none";
                }

                if (incomeDate.value.trim() === "") {
                    incomeDateEmpty.textContent = "Income Date tidak boleh kosong";
                    incomeDateEmpty.style.display = "block";
                    emptyCount++;
                } else {
                    incomeDateEmpty.style.display = "none";
                }

                if (incomeAmount.value.trim() === "") {
                    incomeAmountEmpty.textContent = "Income Amount tidak boleh kosong";
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
                    <form id="outcomeForm" action="{{ route('addOutcome.post') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <h2 style="text-align: center">Tambah Outcome</h2>

                            <div class="form-group">
                                <div class="filter-label">
                                    <label for="outcome_name">Outcome Name</label>
                                </div>

                                <div class="filter-inputs">
                                    <input type="text" id="outcome_name" name="outcome_name">
                                    <span class="error-message" id="outcome_name_empty"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="filter-label">
                                    <label for="outcome_date">Outcome Date</label>
                                </div>

                                <div class="filter-inputs">
                                    <input type="date" id="outcome_date" name="outcome_date">
                                    <span class="error-message" id="outcome_date_empty"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="filter-label">
                                    <label for="outcome_amount">Outcome Amount</label>
                                </div>

                                <div class="filter-inputs">
                                    <input type="number" id="outcome_amount" name="outcome_amount">
                                    <span class="error-message" id="outcome_amount_empty"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="filter-label">
                                    <label for="outcome_category">Outcome Category</label>
                                </div>

                                <div class="filter-inputs">
                                    <select id="category" name="outcome_category" class="form-control">
                                        <option value="" selected disabled>Pilih kategori</option>
                                        <option value="Makanan dan Minuman">Makanan dan Minuman</option>
                                        <option value="Transportasi">Transportasi</option>
                                        <option value="Hiburan">Hiburan</option>
                                        <option value="Kesehatan">Kesehatan</option>
                                        <option value="Tempat Tinggal">Tempat Tinggal</option>
                                        <option value="Pendidikan">Pendidikan</option>
                                        <option value="Belanja Pribadi">Belanja Pribadi</option>
                                        <option value="Tagihan dan Pembayaran Rutin">Tagihan dan Pembayaran Rutin</option>
                                        <option value="Liburan dan Wisata">Liburan dan Wisata</option>
                                        <option value="Tabungan dan Investasi">Tabungan dan Investasi</option>
                                        <option value="Pajak dan Biaya Hukum">Pajak dan Biaya Hukum</option>
                                    </select>
                                </div>
                            </div>

                            <div class="buttons" style="margin-top: 50px;">
                                <button type="submit" class="send">Tambah</button>
                                <button type="button" id="cancelBtn" class="cancel"
                                    data-bs-dismiss="modal">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            document.getElementById("outcomeForm").addEventListener("submit", function(event) {
                var outcomeName = document.getElementById("outcome_name");
                var outcomeDate = document.getElementById("outcome_date");
                var outcomeAmount = document.getElementById("outcome_amount");
                var outcomeNameEmpty = document.getElementById("outcome_name_empty");
                var outcomeDateEmpty = document.getElementById("outcome_date_empty");
                var outcomeAmountEmpty = document.getElementById("outcome_amount_empty");
                var emptyCount = 0;

                if (outcomeName.value.trim() === "") {
                    outcomeNameEmpty.textContent = "Outcome Name tidak boleh kosong";
                    outcomeNameEmpty.style.display = "block";
                    emptyCount++;
                } else {
                    outcomeNameEmpty.style.display = "none";
                }

                if (outcomeDate.value.trim() === "") {
                    outcomeDateEmpty.textContent = "Outcome Date tidak boleh kosong";
                    outcomeDateEmpty.style.display = "block";
                    emptyCount++;
                } else {
                    outcomeDateEmpty.style.display = "none";
                }

                if (outcomeAmount.value.trim() === "") {
                    outcomeAmountEmpty.textContent = "Outcome Amount tidak boleh kosong";
                    outcomeAmountEmpty.style.display = "block";
                    emptyCount++;
                } else {
                    outcomeAmountEmpty.style.display = "none";
                }

                if (emptyCount > 0) {
                    event.preventDefault();
                }
            });

            document.getElementById("cancelBtn").addEventListener("click", function() {
                document.getElementById("outcome_name").value = "";
                document.getElementById("outcome_date").value = "";
                document.getElementById("outcome_amount").value = "";

                document.getElementById("outcome_name_empty").innerText = "";
                document.getElementById("outcome_date_empty").innerText = "";
                document.getElementById("outcome_amount_empty").innerText = "";
            });
        </script>
    </div>

    <div>
        Status Pengeluaran Anda: {{ $statusName }}
    </div>

    <div>
        Total Pendapatan di bulan Ini: {{ $total_income_per_month }}
    </div>

    <div>
        Total Pengeluaran di bulan ini: {{ $total_outcome_per_month }}
    </div>

    {{-- Mau Nunjukkin Total Balance --}}
    <div>
        Total Balance Anda =
        <div>
            <span>{{ 'Rp' . number_format($totalBalanceTable, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="mb-4">
        <h4>Riwayat Transaksi</h4>
        <ul>
            @foreach ($transactionData as $key => $transaction)
                <li>
                    Transaksi {{ $key + 1 }} -
                    {{ $transaction->transaction_date }} -
                    Rp{{ number_format($transaction->transaction_amount, 0, ',', '.') }} -
                    <span class="{{ $transaction->transaction_type == 'income' ? 'text-success' : 'text-danger' }}">
                        {{ ucfirst($transaction->transaction_type) }}
                    </span>
                </li>
            @endforeach
        </ul>
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
                    <th>
                        Action
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
                                {{ $income->number }}
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
                            <td>
                                <a href="{{ route('updateIncome', ['incomeId' => $income->income_id]) }}"
                                    class="btn btn-primary">
                                    Update
                                </a>
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
                    <th>
                        Outcome Category
                    </th>
                    <th>
                        Action
                    </th>
                </tr>
            </thead>
            <tbody style="text-align: center">
                @if (count($outcomeTable) === 0)
                    <tr>
                        <td colspan="6">Belum ada data outcome yang ditambahkan.</td>
                    </tr>
                @else
                    @foreach ($outcomeTable as $outcome)
                        <tr>
                            <td>
                                {{ $outcome->number }}
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
                            <td>
                                {{ $outcome->Outcome->outcome_category }}
                            </td>
                            <td>
                                <a href="{{ route('updateOutcome', ['outcomeId' => $outcome->outcome_id]) }}"
                                    class="btn btn-primary">
                                    Update
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        <h1>Diagram Pendapatan</h1>
        <canvas id="incomeChart" width="400" height="200"></canvas>
        <button id="prevIncomeChart">Previous Chart</button>
        <button id="nextIncomeChart">Next Chart</button>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            var ctxIncome = document.getElementById('incomeChart').getContext('2d');
            var incomeChartsData = @json($incomeChart);
            var currentIncomeChart = 0;
            var myIncomeChart; // Deklarasi variabel myChart di luar fungsi

            function updateIncomeChart() {
                if (myIncomeChart) {
                    myIncomeChart.destroy(); // Hapus chart yang ada sebelumnya
                }

                var currentIncomeChartData = incomeChartsData.charts[currentIncomeChart];
                myIncomeChart = new Chart(ctxIncome, {
                    type: 'bar',
                    data: {
                        labels: currentIncomeChartData.labels,
                        datasets: [{
                            label: 'Dana Yang Didapatkan',
                            data: currentIncomeChartData.amount,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            }

            // Memperbarui chart saat halaman dimuat
            updateIncomeChart();

            // Tombol "Previous Chart" untuk pendapatan
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

            // Tombol "Next Chart" untuk pendapatan
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
        </script>
    </div>


    <div class="mt-3">
        <h1>Diagram Pengeluaran</h1>
        <canvas id="outcomeChart" width="400" height="200"></canvas>
        <button id="prevOutcomeChart">Previous Chart</button>
        <button id="nextOutcomeChart">Next Chart</button>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            var ctxOutcome = document.getElementById('outcomeChart').getContext('2d');
            var outcomeChartsData = @json($outcomeChart);
            var currentOutcomeChart = 0;
            var myOutcomeChart; // Deklarasi variabel myChart di luar fungsi

            function updateOutcomeChart() {
                if (myOutcomeChart) {
                    myOutcomeChart.destroy(); // Hapus chart yang ada sebelumnya
                }

                var currentOutcomeChartData = outcomeChartsData.charts[currentOutcomeChart];
                myOutcomeChart = new Chart(ctxOutcome, {
                    type: 'bar',
                    data: {
                        labels: currentOutcomeChartData.labels,
                        datasets: [{
                            label: 'Dana Yang Dikeluarkan',
                            data: currentOutcomeChartData.amount,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            }

            // Memperbarui chart saat halaman dimuat
            updateOutcomeChart();

            // Tombol "Previous Chart" untuk pengeluaran
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

            // Tombol "Next Chart" untuk pengeluaran
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
