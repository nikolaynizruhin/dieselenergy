<div class="card">
    <div class="card-body">
        <form action="{{ route('orders.store') }}" method="POST">
            @csrf

            @include('layouts.partials.honeypot')

            <div class="form-group">
                <label for="inputName">Ім'я</label>
                <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" id="inputName" required autocomplete="name" autofocus>

                @error('name')
                    <div class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="inputEmail">Email</label>
                <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" id="inputEmail" aria-describedby="emailHelp" required autocomplete="email">

                @error('email')
                    <div class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="inputPhone">Телефон</label>
                <input name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', '+380') }}" id="inputPhone" pattern="[+]{1}380[0-9]{9}" required autocomplete="phone">

                @error('phone')
                    <div class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="inputNotes">Примітка</label>
                <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" id="inputNotes" rows="3">{{ old('notes') }}</textarea>

                @error('notes')
                    <div class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
            </div>
            <div class="custom-control custom-switch mb-3">
                <input name="privacy" value="1" type="checkbox" class="custom-control-input @error('privacy') is-invalid @enderror" @if(old('privacy')) checked @endif id="accept" required>
                <label class="custom-control-label text-muted" for="accept">Згода на <a href="{{ route('privacy') }}"><u>обробку даних</u></a></label>

                @error('privacy')
                    <div class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary btn-block">Замовити за @uah($total)</button>
        </form>
    </div>
</div>
