<div class="card-header text-muted bg-white lead">
    {{ __('customer.plural') }}
</div>
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="thead-light">
            <tr>
                <th scope="col" class="bg-light text-muted">#</th>
                <th scope="col" class="bg-light text-muted">
                    @include('admin.layouts.partials.sort', [
                       'title' => __('customer.name'),
                       'field' => 'name',
                       'route' => ['name' => 'admin.customers.index', 'parameters' => []],
                   ])
                </th>
                <th scope="col" class="bg-light text-muted">
                    @include('admin.layouts.partials.sort', [
                       'title' => __('common.email'),
                       'field' => 'email',
                       'route' => ['name' => 'admin.customers.index', 'parameters' => []],
                   ])
                </th>
                <th scope="col" class="bg-light text-muted">
                    @include('admin.layouts.partials.sort', [
                       'title' => __('common.phone'),
                       'field' => 'phone',
                       'route' => ['name' => 'admin.customers.index', 'parameters' => []],
                   ])
                </th>
                <th scope="col" class="bg-light text-muted">{{ __('common.actions') }}</th>
            </tr>
            </thead>
            <tbody class="text-muted">
            @foreach ($customers as $key => $customer)
                <tr>
                    <th scope="row" class="fw-normal">{{ $customers->firstItem() + $key }}</th>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td class="text-nowrap">
                        <a href="{{ route('admin.customers.show', $customer) }}" class="me-2 text-decoration-none">
                            @include('layouts.partials.icon', ['name' => 'eye', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        <a href="{{ route('admin.customers.edit', $customer) }}" class="me-2 text-decoration-none">
                            @include('layouts.partials.icon', ['name' => 'pencil-square', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        @include('admin.layouts.partials.delete', [
                            'id' => 'deleteCustomerModal'.$customer->id,
                            'label' => 'deleteCustomerLabel'.$customer->id,
                            'title' => __('customer.delete'),
                            'body' => __('common.alert.delete').' '.$customer->name.'?',
                            'action' => route('admin.customers.destroy', $customer),
                        ])
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="card-footer bg-white text-muted border-0">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
        {{ __('common.total') }} {{ $customers->total() }} {{ __('common.records') }}
        {{ $customers->links() }}
    </div>
</div>
