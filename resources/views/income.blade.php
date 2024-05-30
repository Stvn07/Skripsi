@extends('sidebar.layout')
@section('content')
    <style>
        .content {
            flex-grow: 1;
            padding: 10px;
            background-color: #f6f8ef;
        }
    </style>
    <div class="content">
        <h1>{{ __('income') }}</h1>
        <table style="border: 1px solid black">
            <thead style="text-align: center">
                <tr>
                    <th>
                        {{ __('number') }}
                    </th>
                    <th>
                        {{ __('incomeName') }}
                    </th>
                    <th>
                        {{ __('incomeDate') }}
                    </th>
                    <th>
                        {{ __('incomeAmount') }}
                    </th>
                    <th>
                        {{ __('incomeCategory') }}
                    </th>
                    <th>
                        {{ __('action') }}
                    </th>
                </tr>
            </thead>
            <tbody style="text-align: center">
                @if (count($incomeTable) === 0)
                    <tr>
                        <td colspan="6">{{ __('noIncomeData') }}</td>
                    </tr>
                @else
                    @foreach ($incomeTable as $income)
                        <tr>
                            <td>
                                {{ $income->nomor_urut }}
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
                            <td class="income-category">
                                {{ $income->Income->income_category }}
                            </td>
                            <td>
                                <a href="{{ route('updateIncome', ['incomeId' => $income->income_id]) }}"
                                    class="btn btn-primary">
                                    {{ __('updateButton') }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="mt-2">
            {{ $incomeTable->withQueryString()->links('pagination::bootstrap-4') }}
        </div>

        <script>
            var currentLang = '{{ app()->getLocale() }}';
            var translations = @json(__('incomeCategories'));

            function translateCategories(categories) {
                return categories.map(category => translations[category] || category);
            }
            var categoryElements = document.querySelectorAll('.income-category');

            categoryElements.forEach(function(element) {
                var originalCategory = element.innerText;
                element.innerText = translations[originalCategory] || originalCategory;
            });
        </script>
    </div>
@endsection
