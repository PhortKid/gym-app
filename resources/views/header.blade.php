<div class="d-flex align-items-center">
    <img src="/logos/{{ $system->logo ?? 'App Name' }}" alt="Company Logo" class="company-logo me-3">
  <div>
    <h3 class="mb-1"> {{ $system->name ?? 'App Name' }}</h3>
    <p class="mb-0">{{ $system->description ?? 'App Description' }}</p>
    <p class="mb-0">Email: {{ $system->email ?? 'App Email' }}| Phone: {{ $system->phone_number ?? 'App Phone Number' }}</p>
    <p class="mb-0">Address: {{ $system->address ?? 'App Address' }}</p>
 </div>
</div>