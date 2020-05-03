@component('mail::message')
    Dear {{ $fullName }},

    Your order #{{ $orderId }} was accepted. We will shortly dispatch the items.

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
