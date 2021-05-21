<p class="mb-1 fw-bold text-uppercase letter-spacing text-gray-500">
    <small>Напруга</small>
</p>

<div class="form-check">
    <input name="attribute[3][]" onchange="this.form.submit()" value="230" type="checkbox" class="form-check-input" id="customCheck1" @if(in_array('230', request('attribute.3', []))) checked @endif>
    <label class="form-check-label text-secondary" for="customCheck1">
        <small>230 В</small>
    </label>
</div>

<div class="form-check">
    <input name="attribute[3][]" onchange="this.form.submit()" value="400" type="checkbox" class="form-check-input" id="customCheck2" @if(in_array('400', request('attribute.3', []))) checked @endif>
    <label class="form-check-label text-secondary" for="customCheck2">
        <small>400 В</small>
    </label>
</div>
