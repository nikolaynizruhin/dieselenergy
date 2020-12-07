<div class="card-header text-muted bg-white lead">
    {{ __('user.plural') }}
</div>
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="thead-light">
                <tr>
                    <th scope="col" class="bg-light text-muted border-0">#</th>
                    <th scope="col" class="bg-light text-muted border-0">{{ __('user.name') }}</th>
                    <th scope="col" class="bg-light text-muted border-0">{{ __('common.email') }}</th>
                    <th scope="col" class="bg-light text-muted border-0">{{ __('common.actions') }}</th>
                </tr>
            </thead>
            <tbody class="text-muted">
                @foreach ($users as $key => $user)
                    <tr>
                        <th scope="row" class="font-weight-normal">{{ $users->firstItem() + $key }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="text-nowrap">
                            <a href="{{ route('admin.users.edit', $user) }}" class="mr-2">
                                @include('layouts.partials.icon', ['name' => 'pencil-square', 'width' => '1.1em', 'height' => '1.1em'])
                            </a>
                            <a href="#" data-toggle="modal" data-target="#deleteUserModal{{ $user->id }}">
                                @include('layouts.partials.icon', ['name' => 'trash', 'width' => '1.1em', 'height' => '1.1em'])
                            </a>
                            @include('admin.users.partials.delete')
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="card-footer bg-white text-muted">
    <div class="d-flex justify-content-between align-items-center">
        {{ __('common.total') }} {{ $users->total() }} {{ __('common.records') }}
        {{ $users->withQueryString()->links() }}
    </div>
</div>
