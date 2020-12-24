<div class="card-header text-muted bg-white lead">
    {{ __('post.plural') }}
</div>
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="thead-light">
            <tr>
                <th scope="col" class="bg-light text-muted border-0">#</th>
                <th scope="col" class="bg-light text-muted border-0">
                    @include('admin.layouts.partials.sort', [
                        'title' => __('common.title'),
                        'field' => 'title',
                        'route' => ['name' => 'admin.posts.index', 'parameters' => []],
                    ])
                </th>
                <th scope="col" class="bg-light text-muted border-0">{{ __('common.actions') }}</th>
            </tr>
            </thead>
            <tbody class="text-muted">
            @foreach ($posts as $key => $post)
                <tr>
                    <th scope="row" class="font-weight-normal">{{ $posts->firstItem() + $key }}</th>
                    <td>{{ $post->title }}</td>
                    <td class="text-nowrap">
                        <a href="{{ route('admin.posts.show', $post) }}" class="mr-2 text-decoration-none">
                            @include('layouts.partials.icon', ['name' => 'eye', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        <a href="{{ route('admin.posts.edit', $post) }}" class="mr-2 text-decoration-none">
                            @include('layouts.partials.icon', ['name' => 'pencil-square', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        <a href="#" data-toggle="modal" data-target="#deletePostModal{{ $post->id }}">
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
<div class="card-footer bg-white text-muted">
    <div class="d-flex justify-content-between align-items-center">
        {{ __('common.total') }} {{ $posts->total() }} {{ __('common.records') }}
        {{ $posts->withQueryString()->links() }}
    </div>
</div>
