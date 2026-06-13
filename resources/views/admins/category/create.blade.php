@extends('layoutes.admin', ['title' => 'Create New Category'])

@section('main')
    <main class="flex-1 p-6">
        <h2 class=" text-3xl font-semibold mb-4">Create New Category</h2>
        <div class=" bg-white p-6 rounded shadow-sm">
            <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                @method('POST')
                @csrf
                <div class=" mb-3">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" placeholder="Enter name"
                            class=" w-full bg-gray-100 rounded-md p-2 mb-1 mt-2 " value="{{ old('name') }}" >
                        @error('name')
                            <small class=" text-red-500 px-3 ">{{$message}}</small>
                        @enderror
                    </div>
                    <div class=" mb-3">
                        <button type=" submit" class=" bg-green-700 text-white rounded-md p-2 cursor-pointer" >Save Category</button>
                    </div>
            </form>
        </div>
    </main>
@endsection