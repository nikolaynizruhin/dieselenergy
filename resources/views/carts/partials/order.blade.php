<div class="card">
    <div class="card-body">
        <form action="{{ route('orders.store') }}" method="POST">
            @csrf

            @include('layouts.partials.honeypot')

            <div class="mb-3">
                <label class="form-label" for="inputName">Ім'я</label>
                <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" id="inputName" required autocomplete="name" autofocus>

                @include('layouts.partials.error', ['name' => 'name'])
            </div>
            <div class="mb-3">
                <label class="form-label" for="inputEmail">Email</label>
                <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" id="inputEmail" aria-describedby="emailHelp" required autocomplete="email">

                @include('layouts.partials.error', ['name' => 'email'])
            </div>
            <div class="mb-3">
                <label class="form-label" for="inputPhone">Телефон</label>
                <input name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', '+380') }}" id="inputPhone" pattern="[+]{1}380[0-9]{9}" required autocomplete="phone">

                @include('layouts.partials.error', ['name' => 'phone'])
            </div>
            <div class="mb-3">
                <label class="form-label" for="inputNotes">Примітка</label>
                <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" id="inputNotes" rows="3">{{ old('notes') }}</textarea>

                @include('layouts.partials.error', ['name' => 'notes'])
            </div>
            <div class="form-check form-switch mb-3">
                <input name="privacy" value="1" type="checkbox" class="form-check-input @error('privacy') is-invalid @enderror" @checked(old('privacy')) id="accept" required>
                <label class="form-check-label text-muted" for="accept">Згода на <a href="{{ route('privacy') }}">обробку даних</a></label>

                @include('layouts.partials.error', ['name' => 'privacy'])
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary text-white">Замовити за @uah($total)</button>
            </div>
        </form>
    </div>
</div>
