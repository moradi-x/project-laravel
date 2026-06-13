@extends('layoutes.admin', ['title' => 'Edit comment' . $comment->name])

@section('main')
    <main class="flex-1 p-6">
        <h2 class=" text-3xl font-semibold mb-4">Edit comment {{ $comment->name }}</h2>
        <div class=" bg-white p-6 rounded shadow-sm">
            <form action="{{ route('comment.update', ['comment' => $comment->id]) }}" method="POST"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="flex grid grid-cols-3 justify-between gap-3">
                    <div class=" mb-3">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" placeholder="Enter name"
                            class=" w-full bg-gray-100 rounded-md p-2 mb-1 mt-2 " value="{{ $comment->name }}">
                        @error('name')
                            <small class=" text-red-500 px-3 ">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class=" mb-3">
                        <label for="email">email</label>
                        <input type="text" name="email" id="email" placeholder="Enter email"
                            class=" w-full bg-gray-100 rounded-md p-2 mb-1 mt-2 " value="{{ $comment->email }}">
                        @error('email')
                            <small class=" text-red-500 px-3 ">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="multiple-select py-2 w-full mt-2 mb-1">
                            @foreach ( App\Enums\CommentStatusEnum::cases() as $item )
                            <option value="{{ $item->value }}" {{ $item == $comment->status ? 'selected' : '' }}>{{$item->name}}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <small class=" text-red-500 px-3 ">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class=" mb-3">
                    <label for="comment">Comment</label>
                    <textarea type="text" name="comment" id="comment" class="w-full bg-gray-100 rounded-md p-2 mt-2 mb-1"
                        placeholder="Enter comment" rows="15">{{ $comment->comment }}</textarea>
                    @error('comment')
                        <small class=" text-red-500 px-3 ">{{ $message }}</small>
                    @enderror
                </div>
                <div class=" mb-3">
                    <button type=" submit" class=" bg-green-700 text-white rounded-md p-2 cursor-pointer">Update
                        comment</button>
                </div>
            </form>
        </div>
    </main>
@endsection
