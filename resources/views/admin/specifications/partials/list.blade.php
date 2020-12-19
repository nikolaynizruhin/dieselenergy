<div class="card-header text-muted bg-white lead">
    {{ __('attribute.plural') }}
</div>
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="thead-light">
            <tr>
                <th scope="col" class="bg-light text-muted border-0">#</th>
                <th scope="col" class="bg-light text-muted border-0">{{ __('common.name') }}</th>
                <th scope="col" class="bg-light text-muted border-0">{{ __('common.measure') }}</th>
                <th scope="col" class="bg-light text-muted border-0">{{ __('common.actions') }}</th>
            </tr>
            </thead>
            <tbody class="text-muted">
            @foreach ($attributes as $key => $attribute)
                <tr>
                    <th scope="row" class="font-weight-normal">{{ $attributes->firstItem() + $key }}</th>
                    <td>{{ $attribute->name }}</td>
                    <td>{{ $attribute->measure }}</td>
                    <td class="text-nowrap">
                        <a href="{{ route('admin.specifications.edit', $attribute->pivot->id) }}" class="mr-2 text-decoration-none">
                            @include('layouts.partials.icon', ['name' => 'pencil-square', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        <a href="#" data-toggle="modal" data-target="#deleteSpecificationModal{{ $attribute->id }}">
                            @include('layouts.partials.icon', ['name' => 'trash', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        @include('admin.specifications.partials.delete')
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="card-footer bg-white text-muted">
    <div class="d-flex justify-content-between align-items-center">
        {{ __('common.total') }} {{ $attributes->total() }} {{ __('common.records') }}
        {{ $attributes->withQueryString()->links() }}
    </div>
</div>
