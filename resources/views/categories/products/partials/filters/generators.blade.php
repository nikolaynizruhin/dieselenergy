<p class="mb-1 font-weight-bold text-uppercase letter-spacing text-gray-500">
    <small>Вид палива</small>
</p>

<div class="custom-control custom-checkbox">
    <input name="attribute[43][]" onchange="this.form.submit()" value="Бензин" type="checkbox" class="custom-control-input" id="customCheck1" @if(in_array('Бензин', request('attribute.43', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck1">
        <small>Бензин</small>
    </label>
</div>

<div class="custom-control custom-checkbox">
    <input name="attribute[43][]" onchange="this.form.submit()" value="Дизель" type="checkbox" class="custom-control-input" id="customCheck2" @if(in_array('Дизель', request('attribute.43', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck2">
        <small>Дизель</small>
    </label>
</div>

<div class="custom-control custom-checkbox">
    <input name="attribute[43][]" onchange="this.form.submit()" value="Інверторний" type="checkbox" class="custom-control-input" id="customCheck3" @if(in_array('Інверторний', request('attribute.43', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck3">
        <small>Інверторний</small>
    </label>
</div>

<div class="custom-control custom-checkbox">
    <input name="attribute[43][]" onchange="this.form.submit()" value="Зварювальний" type="checkbox" class="custom-control-input" id="customCheck4" @if(in_array('Зварювальний', request('attribute.43', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck4">
        <small>Зварювальний</small>
    </label>
</div>

<p class="mb-1 mt-3 font-weight-bold text-uppercase letter-spacing text-gray-500">
    <small>Кількість фаз</small>
</p>

<div class="custom-control custom-checkbox">
    <input name="attribute[44][]" onchange="this.form.submit()" value="Однофазний" type="checkbox" class="custom-control-input" id="customCheck9" @if(in_array('Однофазний', request('attribute.44', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck9">
        <small>Однофазний</small>
    </label>
</div>

<div class="custom-control custom-checkbox">
    <input name="attribute[44][]" onchange="this.form.submit()" value="Однофазний/Трифазний" type="checkbox" class="custom-control-input" id="customCheck10" @if(in_array('Однофазний/Трифазний', request('attribute.44', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck10">
        <small>Однофазний/Трифазний</small>
    </label>
</div>

<div class="custom-control custom-checkbox">
    <input name="attribute[44][]" onchange="this.form.submit()" value="Трифазний" type="checkbox" class="custom-control-input" id="customCheck11" @if(in_array('Трифазний', request('attribute.44', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck11">
        <small>Трифазний</small>
    </label>
</div>

<p class="mb-1 mt-3 font-weight-bold text-uppercase letter-spacing text-gray-500">
    <small>Напруга</small>
</p>

<div class="custom-control custom-checkbox">
    <input name="attribute[3][]" onchange="this.form.submit()" value="230" type="checkbox" class="custom-control-input" id="customCheck5" @if(in_array('230', request('attribute.3', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck5">
        <small>230 В</small>
    </label>
</div>

<div class="custom-control custom-checkbox">
    <input name="attribute[3][]" onchange="this.form.submit()" value="380" type="checkbox" class="custom-control-input" id="customCheck6" @if(in_array('380', request('attribute.3', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck6">
        <small>380 В</small>
    </label>
</div>

<div class="custom-control custom-checkbox">
    <input name="attribute[3][]" onchange="this.form.submit()" value="230/380" type="checkbox" class="custom-control-input" id="customCheck7" @if(in_array('230/380', request('attribute.3', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck7">
        <small>230/380 В</small>
    </label>
</div>

<p class="mb-1 mt-3 font-weight-bold text-uppercase letter-spacing text-gray-500">
    <small>Потужність</small>
</p>

<div class="custom-control custom-checkbox">
    <input name="attribute[2][]" onchange="this.form.submit()" value="2,8" type="checkbox" class="custom-control-input" id="customCheck10" @if(in_array('2,8', request('attribute.2', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck10">
        <small>2,8 кВт</small>
    </label>
</div>

<div class="custom-control custom-checkbox">
    <input name="attribute[2][]" onchange="this.form.submit()" value="4,5" type="checkbox" class="custom-control-input" id="customCheck11" @if(in_array('4,5', request('attribute.2', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck11">
        <small>4,5 кВт</small>
    </label>
</div>

<div class="custom-control custom-checkbox">
    <input name="attribute[2][]" onchange="this.form.submit()" value="5" type="checkbox" class="custom-control-input" id="customCheck12" @if(in_array('5', request('attribute.2', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck12">
        <small>5 кВт</small>
    </label>
</div>

<div class="custom-control custom-checkbox">
    <input name="attribute[2][]" onchange="this.form.submit()" value="7,5" type="checkbox" class="custom-control-input" id="customCheck13" @if(in_array('7,5', request('attribute.2', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck13">
        <small>7,5 кВт</small>
    </label>
</div>

<div class="custom-control custom-checkbox">
    <input name="attribute[2][]" onchange="this.form.submit()" value="10" type="checkbox" class="custom-control-input" id="customCheck14" @if(in_array('10', request('attribute.2', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck14">
        <small>10 кВт</small>
    </label>
</div>

<p class="mt-3 mb-1 font-weight-bold text-uppercase letter-spacing text-gray-500">
    <small>Тип запуску</small>
</p>

<div class="custom-control custom-checkbox">
    <input name="attribute[4][]" onchange="this.form.submit()" value="ручний" type="checkbox" class="custom-control-input" id="customCheck8" @if(in_array('ручний', request('attribute.4', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck8">
        <small>ручний</small>
    </label>
</div>

<div class="custom-control custom-checkbox">
    <input name="attribute[4][]" onchange="this.form.submit()" value="ручний/електростарт" type="checkbox" class="custom-control-input" id="customCheck9" @if(in_array('ручний/електростарт', request('attribute.4', []))) checked @endif>
    <label class="custom-control-label text-secondary" for="customCheck9">
        <small>ручний/електростарт</small>
    </label>
</div>
