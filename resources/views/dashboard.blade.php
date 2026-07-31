@extends('layouts.app')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold mb-4">Dashboard</h2>
        <p>Welcome to SiswaSphere prototype. Use the links below to manage data.</p>

        <div class="mt-4">
            <a href="{{ route('admin.members.index') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded">Manage Members</a>
        </div>
    </div>
@endsection
