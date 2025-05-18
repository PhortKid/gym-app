@component('mail::message')
# Hello {{ $customer->full_name }}

Thank you for registering. Attached is your unique QR code.

Thanks,  
{{ config('app.name') }}
@endcomponent
