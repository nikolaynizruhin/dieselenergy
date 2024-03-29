<div class="card-header text-muted lead">
    {{ __('contact.plural') }}
</div>
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="table-light">
            <tr>
                <th scope="col" class="text-muted">#</th>
                @if ($route['name'] === 'admin.contacts.index')
                    <th scope="col" class="text-muted">
                        @include('admin.layouts.partials.sort', [
                            'title' => __('customer.title'),
                            'field' => 'customers.name',
                            'route' => $route,
                            'nested' => $nested ?? null,
                        ])
                    </th>
                @endif
                <th scope="col" class="text-muted">
                    @include('admin.layouts.partials.sort', [
                        'title' => __('contact.message'),
                        'field' => 'message',
                        'route' => $route,
                        'nested' => $nested ?? null,
                    ])
                </th>
                <th scope="col" class="text-muted">
                    @include('admin.layouts.partials.sort', [
                        'title' => __('common.date'),
                        'field' => 'created_at',
                        'route' => $route,
                        'nested' => $nested ?? null,
                    ])
                </th>
                <th scope="col" class="text-muted">{{ __('common.actions') }}</th>
            </tr>
            </thead>
            <tbody class="text-muted">
            @foreach ($contacts as $key => $contact)
                <tr>
                    <th scope="row" class="fw-normal">{{ $contacts->firstItem() + $key }}</th>
                    @if ($route['name'] === 'admin.contacts.index')
                        <td>
                            <a href="{{ route('admin.customers.show', $contact->customer) }}">
                                {{ $contact->customer->name }}
                            </a>
                        </td>
                    @endif
                    <td>{{ $contact->message }}</td>
                    <td class="text-nowrap">{{ $contact->created_at->format('Y-m-d H:i') }}</td>
                    <td class="text-nowrap">
                        <a href="{{ route('admin.contacts.show', $contact) }}" class="me-2 text-decoration-none">
                            @include('layouts.partials.icon', ['name' => 'eye', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        <a href="{{ route('admin.contacts.edit', $contact) }}" class="me-2 text-decoration-none">
                            @include('layouts.partials.icon', ['name' => 'pencil-square', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        @include('admin.layouts.partials.delete', [
                            'id' => 'deleteContactModal'.$contact->id,
                            'label' => 'deleteContactLabel'.$contact->id,
                            'title' => __('contact.delete'),
                            'body' => __('contact.confirm_delete'),
                            'action' => route('admin.contacts.destroy', $contact),
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
        {{ __('common.total') }} {{ $contacts->total() }} {{ __('common.records') }}
        {{ $contacts->links() }}
    </div>
</div>
