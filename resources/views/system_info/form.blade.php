@csrf
<div class="mb-3">
    <label>Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $system_info->name ?? '') }}">
</div>

<div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $system_info->email ?? '') }}">
</div>

<div class="mb-3">
    <label>Description</label>
    <textarea name="description" class="form-control">{{ old('description', $system_info->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label>Phone Number</label>
    <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $system_info->phone_number ?? '') }}">
</div>

<div class="mb-3">
    <label>Address</label>
    <input type="text" name="address" class="form-control" value="{{ old('address', $system_info->address ?? '') }}">
</div>

<div class="mb-3">
    <label>Logo</label>
    <input type="file" name="logo" class="form-control">
    @if(isset($system_info) && $system_info->logo)
        <img src="{{ asset('storage/'.$system_info->logo) }}" width="100" class="mt-2">
    @endif
</div>

<button type="submit" class="btn btn-success">{{ $button ?? 'Save' }}</button>
