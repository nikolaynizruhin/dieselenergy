<div class="modal fade" id="showImageModal{{ $image->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="{{ asset('storage/'.$image->path) }}" class="img-fluid" alt="{{ $image->name }}" loading="lazy">
            </div>
        </div>
    </div>
</div>
