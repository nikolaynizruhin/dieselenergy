<div class="modal fade" id="showImageModal{{ $image->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="{{ asset($image->path) }}" class="img-fluid" alt="{{ basename($image->path) }}">
            </div>
        </div>
    </div>
</div>
