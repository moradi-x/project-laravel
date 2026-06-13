@extends('layoutes.admin', ['title' => 'Create New Post'])

@section('main')
<main class="flex-1 p-6">
    <h2 class=" text-3xl font-semibold mb-4">Create New Post</h2>
    <div class=" bg-white p-6 rounded shadow-sm">
        <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data" >
            @method('POST')
            @csrf
            <div class=" flex justify-between gap-8 ">
                <div class=" w-3/4">
                    <div class=" mb-3">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" placeholder="Enter Title"
                            class=" w-full bg-gray-100 rounded-md p-2 mb-1 mt-2 " value="{{ old('title') }}" >
                        @error('title')
                            <small class=" text-red-500 px-3 ">{{$message}}</small>
                        @enderror
                    </div>

                    <div class=" mb-3">
                        <label for="content">Content</label>
                        <textarea type="text" name="content" id="content" class="w-full bg-gray-100 rounded-md p-2 mt-2 mb-1"
                            placeholder="Enter content" rows="15">{{ old('content') }}</textarea>
                        @error('content')
                            <small class=" text-red-500 px-3 ">{{$message}}</small>
                        @enderror
                    </div>

                </div>

                <div class="w-1/4">
                    <div class="mb-3">
                        <label for="thumbnail" class=" cursor-pointer flex items-center justify-center px-2 py-2 bg-blue-600 text-white rounded " >
                            Select Thumbnail
                        </label>
                        <input type="file" id="thumbnail" name="thumbnail" class=" hidden" >
                        @error('thumbnail')
                            <small class=" text-red-500 px-3 ">{{$message}}</small>
                        @enderror 
                    </div>
                    <div class=" mb-3">
                        <label for="categories">Categories</label>
                        <select name="categories[]" id="categories" class="multiple-select py-2 w-full mt-2 mb-1"
                            multiple >
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ 
                                ( old('categories') and in_array($category->id ,  old( 'categories')) ) ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('categories')
                            <small class=" text-red-500 px-3 ">{{$message}}</small>
                        @enderror 
                    </div>


                    <div class=" mb-3">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="multiple-select w-full mt-2 mb-1">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }} >Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }} >inactive</option>
                        </select>
                        @error('status')
                            <small class=" text-red-500 px-3 ">{{$message}}</small>
                        @enderror
                    </div>
                    <div class=" mb-3">
                        <button type=" submit" class=" bg-green-700 w-full text-white rounded-md p-2 cursor-pointer" >Save Post</button>
                    </div>
                </div>



            </div>
        </form>
    </div>
</main>
@endsection
