@extends('layoutes.admin', ['title' => 'List Of posts'])

@section('main')
    <main class="flex-1 p-6">
        <h2 class=" text-3xl font-semibold mb-4">List Of {{ request()->has('trash') ? 'trash' : '' }} Posts </h2>
        <div class=" bg-white p-6 rounded shadow-sm">
            @if (session()->has('message'))
                <input type="hidden" id="message" value="{{ session('message') }}">
            @endif
            <div class=" py-4 flex justify-between ">
                <div>
                    <a class=" p-2 bg-green-700 text-white rounded-md cursor-pointer" href="{{ route('post.create') }}">
                        Add Post</a>
                    @if (request()->has('trash'))
                        <a class=" p-2 bg-cyan-700 text-white rounded-md cursor-pointer" href="{{ route('post.index') }}">
                            All Posts</a>
                    @else
                        <a class=" p-2 bg-gray-700 text-white rounded-md cursor-pointer"
                            href="{{ route('post.index', ['trash' => 'active']) }}">Trash Posts</a>
                    @endif
                </div>
                <form action="{{ route('post.index') }}" class=" flex gap-2">
                    <input type="text" value="{{ request('search') }}" name="search"
                        placeholder="Search in to post table" class=" py-2 bg-gray-100 rounded-md">
                    @if (request()->has('trash'))
                        <input type="hidden" name="trash" value="active">
                    @endif
                    <button type="submit" class=" p-2 bg-blue-700 text-white rounded-md cursor-pointer">Search</button>
                    @if (request()->has('search'))
                        <a href="{{ route('post.index') }}"
                            class=" p-2 bg-cyan-700 text-white rounded-md cursor-pointer">Remove Search</a>
                    @endif
                </form>
            </div>
            @if ($posts->count())
                <div class="overflow-x-auto bg-white rounded shadow">
                    <table class="min-w-full border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class=" py-3 px-4 border-b">#</th>
                                <th class=" py-3 px-4 border-b">Title</th>
                                <th class=" py-3 px-4 border-b">Status</th>
                                <th class=" py-3 px-4 border-b">user</th>
                                <th class=" py-3 px-4 border-b">Comment Count</th>
                                <th class=" py-3 px-4 border-b">Created At</th>
                                <th class=" py-3 px-4 border-b text-right ">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($posts as $post)
                                <tr class="hover:bg-gray-50 text-center ">
                                    <td class="px-4 py-3 border-b">{{ $post->id }}</td>
                                    <td class="px-4 py-3 border-b">{{ $post->title }}</td>
                                    <td class="px-4 py-3 border-b text-center">
                                        @if ($post->status)
                                            <span class=" text-white bg-green-700 py-1 px-4 rounded-md"> Active </span>
                                        @else
                                            <span class=" text-white bg-red-700 py-1 px-4 rounded-md"> Inactive </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 border-b">{{ $post->user->name . ' ' . $post->user->family }}
                                    </td>
                                    <td class="px-4 py-3 border-b">
                                        @if ($post->comments_count)
                                            {{ $post->comments_count }} <small> Comments </small>
                                        @else
                                            <small class=" text-red-700"> Without Comment </small>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 border-b">{{ $post->created_at->format('d M Y - l | H:m') }}
                                    </td>

                                    <td class="py-3 px-4 border-b text-right ">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('post.edit', ['post' => $post->id]) }}"
                                                class=" text-blue-500 hover:underline">Edit</a>
                                            <button type="button"
                                                onclick="deleteitem({{ $post->id }}, '{{ $post->title }}')"
                                                class="text-red-500 hover:underline cursor-pointer">Delete</button>
                                            <form id="delete-item-{{ $post->id }}"
                                                action="{{ route('post.destroy', ['post' => $post->id]) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                            </form>

                                            <button type="button"
                                                onclick="changeitem({{ $post->id }}, '{{ $post->title }}')"
                                                class="text-cyan-500 hover:underline cursor-pointer">Change</button>
                                            <form id="change-item-{{ $post->id }}"
                                                action="{{ route('post.change', ['post' => $post->id]) }}" method="POST">
                                                @method('patch')
                                                @csrf
                                            </form>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class=" py-5">
                        {{ $posts->links() }}
                    </div>
                </div>
            @else
                <div class=" py-4 bg-gray-100 text-center">
                    Does not exists sny post
                </div>
            @endif
        </div>
    </main>
@endsection
