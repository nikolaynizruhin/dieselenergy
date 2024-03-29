<div class="card-header text-muted lead">
    {{ __('currency.plural') }}
</div>
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="table-light">
            <tr>
                <th scope="col" class="text-muted">#</th>
                <th scope="col" class="text-muted">
                    @include('admin.layouts.partials.sort', [
                        'title' => __('currency.code'),
                        'field' => 'code',
                        'route' => ['name' => 'admin.currencies.index', 'parameters' => []],
                    ])
                </th>
                <th scope="col" class="text-muted">
                    @include('admin.layouts.partials.sort', [
                        'title' => __('currency.rate'),
                        'field' => 'rate',
                        'route' => ['name' => 'admin.currencies.index', 'parameters' => []],
                    ])
                </th>
                <th scope="col" class="text-muted">{{ __('currency.symbol') }}</th>
                <th scope="col" class="text-muted">{{ __('common.actions') }}</th>
            </tr>
            </thead>
            <tbody class="text-muted">
            @foreach ($currencies as $key => $currency)
                <tr>
                    <th scope="row" class="fw-normal">{{ $currencies->firstItem() + $key }}</th>
                    <td>{{ $currency->code }}</td>
                    <td>{{ $currency->rate }}</td>
                    <td>{{ $currency->symbol }}</td>
                    <td class="text-nowrap">
                        <a href="{{ route('admin.currencies.edit', $currency) }}" class="me-2 text-decoration-none">
                            @include('layouts.partials.icon', ['name' => 'pencil-square', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        @include('admin.layouts.partials.delete', [
                            'id' => 'deleteCurrencyModal'.$currency->id,
                            'label' => 'deleteCurrencyLabel'.$currency->id,
                            'title' => __('currency.delete'),
                            'body' => __('common.alert.delete').' '.$currency->code.'?',
                            'action' => route('admin.currencies.destroy', $currency),
                        ])
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="card-footer text-muted border-0">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
        {{ __('common.total') }} {{ $currencies->total() }} {{ __('common.records') }}
        {{ $currencies->links() }}
    </div>
</div>
