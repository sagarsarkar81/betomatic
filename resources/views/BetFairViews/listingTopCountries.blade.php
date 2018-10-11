@foreach($countryCode as $key=>$value)
<li>
    <a href="javascript:void(0)" onclick="MoveToSelectedLeague({{ $value->countryCode }})">
    <span  class="flag-icon flag-icon-{{ strtolower($value->countryCode) }}"></span> {{ countryCodeToCountry($value->countryCode) }}
    </a>
</li>
@endforeach