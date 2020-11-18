<p class="mb-1 font-weight-bold text-uppercase letter-spacing text-gray-500">
    <small>Об'єм двигуна</small>
</p>

<div class="custom-control custom-checkbox">
    <input name="filter[32][]" value="212" type="checkbox" class="custom-control-input" id="customCheck1" @if(in_array('212', request('filter.32', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck1">
        <small>212</small>
    </label>
</div>

<div class="custom-control custom-checkbox">
    <input name="filter[32][]" value="270" type="checkbox" class="custom-control-input" id="customCheck2" @if(in_array('270', request('filter.32', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck2">
        <small>270</small>
    </label>
</div>

<p class="mt-3 mb-1 font-weight-bold text-uppercase letter-spacing text-gray-500">
    <small>Вага</small>
</p>

<div class="custom-control custom-checkbox">
    <input name="filter[5][]" value="45" type="checkbox" class="custom-control-input" id="customCheck3" @if(in_array('45', request('filter.5', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck3">
        <small>45</small>
    </label>
</div>

<div class="custom-control custom-checkbox">
    <input name="filter[5][]" value="25" type="checkbox" class="custom-control-input" id="customCheck4" @if(in_array('25', request('filter.5', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck4">
        <small>25</small>
    </label>
</div>
