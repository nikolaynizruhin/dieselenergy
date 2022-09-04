<div class="card-header text-muted bg-white lead">
    {{ __('image.plural') }}
</div>
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="thead-light">
            <tr>
                <th scope="col" class="bg-light text-muted">#</th>
                <th scope="col" class="bg-light text-muted">{{ __('image.title') }}</th>
                <th scope="col" class="bg-light text-muted">{{ __('common.name') }}</th>
                <th scope="col" class="bg-light text-muted">{{ __('common.status') }}</th>
                <th scope="col" class="bg-light text-muted">{{ __('common.actions') }}</th>
            </tr>
            </thead>
            <tbody class="text-muted">
            @foreach ($images as $key => $image)
                <tr>
                    <th scope="row" class="fw-normal">{{ $images->firstItem() + $key }}</th>
                    <td>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#showImageModal{{ $image->id }}" class="me-2">
                            <img src="{{ asset('storage/'.$image->path) }}" class="img-thumbnail" alt="{{ $image->name }}" width="64" height="64" loading="lazy">
                        </a>
                    </td>
                    <td>{{ $image->name }}</td>
                    <td>
                        @if ($image->pivot->is_default)
                            @include('admin.layouts.partials.status', ['status' => __('common.default'), 'type' => 'success'])
                        @endif
                    </td>
                    <td class="text-nowrap">
                        @unless ($image->pivot->is_default)
                            <form action="{{ route('admin.medias.default.update', $image->pivot) }}" method="POST" class="me-2 d-inline">
                                @csrf
                                @method('PUT')
                                <button class="all-unset cursor-pointer">
                                    @include('layouts.partials.icon', ['name' => 'check-square', 'width' => '1.1em', 'height' => '1.1em'])
                                </button>
                            </form>
                        @endunless
                        @include('admin.layouts.partials.image')
                        @include('admin.layouts.partials.delete', [
                            'id' => 'deleteImageModal'.$image->id,
                            'label' => 'deleteImageLabel'.$image->id,
                            'title' => __('image.delete'),
                            'body' => __('common.alert.detach').' '.$image->name.'?',
                            'action' => route('admin.medias.destroy', $image->pivot->id),
                        ])
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="card-footer bg-white text-muted border-0">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
        {{ __('common.total') }} {{ $images->total() }} {{ __('common.records') }}
        {{ $images->links() }}
    </div>
</div>
