@extends('workspace_layout.app')

@section('content')
<div class="container">
    <h2>Add System Info</h2>
    <form action="{{ route('system-info.store') }}" method="POST" enctype="multipart/form-data">
        @include('system_info.form', ['button' => 'Create'])
    </form>
</div>
@endsection
