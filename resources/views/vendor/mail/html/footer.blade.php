<tr>
<td>
<table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td class="content-cell" align="center">
<div class="social">
<a href="tel:{{ config('company.phone') }}">
@include('layouts.partials.icon', ['name' => 'telephone', 'width' => '1.3em', 'height' => '1.3em'])
</a>
<a href="mailto:{{ config('company.email') }}" style="margin: 0 20px">
@include('layouts.partials.icon', ['name' => 'envelope', 'width' => '1.3em', 'height' => '1.3em'])
</a>
<a href="{{ config('company.facebook') }}">
@include('layouts.partials.icon', ['name' => 'facebook', 'width' => '1.3em', 'height' => '1.3em'])
</a>
</div>
{{ Illuminate\Mail\Markdown::parse($slot) }}
</td>
</tr>
</table>
</td>
</tr>
