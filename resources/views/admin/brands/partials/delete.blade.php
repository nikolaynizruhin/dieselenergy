<div class="modal fade" id="deleteBrandModal{{ $brand->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{ $brand->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="deleteModal{{ $brand->id }}">{{ __('Delete Brand') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-muted">
                {{ __('Are you sure you want to delete') }} {{ $brand->name }}?
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-link" data-dismiss="modal">{{ __('Close') }}</button>
                <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">{{ __('Remove') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
