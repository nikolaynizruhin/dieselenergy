<div class="card-header text-muted lead">
    {{ __('post.plural') }}
</div>
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="table-light">
            <tr>
                <th scope="col" class="text-muted">#</th>
                <th scope="col" class="text-muted">
                    @include('admin.layouts.partials.sort', [
                        'title' => __('common.title'),
                        'field' => 'title',
                        'route' => ['name' => 'admin.posts.index', 'parameters' => []],
                    ])
                </th>
                <th scope="col" class="text-muted">{{ __('common.actions') }}</th>
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
                        @include('admin.layouts.partials.delete', [
                            'id' => 'deletePostModal'.$post->id,
                            'label' => 'deletePostLabel'.$post->id,
                            'title' => __('post.delete'),
                            'body' => __('common.alert.delete').' '.$post->title.'?',
                            'action' => route('admin.posts.destroy', $post),
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
        {{ __('common.total') }} {{ $posts->total() }} {{ __('common.records') }}
        {{ $posts->links() }}
    </div>
</div>
