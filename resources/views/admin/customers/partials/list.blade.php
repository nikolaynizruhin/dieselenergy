<div class="card-header text-muted bg-white lead">
    {{ __('customer.plural') }}
</div>
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="thead-light">
            <tr>
                <th scope="col" class="bg-light text-muted border-0">#</th>
                <th scope="col" class="bg-light text-muted border-0">
                    @include('admin.layouts.partials.sort', [
                       'title' => __('customer.name'),
                       'field' => 'name',
                       'route' => 'admin.customers.index'
                   ])
                </th>
                <th scope="col" class="bg-light text-muted border-0">
                    @include('admin.layouts.partials.sort', [
                       'title' => __('common.email'),
                       'field' => 'email',
                       'route' => 'admin.customers.index'
                   ])
                </th>
                <th scope="col" class="bg-light text-muted border-0">
                    @include('admin.layouts.partials.sort', [
                       'title' => __('common.phone'),
                       'field' => 'phone',
                       'route' => 'admin.customers.index'
                   ])
                </th>
                <th scope="col" class="bg-light text-muted border-0">{{ __('common.actions') }}</th>
            </tr>
            </thead>
            <tbody class="text-muted">
            @foreach ($customers as $key => $customer)
                <tr>
                    <th scope="row" class="font-weight-normal">{{ $customers->firstItem() + $key }}</th>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td class="text-nowrap">
                        <a href="{{ route('admin.customers.show', $customer) }}" class="mr-2 text-decoration-none">
                            @include('layouts.partials.icon', ['name' => 'eye', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        <a href="{{ route('admin.customers.edit', $customer) }}" class="mr-2 text-decoration-none">
                            @include('layouts.partials.icon', ['name' => 'pencil-square', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        <a href="#" data-toggle="modal" data-target="#deleteCustomerModal{{ $customer->id }}">
                            @include('layouts.partials.icon', ['name' => 'trash', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        @include('admin.customers.partials.delete')
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="card-footer bg-white text-muted">
    <div class="d-flex justify-content-between align-items-center">
        {{ __('common.total') }} {{ $customers->total() }} {{ __('common.records') }}
        {{ $customers->withQueryString()->links() }}
    </div>
</div>
