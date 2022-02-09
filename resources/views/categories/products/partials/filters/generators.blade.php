<p class="mb-1 fw-bold text-uppercase letter-spacing text-gray-500">
    <small>Вид палива</small>
</p>

<div class="form-check">
    <input name="attribute[43][]" onchange="this.form.submit()" value="Бензин" type="checkbox" class="form-check-input" id="customCheck1" @checked(in_array('Бензин', request('attribute.43', [])))>
    <label class="form-check-label text-secondary" for="customCheck1">
        <small>Бензин</small>
    </label>
</div>

<div class="form-check">
    <input name="attribute[43][]" onchange="this.form.submit()" value="Дизель" type="checkbox" class="form-check-input" id="customCheck2" @checked(in_array('Дизель', request('attribute.43', [])))>
    <label class="form-check-label text-secondary" for="customCheck2">
        <small>Дизель</small>
    </label>
</div>

<div class="form-check">
    <input name="attribute[43][]" onchange="this.form.submit()" value="Інверторний" type="checkbox" class="form-check-input" id="customCheck3" @checked(in_array('Інверторний', request('attribute.43', [])))>
    <label class="form-check-label text-secondary" for="customCheck3">
        <small>Інверторний</small>
    </label>
</div>

<div class="form-check">
    <input name="attribute[43][]" onchange="this.form.submit()" value="Зварювальний" type="checkbox" class="form-check-input" id="customCheck4" @checked(in_array('Зварювальний', request('attribute.43', [])))>
    <label class="form-check-label text-secondary" for="customCheck4">
        <small>Зварювальний</small>
    </label>
</div>

<p class="mb-1 mt-3 fw-bold text-uppercase letter-spacing text-gray-500">
    <small>Кількість фаз</small>
</p>

<div class="form-check">
    <input name="attribute[44][]" onchange="this.form.submit()" value="Однофазний" type="checkbox" class="form-check-input" id="customCheck5" @checked(in_array('Однофазний', request('attribute.44', [])))>
    <label class="form-check-label text-secondary" for="customCheck5">
        <small>Однофазний</small>
    </label>
</div>

<div class="form-check">
    <input name="attribute[44][]" onchange="this.form.submit()" value="Однофазний/Трифазний" type="checkbox" class="form-check-input" id="customCheck6" @checked(in_array('Однофазний/Трифазний', request('attribute.44', [])))>
    <label class="form-check-label text-secondary" for="customCheck6">
        <small>Однофазний/Трифазний</small>
    </label>
</div>

<div class="form-check">
    <input name="attribute[44][]" onchange="this.form.submit()" value="Трифазний" type="checkbox" class="form-check-input" id="customCheck7" @checked(in_array('Трифазний', request('attribute.44', [])))>
    <label class="form-check-label text-secondary" for="customCheck7">
        <small>Трифазний</small>
    </label>
</div>

<p class="mb-1 mt-3 fw-bold text-uppercase letter-spacing text-gray-500">
    <small>Напруга</small>
</p>

<div class="form-check">
    <input name="attribute[3][]" onchange="this.form.submit()" value="230" type="checkbox" class="form-check-input" id="customCheck8" @checked(in_array('230', request('attribute.3', [])))>
    <label class="form-check-label text-secondary" for="customCheck8">
        <small>230 В</small>
    </label>
</div>

<div class="form-check">
    <input name="attribute[3][]" onchange="this.form.submit()" value="380" type="checkbox" class="form-check-input" id="customCheck9" @checked(in_array('380', request('attribute.3', [])))>
    <label class="form-check-label text-secondary" for="customCheck9">
        <small>380 В</small>
    </label>
</div>

<div class="form-check">
    <input name="attribute[3][]" onchange="this.form.submit()" value="230/380" type="checkbox" class="form-check-input" id="customCheck10" @checked(in_array('230/380', request('attribute.3', [])))>
    <label class="form-check-label text-secondary" for="customCheck10">
        <small>230/380 В</small>
    </label>
</div>

<p class="mb-1 mt-3 fw-bold text-uppercase letter-spacing text-gray-500">
    <small>Потужність</small>
</p>

<div class="form-check">
    <input name="attribute[2][]" onchange="this.form.submit()" value="2,8" type="checkbox" class="form-check-input" id="customCheck11" @checked(in_array('2,8', request('attribute.2', [])))>
    <label class="form-check-label text-secondary" for="customCheck11">
        <small>2,8 кВт</small>
    </label>
</div>

<div class="form-check">
    <input name="attribute[2][]" onchange="this.form.submit()" value="4,5" type="checkbox" class="form-check-input" id="customCheck12" @checked(in_array('4,5', request('attribute.2', [])))>
    <label class="form-check-label text-secondary" for="customCheck12">
        <small>4,5 кВт</small>
    </label>
</div>

<div class="form-check">
    <input name="attribute[2][]" onchange="this.form.submit()" value="5" type="checkbox" class="form-check-input" id="customCheck13" @checked(in_array('5', request('attribute.2', [])))>
    <label class="form-check-label text-secondary" for="customCheck13">
        <small>5 кВт</small>
    </label>
</div>

<div class="form-check">
    <input name="attribute[2][]" onchange="this.form.submit()" value="7,5" type="checkbox" class="form-check-input" id="customCheck14" @checked(in_array('7,5', request('attribute.2', [])))>
    <label class="form-check-label text-secondary" for="customCheck14">
        <small>7,5 кВт</small>
    </label>
</div>

<div class="form-check">
    <input name="attribute[2][]" onchange="this.form.submit()" value="10" type="checkbox" class="form-check-input" id="customCheck15" @checked(in_array('10', request('attribute.2', [])))>
    <label class="form-check-label text-secondary" for="customCheck15">
        <small>10 кВт</small>
    </label>
</div>

<p class="mt-3 mb-1 fw-bold text-uppercase letter-spacing text-gray-500">
    <small>Тип запуску</small>
</p>

<div class="form-check">
    <input name="attribute[4][]" onchange="this.form.submit()" value="ручний" type="checkbox" class="form-check-input" id="customCheck16" @checked(in_array('ручний', request('attribute.4', [])))>
    <label class="form-check-label text-secondary" for="customCheck16">
        <small>ручний</small>
    </label>
</div>

<div class="form-check">
    <input name="attribute[4][]" onchange="this.form.submit()" value="ручний/електростарт" type="checkbox" class="form-check-input" id="customCheck17" @checked(in_array('ручний/електростарт', request('attribute.4', [])))>
    <label class="form-check-label text-secondary" for="customCheck17">
        <small>ручний/електростарт</small>
    </label>
</div>
