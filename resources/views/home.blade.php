@extends('sidebar.dashboard')
@section('content')
<a href="/firstBalance" class="btn btn-primary">Input First Balance</a>

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
@endsection
