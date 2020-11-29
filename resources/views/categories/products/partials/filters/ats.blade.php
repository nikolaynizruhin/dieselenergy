<p class="mb-1 font-weight-bold text-uppercase letter-spacing text-gray-500">
    <small>Напруга</small>
</p>

<div class="custom-control custom-checkbox">
    <input name="filter[3][]" value="230" type="checkbox" class="custom-control-input" id="customCheck1" @if(in_array('230', request('filter.3', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck1">
        <small>230 В</small>
    </label>
</div>

<div class="mb-4 mb-md-0 custom-control custom-checkbox">
    <input name="filter[3][]" value="400" type="checkbox" class="custom-control-input" id="customCheck2" @if(in_array('400', request('filter.3', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck2">
        <small>400 В</small>
    </label>
</div>
