@extends('layoutes.admin', ['title' => 'Edit Profile'])

@section('main')
    <main class="flex-1 p-6">
        <h2 class=" text-3xl font-semibold mb-4">Edit Profile </h2>
        @if (session()->has('message'))
            <input type="hidden" id="message" value="{{ session('message') }}">
        @endif
        <div class=" bg-white p-6 rounded shadow-sm">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <input type="file" id="avatar" name="avatar" class=" hidden">
                    <img src="{{ asset($user->avatar) }}" class=" w-36 mt-2" alt="">
                    <label for="avatar"
                        class=" w-36 mt-2 cursor-pointer flex items-center justify-center px-2 py-2 bg-blue-600 text-white rounded ">
                        Select avatar
                    </label>
                    @error('avatar')
                        <small class=" text-red-500 px-3 ">{{ $message }}</small>
                    @enderror
                </div>
                <div class=" grid grid-cols-2 gap-2">
                    <div class=" mb-3">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" placeholder="Enter name"
                            class=" w-full bg-gray-100 rounded-md p-2 mb-1 mt-2 " value="{{ $user->name }}">
                        @error('name')
                            <small class=" text-red-500 px-3 ">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class=" mb-3">
                        <label for="family">Family</label>
                        <input type="text" name="family" id="family" placeholder="Enter family"
                            class=" w-full bg-gray-100 rounded-md p-2 mb-1 mt-2 " value="{{ $user->family }}">
                        @error('family')
                            <small class=" text-red-500 px-3 ">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class=" grid grid-cols-3 gap-2">
                    <div class=" mb-3">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" placeholder="Enter email" disabled
                            class=" w-full bg-gray-100 rounded-md p-2 mb-1 mt-2 " value="{{ $user->email }}">
                        @error('email')
                            <small class=" text-red-500 px-3 ">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class=" mb-3">
                        <label for="status">Role</label>
                        <select name="role" id="role" disabled class="multiple-select w-full mt-2 mb-1">

                            @foreach (App\Enums\UserRoleEnum::cases() as $item)
                                <option value="{{ $item->value }}" {{ $user->role == $item ? 'selected' : '' }}>
                                    {{ $item->name }} </option>
                            @endforeach

                        </select>
                        @error('role')
                            <small class=" text-red-500 px-3 ">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class=" mb-3">
                        <label for="status">Status</label>
                        <select name="status" id="status" disabled class="multiple-select w-full mt-2 mb-1">
                            <option value="active"
                                {{ old('status', $user->status ? 'active' : 'inactive') == 'active' ? 'selected' : '' }}>
                                Active</option>
                            <option value="inactive"
                                {{ old('status', $user->status ? 'active' : 'inactive') == 'inactive' ? 'selected' : '' }}>
                                inactive
                            </option>
                        </select>
                        @error('status')
                            <small class=" text-red-500 px-3 ">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <hr class=" my-3">
                <div class=" w-full text-blue-600 mb-6 text-center">
                    if you don`t to change password, please don`t fill bottom fields.

                </div>
                <div class=" grid grid-cols-2 gap-2">
                    <div class=" mb-3">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Enter password"
                            class=" w-full bg-gray-100 rounded-md p-2 mb-1 mt-2 ">
                        @error('password')
                            <small class=" text-red-500 px-3 ">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class=" mb-3">
                        <label for="password_confirmation">Password confirmation</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            placeholder="Enter Password confirmation" class=" w-full bg-gray-100 rounded-md p-2 mb-1 mt-2 ">
                        @error('password_confirmation')
                            <small class=" text-red-500 px-3 ">{{ $message }}</small>
                        @enderror
                    </div>

                </div>
                <div class=" mb-3">
                    <button type=" submit" class=" bg-green-700 text-white rounded-md p-2 cursor-pointer">Update
                        User </button>
                </div>
            </form>
        </div>
    </main>
@endsection
