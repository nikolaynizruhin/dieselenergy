<tr>
<td>
<table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td class="content-cell" align="center">
<a href="tel:{{ config('company.phone') }}">
<img src="{{ asset('/images/telephone.png') }}" width="24" alt="Phone">
</a>
<a href="mailto:{{ config('company.email') }}">
<img src="{{ asset('/images/envelope.png') }}" width="24" alt="Email">
</a>
<a href="{{ config('company.facebook') }}">
<img src="{{ asset('/images/facebook.png') }}" width="24" alt="Facebook">
</a>
{{ Illuminate\Mail\Markdown::parse($slot) }}
</td>
</tr>
</table>
</td>
</tr>
