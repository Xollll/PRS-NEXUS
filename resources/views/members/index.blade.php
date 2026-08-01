@extends('layouts.app')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Members</h2>
            <a href="{{ route('admin.members.create') }}" class="bg-green-600 text-white px-3 py-1 rounded">New Member</a>
        </div>

        <form method="GET" class="mb-4">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by name, email or matric" class="border px-2 py-1" />
            <button class="ml-2 bg-gray-700 text-white px-2 py-1">Search</button>
        </form>

        <table class="w-full table-auto">
            <thead>
                <tr class="text-left">
                    <th class="px-2">Name</th>
                    <th class="px-2">Matric</th>
                    <th class="px-2">Email</th>
                    <th class="px-2">Role</th>
                    <th class="px-2">Year</th>
                    <th class="px-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $m)
                    <tr class="border-t">
                        <td class="px-2 py-2">{{ $m->full_name }}</td>
                        <td class="px-2">{{ $m->matric_no }}</td>
                        <td class="px-2">{{ $m->email }}</td>
                        <td class="px-2">{{ $m->display_role }}</td>
                        <td class="px-2">{{ $m->programme }}</td>
                        <td class="px-2">
                            <a href="{{ route('admin.members.show', $m) }}" class="text-blue-600">View</a>
                            <a href="{{ route('admin.members.edit', $m) }}" class="ml-2 text-yellow-600">Edit</a>
                            <form action="{{ route('admin.members.destroy', $m) }}" method="POST" style="display:inline" data-confirm="Delete {{ $m->full_name }}? This cannot be undone.">
                                @csrf
                                @method('DELETE')
                                <button class="ml-2 text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $members->withQueryString()->links() }}
        </div>
    </div>
@endsection
