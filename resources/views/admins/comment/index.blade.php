@extends('layoutes.admin', ['title' => 'List Of Comment'])

@section('main')
    <main class="flex-1 p-6">
        <h2 class=" text-3xl font-semibold mb-4">List Of Comment </h2>
        <div class=" bg-white p-6 rounded shadow-sm">
            @if (session()->has('message'))
                <input type="hidden" id="message" value="{{ session('message') }}">
            @endif

            <div class=" py-4 flex justify-between ">
                <form action="{{ route('comment.index') }}" class=" flex gap-2">
                    <input type="text" value="{{ request('search') }}" name="search"
                        placeholder="Search in to post table" class=" py-2 bg-gray-100 rounded-md">
                    <button type="submit" class=" p-2 bg-blue-700 text-white rounded-md cursor-pointer">Search</button>
                    @if (request()->has('search'))
                        <a href="{{ route('comment.index') }}"
                            class=" p-2 bg-cyan-700 text-white rounded-md cursor-pointer">Remove Search</a>
                    @endif
                </form>
            </div>
            @if ($comments->count()) 

                <div class="overflow-x-auto bg-white rounded shadow">
                    <table class="min-w-full border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class=" py-3 px-4 border-b"> # </th>
                                <th class=" py-3 px-4 border-b"> Name </th>
                                <th class=" py-3 px-4 border-b">Email</th>
                                <th class=" py-3 px-4 border-b">Post Title</th>
                                <th class=" py-3 px-4 border-b">Created At</th>
                                <th class=" py-3 px-4 border-b">Status</th>
                                <th class=" py-3 px-4 border-b text-right "> Action </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($comments as $comment)
                                <tr class="hover:bg-gray-50 text-center">
                                    <td class="px-4 py-3 border-b">{{ $comment->id }}</td>
                                    <td class="px-4 py-3 border-b">{{ $comment->name }}</td>
                                    <td class="px-4 py-3 border-b">{{ $comment->email }}</td>
                                    <td class="px-4 py-3 border-b">{{ $comment->post->title }}</td>
                                    <td class="px-4 py-3 border-b">
                                        @if ($comment->isAccept())
                                            <span class=" text-white bg-green-700 py-1 px-4 rounded-md"> Accept </span>
                                        @elseif($comment->isPending())
                                            <span class=" text-white bg-orange-700 py-1 px-4 rounded-md"> Pendding </span>
                                            @else
                                            <span class=" text-white bg-red-700 py-1 px-4 rounded-md"> Block </span> 
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 border-b">{{ $comment->created_at->format('d M Y - l | H:m') }}</td>

                                    <td class="py-3 px-4 border-b text-right ">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('comment.edit', ['comment' => $comment->id]) }}"
                                                class=" text-blue-500 hover:underline">Edit</a>
                                            <button type="button"
                                                onclick="deleteitem({{ $comment->id }}, '{{ $comment->title }}')"
                                                class="text-red-500 hover:underline cursor-pointer">Delete</button>
                                            <form id="delete-item-{{ $comment->id }}"
                                                action="{{ route('comment.destroy', ['comment' => $comment->id]) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class=" py-5">
                        {{ $comments->links() }}
                    </div>
                </div>
            @else
                <div class=" py-4 bg-gray-100 text-center">
                    Does not exists sny Comment
                </div>
            @endif
        </div>
    </main>
@endsection
