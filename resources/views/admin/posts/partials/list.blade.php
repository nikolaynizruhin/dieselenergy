<div class="card-header text-muted bg-white lead">
    {{ __('post.plural') }}
</div>
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="thead-light">
            <tr>
                <th scope="col" class="bg-light text-muted border-bottom">#</th>
                <th scope="col" class="bg-light text-muted border-bottom">
                    @include('admin.layouts.partials.sort', [
                        'title' => __('common.title'),
                        'field' => 'title',
                        'route' => ['name' => 'admin.posts.index', 'parameters' => []],
                    ])
                </th>
                <th scope="col" class="bg-light text-muted border-bottom">{{ __('common.actions') }}</th>
            </tr>
            </thead>
            <tbody class="text-muted">
            @foreach ($posts as $key => $post)
                <tr>
                    <th scope="row" class="fw-normal">{{ $posts->firstItem() + $key }}</th>
                    <td>{{ $post->title }}</td>
                    <td class="text-nowrap">
                        <a href="{{ route('admin.posts.show', $post) }}" class="me-2 text-decoration-none">
                            @include('layouts.partials.icon', ['name' => 'eye', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        <a href="{{ route('admin.posts.edit', $post) }}" class="me-2 text-decoration-none">
                            @include('layouts.partials.icon', ['name' => 'pencil-square', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#deletePostModal{{ $post->id }}">
                            @include('layouts.partials.icon', ['name' => 'trash', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        @include('admin.posts.partials.delete')
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="card-footer bg-white text-muted border-0">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
        {{ __('common.total') }} {{ $posts->total() }} {{ __('common.records') }}
        {{ $posts->links() }}
    </div>
</div>
