@if (isset($currencies))
<div class="currencies">
    <h2>{{ Lang::get('client.currencies.line1', ['date' => $currencies['date']]) }}</h2>
    <p>{{ Lang::get('client.currencies.line2', ['date' => $currencies['date']]) }}</p>
    @foreach (['USD', 'EUR', 'RUB'] as $currency)
        <div class="currenciesBlock">
            <span class="{{ strtolower($currency) }}">1 {{ $currency }}</span>
            <span><span>{{ $currencies['currency'][$currency] }}</span> {{ Lang::get('client.currencies.sum') }}</span>
        </div>
    @endforeach
</div>
@endif