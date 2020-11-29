<p class="mb-1 font-weight-bold text-uppercase letter-spacing text-gray-500">
    <small>Призначення</small>
</p>

<div class="custom-control custom-checkbox">
    <input name="filter[42][]" value="З підвищеним тиском" type="checkbox" class="custom-control-input" id="customCheck1" @if(in_array('З підвищеним тиском', request('filter.42', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck1">
        <small>З підвищеним тиском</small>
    </label>
</div>

<div class="custom-control custom-checkbox">
    <input name="filter[42][]" value="Для агресивних рідин" type="checkbox" class="custom-control-input" id="customCheck2" @if(in_array('Для агресивних рідин', request('filter.42', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck2">
        <small>Для агресивних рідин</small>
    </label>
</div>

<div class="custom-control custom-checkbox">
    <input name="filter[42][]" value="Для чистої води" type="checkbox" class="custom-control-input" id="customCheck3" @if(in_array('Для чистої води', request('filter.42', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck3">
        <small>Для чистої води</small>
    </label>
</div>

<p class="mb-1 mt-3 font-weight-bold text-uppercase letter-spacing text-gray-500">
    <small>Продуктивність</small>
</p>

<div class="custom-control custom-checkbox">
    <input name="filter[28][]" value="16" type="checkbox" class="custom-control-input" id="customCheck4" @if(in_array('16', request('filter.28', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck4">
        <small>16 куб. м/год</small>
    </label>
</div>

<div class="custom-control custom-checkbox">
    <input name="filter[28][]" value="25" type="checkbox" class="custom-control-input" id="customCheck5" @if(in_array('25', request('filter.28', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck5">
        <small>25 куб. м/год</small>
    </label>
</div>

<div class="custom-control custom-checkbox">
    <input name="filter[28][]" value="50" type="checkbox" class="custom-control-input" id="customCheck6" @if(in_array('50', request('filter.28', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck6">
        <small>50 куб. м/год</small>
    </label>
</div>
