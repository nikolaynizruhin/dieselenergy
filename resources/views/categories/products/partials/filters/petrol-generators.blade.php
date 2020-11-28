<p class="mb-1 font-weight-bold text-uppercase letter-spacing text-gray-500">
    <small>Потужність</small>
</p>

<div class="custom-control custom-checkbox">
    <input name="filter[2][]" value="2,8" type="checkbox" class="custom-control-input" id="customCheck1" @if(in_array('2,8', request('filter.2', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck1">
        <small>2,8</small>
    </label>
</div>

<div class="custom-control custom-checkbox">
    <input name="filter[2][]" value="4,5" type="checkbox" class="custom-control-input" id="customCheck2" @if(in_array('4,5', request('filter.2', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck2">
        <small>4,5</small>
    </label>
</div>

<p class="mb-1 mt-3 font-weight-bold text-uppercase letter-spacing text-gray-500">
    <small>Напруга</small>
</p>

<div class="custom-control custom-checkbox">
    <input name="filter[3][]" value="230" type="checkbox" class="custom-control-input" id="customCheck3" @if(in_array('230', request('filter.3', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck3">
        <small>230</small>
    </label>
</div>

<p class="mt-3 mb-1 font-weight-bold text-uppercase letter-spacing text-gray-500">
    <small>Вага</small>
</p>

<div class="custom-control custom-checkbox">
    <input name="filter[5][]" value="154" type="checkbox" class="custom-control-input" id="customCheck4" @if(in_array('154', request('filter.5', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck4">
        <small>154</small>
    </label>
</div>

<div class="custom-control custom-checkbox">
    <input name="filter[5][]" value="51,5" type="checkbox" class="custom-control-input" id="customCheck5" @if(in_array('51,5', request('filter.5', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck5">
        <small>51,5</small>
    </label>
</div>
