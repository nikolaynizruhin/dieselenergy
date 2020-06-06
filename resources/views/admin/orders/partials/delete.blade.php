<div class="modal fade" id="deleteOrderModal{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{ $order->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="deleteModal{{ $order->id }}">{{ __('Delete Order') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-muted">
                {{ __('Are you sure you want to delete an order') }}?
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-link" data-dismiss="modal">{{ __('Close') }}</button>
                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">{{ __('Remove') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
