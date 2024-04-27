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

                                <button type="button" id="cancelBtn" data-bs-dismiss="modal" class="cancel">Batal</button>
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
                            <td>
                                <a href="{{ route('updateIncome', ['incomeId' => $income->id]) }}"
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
                        Action
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
                            <td>
                                <a href="{{ route('updateOutcome', ['outcomeId' => $outcome->id]) }}"
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

    {{-- Mau Nunjukkin Total Balance --}}
    <div>
        Total Balance Anda =
        <div>
            <span>{{ 'Rp' . number_format($totalBalanceTable, 0, ',', '.') }}</span>
        </div>
    </div>
@endsection
