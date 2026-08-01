@extends('layouts.app')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold mb-4">Member Details</h2>

        <div class="mb-2"><strong>Full Name:</strong> {{ $member->full_name }}</div>
        <div class="mb-2"><strong>Matric:</strong> {{ $member->matric_no }}</div>
        <div class="mb-2"><strong>Email:</strong> {{ $member->email }}</div>
        <div class="mb-2"><strong>Phone:</strong> {{ $member->phone }}</div>
        <div class="mb-2"><strong>Programme:</strong> {{ $member->programme }}</div>
        <div class="mb-2"><strong>Role:</strong> {{ $member->display_role }}</div>
        <div class="mb-2"><strong>Status:</strong> {{ $member->status }}</div>

        <div class="mt-4">
            <a href="{{ route('admin.members.edit', $member) }}" class="bg-yellow-600 text-white px-3 py-1 rounded">Edit</a>
            <a href="{{ route('admin.members.index') }}" class="ml-2">Back</a>
        </div>
    </div>
@endsection
