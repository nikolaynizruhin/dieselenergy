<p class="mb-1 font-weight-bold text-uppercase letter-spacing text-gray-500">
    <small>Потужність</small>
</p>

<div class="form-check">
    <input name="filter[2][]" value="2,8" class="form-check-input" type="checkbox" id="defaultCheck1" @if(in_array('2,8', request('filter.2', []))) checked @endif>
    <label class="form-check-label text-secondary" for="defaultCheck1">
        <small>2,8</small>
    </label>
</div>

<div class="form-check">
    <input name="filter[2][]" value="4,5" class="form-check-input" type="checkbox" id="defaultCheck2" @if(in_array('4,5', request('filter.2', []))) checked @endif>
    <label class="form-check-label text-secondary" for="defaultCheck2">
        <small>4,5</small>
    </label>
</div>

<p class="mb-1 mt-3 font-weight-bold text-uppercase letter-spacing text-gray-500">
    <small>Напруга</small>
</p>

<div class="form-check">
    <input name="filter[3][]" class="form-check-input" type="checkbox" value="230" id="defaultCheck1" @if(in_array('230', request('filter.3', []))) checked @endif>
    <label class="form-check-label text-secondary" for="defaultCheck1">
        <small>230</small>
    </label>
</div>

<p class="mt-3 mb-1 font-weight-bold text-uppercase letter-spacing text-gray-500">
    <small>Вага</small>
</p>

<div class="form-check">
    <input name="filter[5][]" class="form-check-input" type="checkbox" value="154" id="defaultCheck1" @if(in_array('154', request('filter.5', []))) checked @endif>
    <label class="form-check-label text-secondary" for="defaultCheck1">
        <small>154</small>
    </label>
</div>

<div class="form-check">
    <input name="filter[5][]" class="form-check-input" type="checkbox" value="51,5" id="defaultCheck2" @if(in_array('51,5', request('filter.5', []))) checked @endif>
    <label class="form-check-label text-secondary" for="defaultCheck2">
        <small>51,5</small>
    </label>
</div>
