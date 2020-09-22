<div class="card-body d-flex flex-column align-items-center text-muted">
    @include('layouts.partials.icon', ['name' => 'file-earmark-plus', 'classes' => 'mb-3', 'width' => '2.5em', 'height' => '2.5em'])
    {{ __('post.missing') }}
    <a class="btn btn-outline-primary d-block d-md-inline-block mt-3" href="{{ route('admin.posts.create') }}" role="button">
        {{ __('post.add') }}
    </a>
</div>
