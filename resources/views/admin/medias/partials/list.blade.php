<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="thead-light">
            <tr>
                <th scope="col" class="bg-light text-muted border-0">#</th>
                <th scope="col" class="bg-light text-muted border-0">{{ __('Image') }}</th>
                <th scope="col" class="bg-light text-muted border-0">{{ __('Name') }}</th>
                <th scope="col" class="bg-light text-muted border-0">{{ __('Actions') }}</th>
            </tr>
            </thead>
            <tbody class="text-muted">
            @foreach ($images as $key => $image)
                <tr>
                    <th scope="row" class="font-weight-normal">{{ $images->firstItem() + $key }}</th>
                    <td>
                        <a href="{{ asset($image->path) }}" class="mr-2">
                            <img src="{{ asset($image->path) }}" class="img-thumbnail" alt="{{ $image->name }}" width="64" height="64">
                        </a>
                    </td>
                    <td>{{ $image->name }}</td>
                    <td>
                        <a href="#" data-toggle="modal" data-target="#showImageModal{{ $image->id }}" class="mr-2">
                            <svg class="bi bi-eye" width="1.1em" height="1.1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 001.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0014.828 8a13.133 13.133 0 00-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 001.172 8z" clip-rule="evenodd"/>
                                <path fill-rule="evenodd" d="M8 5.5a2.5 2.5 0 100 5 2.5 2.5 0 000-5zM4.5 8a3.5 3.5 0 117 0 3.5 3.5 0 01-7 0z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                        <a href="#" data-toggle="modal" data-target="#deleteImageModal{{ $image->id }}">
                            <svg class="bi bi-trash" width="1.1em" height="1.1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.5 5.5A.5.5 0 016 6v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm2.5 0a.5.5 0 01.5.5v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm3 .5a.5.5 0 00-1 0v6a.5.5 0 001 0V6z"/>
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 01-1 1H13v9a2 2 0 01-2 2H5a2 2 0 01-2-2V4h-.5a1 1 0 01-1-1V2a1 1 0 011-1H6a1 1 0 011-1h2a1 1 0 011 1h3.5a1 1 0 011 1v1zM4.118 4L4 4.059V13a1 1 0 001 1h6a1 1 0 001-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                        @include('admin.medias.partials.image')
                        @include('admin.medias.partials.delete')
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="card-footer bg-white text-muted">
    <div class="d-flex justify-content-between align-items-center">
        About {{ $images->total() }} results
        {{ $images->withQueryString()->links() }}
    </div>
</div>
