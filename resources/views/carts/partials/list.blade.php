<div class="table-responsive">
    <table class="table border">
        <tbody>
        @foreach($items as $key => $item)
            <tr>
                <td class="align-middle @if ($loop->first) border-top-0 @endif">
                    <img src="{{ asset('storage/'.$item->image) }}" width="100" alt="...">
                </td>
                <td class="align-middle @if ($loop->first) border-top-0 @endif">
                    <span class="font-weight-bold">{{ $item->name }}</span>
                    <br>
                    <span class="text-muted">{{ $item->category }}</span>
                </td>
                <td class="align-middle @if ($loop->first) border-top-0 @endif">@uah($item->price)</td>
                <td class="align-middle @if ($loop->first) border-top-0 @endif" style="width: 12%">
                    <form action="{{ route('carts.update', $key) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-0">
                            <label for="quantity" class="sr-only">Amount</label>
                            <input type="number" name="quantity" onchange="this.form.submit()" value="{{ $item->quantity }}" min="1" class="form-control" id="quantity" aria-describedby="quantityHelp">
                        </div>
                    </form>
                </td>
                <td class="align-middle @if ($loop->first) border-top-0 @endif">@uah($item->total())</td>
                <td class="align-middle @if ($loop->first) border-top-0 @endif">
                    <form action="{{ route('carts.destroy', $key) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link">
                            @include('layouts.partials.icon', ['name' => 'x', 'width' => '1.5em', 'height' => '1.5em'])
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="4">Всього:</td>
            <td colspan="2" class="font-weight-bold">@uah($total)</td>
        </tr>
        </tbody>
    </table>
</div>
