<div class="card-header text-muted bg-white lead">
    {{ __('currency.plural') }}
</div>
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="thead-light">
            <tr>
                <th scope="col" class="bg-light text-muted border-bottom">#</th>
                <th scope="col" class="bg-light text-muted border-bottom">
                    @include('admin.layouts.partials.sort', [
                        'title' => __('currency.code'),
                        'field' => 'code',
                        'route' => ['name' => 'admin.currencies.index', 'parameters' => []],
                    ])
                </th>
                <th scope="col" class="bg-light text-muted border-bottom">
                    @include('admin.layouts.partials.sort', [
                        'title' => __('currency.rate'),
                        'field' => 'rate',
                        'route' => ['name' => 'admin.currencies.index', 'parameters' => []],
                    ])
                </th>
                <th scope="col" class="bg-light text-muted border-bottom">{{ __('currency.symbol') }}</th>
                <th scope="col" class="bg-light text-muted border-bottom">{{ __('common.actions') }}</th>
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
                        <a href="#" data-bs-toggle="modal" data-bs-target="#deleteCurrencyModal{{ $currency->id }}">
                            @include('layouts.partials.icon', ['name' => 'trash', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        @include('admin.currencies.partials.delete')
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="card-footer bg-white text-muted border-0">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
        {{ __('common.total') }} {{ $currencies->total() }} {{ __('common.records') }}
        {{ $currencies->links() }}
    </div>
</div>
