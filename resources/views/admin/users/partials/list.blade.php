<div class="card-header text-muted bg-white lead">
    {{ __('user.plural') }}
</div>
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="thead-light">
                <tr>
                    <th scope="col" class="bg-light text-muted">#</th>
                    <th scope="col" class="bg-light text-muted">
                        @include('admin.layouts.partials.sort', [
                            'title' => __('user.name'),
                            'field' => 'name',
                            'route' => ['name' => 'admin.users.index', 'parameters' => []],
                        ])
                    </th>
                    <th scope="col" class="bg-light text-muted">
                        @include('admin.layouts.partials.sort', [
                            'title' => __('common.email'),
                            'field' => 'email',
                            'route' => ['name' => 'admin.users.index', 'parameters' => []],
                        ])
                    </th>
                    <th scope="col" class="bg-light text-muted">{{ __('common.actions') }}</th>
                </tr>
            </thead>
            <tbody class="text-muted">
                @foreach ($users as $key => $user)
                    <tr>
                        <th scope="row" class="fw-normal">{{ $users->firstItem() + $key }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="text-nowrap">
                            <a href="{{ route('admin.users.edit', $user) }}" class="me-2 text-decoration-none">
                                @include('layouts.partials.icon', ['name' => 'pencil-square', 'width' => '1.1em', 'height' => '1.1em'])
                            </a>
                            @include('admin.layouts.partials.delete', [
                                'id' => 'deleteUserModal'.$user->id,
                                'label' => 'deleteUserLabel'.$user->id,
                                'title' => __('user.delete'),
                                'body' => __('common.alert.delete').' '.$user->name.'?',
                                'action' => route('admin.users.destroy', $user),
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
        {{ __('common.total') }} {{ $users->total() }} {{ __('common.records') }}
        {{ $users->links() }}
    </div>
</div>
