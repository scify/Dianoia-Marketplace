@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            <img src="{{ asset('img/dianoia_logo.png') }}" class="logo app-logo" alt="Dianoia Marketplace Logo">
            <br>
            {{ $slot }}
        </a>
    </td>
</tr>
