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
        <div class="mt-3">
            <table style="border: 1px solid black">
                <thead style="text-align: center">
                    <tr>
                        <th>
                            {{ __('number') }}
                        </th>
                        <th>
                            {{ __('outcomeName') }}
                        </th>
                        <th>
                            {{ __('outcomeDate') }}
                        </th>
                        <th>
                            {{ __('outcomeAmount') }}
                        </th>
                        <th>
                            {{ __('outcomeCategory') }}
                        </th>
                        <th>
                            {{ __('action') }}
                        </th>
                    </tr>
                </thead>
                <tbody style="text-align: center">
                    @if (count($outcomeTable) === 0)
                        <tr>
                            <td colspan="6">{{ __('noOutcomeData') }}</td>
                        </tr>
                    @else
                        @foreach ($outcomeTable as $outcome)
                            <tr>
                                <td>
                                    {{ $outcome->nomor_urut }}
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
                                <td class="outcome-category">
                                    {{ $outcome->Outcome->outcome_category }}
                                </td>
                                <td>
                                    <a href="{{ route('updateOutcome', ['outcomeId' => $outcome->outcome_id]) }}"
                                        class="btn btn-primary">
                                        {{ __('updateButton') }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            <script>
                var currentLang = '{{ app()->getLocale() }}';
                var translations = @json(__('outcomeCategories'));

                function translateCategories(categories) {
                    return categories.map(category => translations[category] || category);
                }

                var categoryElements = document.querySelectorAll('.outcome-category');
                categoryElements.forEach(function(element) {
                    var originalCategory = element.innerText;
                    element.innerText = translations[originalCategory] || originalCategory;
                });
            </script>
        </div>
    </div>
@endsection
