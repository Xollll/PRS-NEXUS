@extends('layouts.app')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold mb-4">Create Member</h2>

        <form action="{{ route('admin.members.store') }}" method="POST">
            @csrf
            <div class="mb-2">
                <label class="block">Full Name</label>
                <input name="full_name" class="border px-2 py-1 w-full" value="{{ old('full_name') }}" />
            </div>
            <div class="mb-2">
                <label class="block">Matric No</label>
                <input name="matric_no" class="border px-2 py-1 w-full" value="{{ old('matric_no') }}" />
            </div>
            <div class="mb-2">
                <label class="block">Email</label>
                <input type="email" name="email" required class="border px-2 py-1 w-full" value="{{ old('email') }}" />
            </div>
            <div class="mb-2">
                <label class="block">Member Portal Password</label>
                <input type="password" name="password" required class="border px-2 py-1 w-full" />
            </div>
            <div class="mb-2">
                <label class="block">Confirm Password</label>
                <input type="password" name="password_confirmation" required class="border px-2 py-1 w-full" />
            </div>
            <div class="mb-2">
                <label class="block">Phone</label>
                <input name="phone" class="border px-2 py-1 w-full" value="{{ old('phone') }}" />
            </div>
            <div class="mb-2">
                <label class="block">Programme</label>
                <input name="programme" class="border px-2 py-1 w-full" value="{{ old('programme') }}" />
            </div>
            <div class="mb-2">
                <label class="block">Committee Position</label>
                <select name="committee_position_id" class="border px-2 py-1 w-full">
                    <option value="">No assigned position</option>
                    @foreach($committeePositions as $position)
                        <option value="{{ $position->id }}" @selected(old('committee_position_id') == $position->id)>{{ $position->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-2">
                <label class="block">Custom Role Title <span class="text-sm">(optional fallback)</span></label>
                <input name="role_title" class="border px-2 py-1 w-full" value="{{ old('role_title') }}" />
            </div>
            <div class="mb-2">
                <label class="block">Status</label>
                <select name="status" class="border px-2 py-1 w-full">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div>
                <button class="bg-blue-600 text-white px-3 py-1 rounded">Create</button>
                <a href="{{ route('admin.members.index') }}" class="ml-2">Cancel</a>
            </div>
        </form>
    </div>
@endsection
