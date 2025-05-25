@extends('workspace_layout.app')

@section('content')
<div class="container">
    <h2>Edit System Info</h2>
    <form action="{{ route('system-info.update', $system_info->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('system_info.form', ['button' => 'Update'])
    </form>
</div>
@endsection
