<div class="card-header text-muted bg-white lead">
    {{ __('contact.plural') }}
</div>
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="thead-light">
            <tr>
                <th scope="col" class="bg-light text-muted border-0">#</th>
                <th scope="col" class="bg-light text-muted border-0">{{ __('customer.title') }}</th>
                <th scope="col" class="bg-light text-muted border-0">{{ __('contact.message') }}</th>
                <th scope="col" class="bg-light text-muted border-0">{{ __('common.actions') }}</th>
            </tr>
            </thead>
            <tbody class="text-muted">
            @foreach ($contacts as $key => $contact)
                <tr>
                    <th scope="row" class="font-weight-normal">{{ $contacts->firstItem() + $key }}</th>
                    <td>
                        <a href="{{ route('admin.customers.show', $contact->customer) }}">
                            {{ $contact->customer->name }}
                        </a>
                    </td>
                    <td>{{ $contact->message }}</td>
                    <td>
                        <a href="{{ route('admin.contacts.show', $contact) }}" class="mr-2">
                            @include('layouts.partials.icon', ['name' => 'eye', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        <a href="{{ route('admin.contacts.edit', $contact) }}" class="mr-2">
                            @include('layouts.partials.icon', ['name' => 'pencil-square', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        <a href="#" data-toggle="modal" data-target="#deleteContactModal{{ $contact->id }}">
                            @include('layouts.partials.icon', ['name' => 'trash', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        @include('admin.contacts.partials.delete')
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="card-footer bg-white text-muted">
    <div class="d-flex justify-content-between align-items-center">
        {{ __('common.total') }} {{ $contacts->total() }} {{ __('common.records') }}
        {{ $contacts->withQueryString()->links() }}
    </div>
</div>
