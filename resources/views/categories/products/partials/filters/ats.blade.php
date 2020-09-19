<p class="mb-1 font-weight-bold text-uppercase letter-spacing text-gray-500">
    <small>Напруга</small>
</p>

<div class="form-check">
    <input name="filter[3][]" value="230" class="form-check-input" type="checkbox" id="defaultCheck1" @if(in_array('230', request('filter.3', []))) checked @endif>
    <label class="form-check-label text-secondary" for="defaultCheck1">
        <small>230</small>
    </label>
</div>

<div class="form-check">
    <input name="filter[3][]" value="400" class="form-check-input" type="checkbox" id="defaultCheck2" @if(in_array('400', request('filter.3', []))) checked @endif>
    <label class="form-check-label text-secondary" for="defaultCheck2">
        <small>400</small>
    </label>
</div>

<p class="mb-1 mt-3 font-weight-bold text-uppercase letter-spacing text-gray-500">
    <small>Потужність</small>
</p>

<div class="form-check">
    <input name="filter[23][]" class="form-check-input" type="checkbox" value="10" id="defaultCheck1" @if(in_array('10', request('filter.23', []))) checked @endif>
    <label class="form-check-label text-secondary" for="defaultCheck1">
        <small>10</small>
    </label>
</div>
