@extends('layoutes.admin', ['title' => 'Edit Category' . $category->name])

@section('main')
    <main class="flex-1 p-6">
        <h2 class=" text-3xl font-semibold mb-4">Edit Category {{ $category->name }}</h2>
        <div class=" bg-white p-6 rounded shadow-sm">
            <form action="{{ route('category.update', ['category' => $category->id ]) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class=" mb-3">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" placeholder="Enter name"
                            class=" w-full bg-gray-100 rounded-md p-2 mb-1 mt-2 " value="{{ $category->name }}" >
                        @error('name')
                            <small class=" text-red-500 px-3 ">{{$message}}</small>
                        @enderror
                    </div>
                    <div class=" mb-3">
                        <button type=" submit" class=" bg-green-700 text-white rounded-md p-2 cursor-pointer" >Update Category</button>
                    </div>
            </form>
        </div>
    </main>
@endsection