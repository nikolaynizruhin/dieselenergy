<div class="card-header text-muted bg-white lead">
    {{ __('product.plural') }}
</div>
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="thead-light">
                <tr>
                    <th scope="col" class="bg-light text-muted border-0">#</th>
                    <th scope="col" class="bg-light text-muted border-0">{{ __('common.name') }}</th>
                    <th scope="col" class="bg-light text-muted border-0">{{ __('category.title') }}</th>
                    <th scope="col" class="bg-light text-muted border-0">{{ __('common.status') }}</th>
                    <th scope="col" class="bg-light text-muted border-0">{{ __('common.price') }}</th>
                    <th scope="col" class="bg-light text-muted border-0">{{ __('common.actions') }}</th>
                </tr>
            </thead>
            <tbody class="text-muted">
                @foreach ($products as $key => $product)
                    <tr>
                        <th scope="row" class="font-weight-normal">{{ $products->firstItem() + $key }}</th>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>
                            @include('admin.layouts.partials.status', [
                                'status' => $product->is_active ? __('common.active') : __('Inactive'),
                                'type' => $product->is_active ? 'success' : 'danger',
                            ])
                        </td>
                        <td>{{ $product->price }}</td>
                        <td>
                            <a href="{{ route('admin.products.show', $product) }}" class="mr-2">
                                @include('layouts.partials.icon', ['name' => 'eye', 'width' => '1.1em', 'height' => '1.1em'])
                            </a>
                            <a href="{{ route('admin.products.edit', $product) }}" class="mr-2">
                                @include('layouts.partials.icon', ['name' => 'pencil-square', 'width' => '1.1em', 'height' => '1.1em'])
                            </a>
                            <a href="#" data-toggle="modal" data-target="#deleteProductModal{{ $product->id }}">
                                @include('layouts.partials.icon', ['name' => 'trash', 'width' => '1.1em', 'height' => '1.1em'])
                            </a>
                            @include('admin.products.partials.delete')
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="card-footer bg-white text-muted">
    <div class="d-flex justify-content-between align-items-center">
        {{ __('common.total') }} {{ $products->total() }} {{ __('common.records') }}
        {{ $products->withQueryString()->links() }}
    </div>
</div>
