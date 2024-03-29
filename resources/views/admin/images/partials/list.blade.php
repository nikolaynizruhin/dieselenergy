<div class="card-header text-muted lead">
    {{ __('image.plural') }}
</div>
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="table-light">
                <tr>
                    <th scope="col" class="text-muted">#</th>
                    <th scope="col" class="text-muted">{{ __('image.title') }}</th>
                    <th scope="col" class="text-muted">{{ __('common.name') }}</th>
                    <th scope="col" class="text-muted">{{ __('common.actions') }}</th>
                </tr>
            </thead>
            <tbody class="text-muted">
                @foreach ($images as $key => $image)
                    <tr>
                        <th scope="row" class="fw-normal">{{ $images->firstItem() + $key }}</th>
                        <td>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#showImageModal{{ $image->id }}" class="me-2 text-decoration-none">
                                <img src="{{ asset('storage/'.$image->path) }}" class="img-thumbnail" alt="{{ $image->name }}" width="64" height="64" loading="lazy">
                            </a>
                        </td>
                        <td>{{ $image->name }}</td>
                        <td class="text-nowrap">
                            @include('admin.layouts.partials.image')
                            @include('admin.layouts.partials.delete', [
                                'id' => 'deleteImageModal'.$image->id,
                                'label' => 'deleteImageLabel'.$image->id,
                                'title' => __('image.delete'),
                                'body' => __('common.alert.delete').' '.$image->name.'?',
                                'action' => route('admin.images.destroy', $image),
                            ])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="card-footer text-muted border-0">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
        {{ __('common.total') }} {{ $images->total() }} {{ __('common.records') }}
        {{ $images->links() }}
    </div>
</div>
