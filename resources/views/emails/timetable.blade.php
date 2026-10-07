<x-mail::message>
# Tunniplaan

{{ $startDate->format('d.m.Y') }} – {{ $endDate->format('d.m.Y') }}

@forelse ($timetableEvents as $day => $events)
## {{ ucfirst($day) }}

@foreach ($events as $event)
- **{{ $event['timeStart'] }} – {{ $event['timeEnd'] }}**: {{ $event['nameEt'] }}
@endforeach

@empty
Sellel nädalal tunde ei ole.
@endforelse
</x-mail::message>
