@extends('workspace_layout.app')

@section('content')
<div class="container">
    <h2>System Info</h2>
    <a href="{{ route('system-info.create') }}" class="btn btn-primary mb-3">Add New</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th><th>Email</th><th>Phone</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($infos as $info)
                <tr>
                    <td>{{ $info->name }}</td>
                    <td>{{ $info->email }}</td>
                    <td>{{ $info->phone_number }}</td>
                    <td>
                        <a href="{{ route('system-info.edit', $info->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('system-info.destroy', $info->id) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this info?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
