<div class="modal fade" id="deletePostModal{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{ $post->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="deleteModal{{ $post->id }}">{{ __('post.delete') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-muted">
                {{ __('common.alert.delete') }} {{ $post->title }}?
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-link" data-bs-dismiss="modal">{{ __('common.close') }}</button>
                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">{{ __('common.remove') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
