<div class="card-header text-muted bg-white lead">
    {{ __('image.plural') }}
</div>
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="thead-light">
            <tr>
                <th scope="col" class="bg-light text-muted border-bottom">#</th>
                <th scope="col" class="bg-light text-muted border-bottom">{{ __('image.title') }}</th>
                <th scope="col" class="bg-light text-muted border-bottom">{{ __('common.name') }}</th>
                <th scope="col" class="bg-light text-muted border-bottom">{{ __('common.status') }}</th>
                <th scope="col" class="bg-light text-muted border-bottom">{{ __('common.actions') }}</th>
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
                        <a href="{{ route('admin.medias.edit', $image->pivot->id) }}" class="me-2 text-decoration-none">
                            @include('layouts.partials.icon', ['name' => 'pencil-square', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#deleteImageModal{{ $image->id }}">
                            @include('layouts.partials.icon', ['name' => 'trash', 'width' => '1.1em', 'height' => '1.1em'])
                        </a>
                        @include('admin.layouts.partials.image')
                        @include('admin.medias.partials.delete')
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
