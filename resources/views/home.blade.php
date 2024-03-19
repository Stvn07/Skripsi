@extends('sidebar.dashboard')
@section('content')
<div class="mb-2">
    <a href="{{route('openFirstBalance')}}" class="btn btn-primary">Input First Balance</a>
</div>

<div class="mb-2">
    <a href="{{route('addIncome')}}" class="btn btn-primary">Add Income</a>
</div>

<div>
    <a href="{{route('addOutcome')}}" class="btn btn-primary">Add Outcome</a>
</div>

@foreach ($firstBalances as $firstBalance)
<ul>
    <li>
        {{$firstBalance->first_balance_amount}}
    </li>
</ul>
@endforeach
<ol>
    <li>
Sum Balance: RP. {{$sumBalance}},00
    </li>
    <li>
        Average Balance: RP. {{$averageBalance}},00
    </li>
    <li>
        Total Balance: RP. {{$totalBalance}},00
    </li>
    <li>
        {{$manyBalance}}
    </li>
</ol>

{{$incomeTable}}

{{$incomeTableJan}}

<div class="mt-3">
    <table style="border: 1px solid black">
        <tr>
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

        @foreach ($incomeTable as $income)
        <tr>
            <td>
                {{$income->income_name}}
            </td>

            <td>
                {{$income->income_date}}
            </td>

            <td>
                {{ 'Rp' . number_format($income->income_amount, 0, ',', '.') }}
            </td>
        </tr>
    @endforeach
    </table>

</div>
@endsection
