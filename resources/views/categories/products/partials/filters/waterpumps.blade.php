<p class="mb-1 font-weight-bold text-uppercase letter-spacing text-gray-500">
    <small>Об'єм двигуна</small>
</p>

<div class="form-check">
    <input name="filter[32][]" value="212" class="form-check-input" type="checkbox" id="defaultCheck1" @if(in_array('212', request('filter.32', []))) checked @endif>
    <label class="form-check-label text-secondary" for="defaultCheck1">
        <small>212</small>
    </label>
</div>

<div class="form-check">
    <input name="filter[32][]" value="270" class="form-check-input" type="checkbox" id="defaultCheck2" @if(in_array('270', request('filter.32', []))) checked @endif>
    <label class="form-check-label text-secondary" for="defaultCheck2">
        <small>270</small>
    </label>
</div>

<p class="mb-1 mt-3 font-weight-bold text-uppercase letter-spacing text-gray-500">
    <small>Вихідна потужність двигуна</small>
</p>

<div class="form-check">
    <input name="filter[12][]" class="form-check-input" type="checkbox" value="9,0" id="defaultCheck1" @if(in_array('9,0', request('filter.12', []))) checked @endif>
    <label class="form-check-label text-secondary" for="defaultCheck1">
        <small>9,0</small>
    </label>
</div>

<div class="form-check">
    <input name="filter[12][]" class="form-check-input" type="checkbox" value="7,0" id="defaultCheck1" @if(in_array('7,0', request('filter.12', []))) checked @endif>
    <label class="form-check-label text-secondary" for="defaultCheck1">
        <small>7,0</small>
    </label>
</div>

<p class="mt-3 mb-1 font-weight-bold text-uppercase letter-spacing text-gray-500">
    <small>Вага</small>
</p>

<div class="form-check">
    <input name="filter[5][]" class="form-check-input" type="checkbox" value="45" id="defaultCheck1" @if(in_array('45', request('filter.5', []))) checked @endif>
    <label class="form-check-label text-secondary" for="defaultCheck1">
        <small>45</small>
    </label>
</div>

<div class="form-check">
    <input name="filter[5][]" class="form-check-input" type="checkbox" value="25" id="defaultCheck2" @if(in_array('25', request('filter.5', []))) checked @endif>
    <label class="form-check-label text-secondary" for="defaultCheck2">
        <small>25</small>
    </label>
</div>
