<div class="modal fade" id="deleteOrderModal{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{ $order->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="deleteModal{{ $order->id }}">{{ __('order.delete') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-muted">
                {{ __('order.confirm_delete') }}
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-link" data-bs-dismiss="modal">{{ __('common.close') }}</button>
                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">{{ __('common.remove') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
