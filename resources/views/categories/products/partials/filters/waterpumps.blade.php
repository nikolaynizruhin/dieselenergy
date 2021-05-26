<p class="mb-1 fw-bold text-uppercase letter-spacing text-gray-500">
    <small>Призначення</small>
</p>

<div class="form-check">
    <input name="attribute[42][]" onchange="this.form.submit()" value="З підвищеним тиском" type="checkbox" class="form-check-input" id="customCheck1" @if(in_array('З підвищеним тиском', request('attribute.42', []))) checked @endif>
    <label class="form-check-label text-secondary" for="customCheck1">
        <small>З підвищеним тиском</small>
    </label>
</div>

<div class="form-check">
    <input name="attribute[42][]" onchange="this.form.submit()" value="Для агресивних рідин" type="checkbox" class="form-check-input" id="customCheck2" @if(in_array('Для агресивних рідин', request('attribute.42', []))) checked @endif>
    <label class="form-check-label text-secondary" for="customCheck2">
        <small>Для агресивних рідин</small>
    </label>
</div>

<div class="form-check">
    <input name="attribute[42][]" onchange="this.form.submit()" value="Для чистої води" type="checkbox" class="form-check-input" id="customCheck3" @if(in_array('Для чистої води', request('attribute.42', []))) checked @endif>
    <label class="form-check-label text-secondary" for="customCheck3">
        <small>Для чистої води</small>
    </label>
</div>

<p class="mb-1 mt-3 fw-bold text-uppercase letter-spacing text-gray-500">
    <small>Продуктивність</small>
</p>

<div class="form-check">
    <input name="attribute[28][]" onchange="this.form.submit()" value="16" type="checkbox" class="form-check-input" id="customCheck4" @if(in_array('16', request('attribute.28', []))) checked @endif>
    <label class="form-check-label text-secondary" for="customCheck4">
        <small>16 куб. м/год</small>
    </label>
</div>

<div class="form-check">
    <input name="attribute[28][]" onchange="this.form.submit()" value="25" type="checkbox" class="form-check-input" id="customCheck5" @if(in_array('25', request('attribute.28', []))) checked @endif>
    <label class="form-check-label text-secondary" for="customCheck5">
        <small>25 куб. м/год</small>
    </label>
</div>

<div class="form-check">
    <input name="attribute[28][]" onchange="this.form.submit()" value="50" type="checkbox" class="form-check-input" id="customCheck6" @if(in_array('50', request('attribute.28', []))) checked @endif>
    <label class="form-check-label text-secondary" for="customCheck6">
        <small>50 куб. м/год</small>
    </label>
</div>
