<div class="modal fade" id="deleteImageModal{{ $image->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{ $image->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="deleteModal{{ $image->id }}">{{ __('Detach Image') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-muted">
                {{ __('Are you sure you want to delete') }} {{ $image->name }}?
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-link" data-dismiss="modal">{{ __('Close') }}</button>
                <form action="{{ route('admin.images.destroy', $image) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>