<div class="modal fade" id="deleteSpecificationModal{{ $attribute->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{ $attribute->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="deleteModal{{ $attribute->id }}">{{ __('specification.delete') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-muted">
                {{ __('common.detach.alert') }} {{ $attribute->name }}?
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-link" data-dismiss="modal">{{ __('common.close') }}</button>
                <form action="{{ route('admin.specifications.destroy', $attribute->pivot->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">{{ __('common.detach') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
