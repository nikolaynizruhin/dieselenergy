<form>
    <p class="mb-1 fw-bold text-uppercase letter-spacing text-gray-500">
        <small>Пошук</small>
    </p>

    <div class="mb-3">
        <label for="inputSearch" class="form-label visually-hidden">Пошук</label>
        <input type="search" name="search" onsearch="this.form.submit()" value="{{ request('search') }}" class="form-control form-control-sm" id="inputSearch" aria-describedby="emailHelp" placeholder="Знайти товар..." autocomplete="search">
    </div>

    <p class="mb-1 fw-bold text-uppercase letter-spacing text-gray-500">
        <small>Сортувати</small>
    </p>

    <div class="mb-3">
        <label for="selectSort" class="form-label visually-hidden">Сортувати</label>
        <select class="form-select form-select-sm" name="sort" onchange="this.form.submit()" id="selectSort">
            <option value="name" @if (request('sort') === 'name') selected @endif>Назва (А - Я)</option>
            <option value="-name" @if (request('sort') === '-name') selected @endif>Назва (Я - А)</option>
            <option value="price" @if (request('sort') === 'price') selected @endif>Ціна (Низька > Висока)</option>
            <option value="-price" @if (request('sort') === '-price') selected @endif>Ціна (Висока > Низька)</option>
        </select>
    </div>

    @includeIf('categories.products.partials.filters.'.$category->slug)
</form>
