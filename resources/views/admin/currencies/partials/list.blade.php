<div class="card-header text-muted bg-white lead">
    {{ __('currency.plural') }}
</div>
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="thead-light">
            <tr>
                <th scope="col" class="bg-light text-muted border-0">#</th>
                <th scope="col" class="bg-light text-muted border-0">{{ __('currency.code') }}</th>
                <th scope="col" class="bg-light text-muted border-0">{{ __('currency.rate') }}</th>
                <th scope="col" class="bg-light text-muted border-0">{{ __('common.actions') }}</th>
            </tr>
            </thead>
            <tbody class="text-muted">
            @foreach ($currencies as $key => $currency)
                <tr>
                    <th scope="row" class="font-weight-normal">{{ $currencies->firstItem() + $key }}</th>
                    <td>{{ $currency->code }}</td>
                    <td>{{ $currency->rate }}</td>
                    <td>
                        <a href="{{ route('admin.currencies.edit', $currency) }}" class="mr-2">
                            @include('layouts.partials.icon', ['name' => 'pencil-square', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        <a href="#" data-toggle="modal" data-target="#deleteCurrencyModal{{ $currency->id }}">
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
<div class="card-footer bg-white text-muted">
    <div class="d-flex justify-content-between align-items-center">
        {{ __('common.total') }} {{ $currencies->total() }} {{ __('common.records') }}
        {{ $currencies->withQueryString()->links() }}
    </div>
</div>
