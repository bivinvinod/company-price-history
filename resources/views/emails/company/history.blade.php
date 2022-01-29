@component('mail::message')
# Start Date and End Date
From {{ $fromDate }} to {{ $toDate }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
