@extends('layoutes.admin', ['title' => 'List Of categories'])

@section('main')
    <main class="flex-1 p-6">
        <h2 class=" text-3xl font-semibold mb-4">List Of categories </h2>
        <div class=" bg-white p-6 rounded shadow-sm">
            @if (session()->has('message'))
                <input type="hidden" id="message" value="{{ session('message') }}">
            @endif

            <div class=" py-4 flex justify-between ">
                <div>
                    <a class=" p-2 bg-green-700 text-white rounded-md cursor-pointer" href="{{ route('category.create') }}">
                        Add category</a>
                </div>
                <form action="{{ route('category.index') }}" class=" flex gap-2">
                    <input type="text" value="{{ request('search') }}" name="search"
                        placeholder="Search in to post table" class=" py-2 bg-gray-100 rounded-md">
                    <button type="submit" class=" p-2 bg-blue-700 text-white rounded-md cursor-pointer">Search</button>
                    @if (request()->has('search'))
                        <a href="{{ route('category.index') }}"
                            class=" p-2 bg-cyan-700 text-white rounded-md cursor-pointer">Remove Search</a>
                    @endif
                </form>
            </div>
            @if ($categories->count()) 

                <div class="overflow-x-auto bg-white rounded shadow">
                    <table class="min-w-full border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class=" py-3 px-4 border-b"> # </th>
                                <th class=" py-3 px-4 border-b"> Name </th>
                                <th class=" py-3 px-4 border-b">Post Count</th>
                                <th class=" py-3 px-4 border-b">Created At</th>
                                <th class=" py-3 px-4 border-b text-right "> Action </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($categories as $category)
                                <tr class="hover:bg-gray-50 text-center">
                                    <td class="px-4 py-3 border-b">{{ $category->id }}</td>
                                    <td class="px-4 py-3 border-b">{{ $category->name }}</td>
                                    <td class="px-4 py-3 border-b">
                                        @if ($category->posts_count)
                                            {{ $category->posts_count }} <small> Posts </small>
                                        @else
                                            <small class=" text-red-700"> Without Comment </small>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 border-b">{{ $category->created_at->format('d M Y - l | H:m') }}</td>

                                    <td class="py-3 px-4 border-b text-right ">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('category.edit', ['category' => $category->id]) }}"
                                                class=" text-blue-500 hover:underline">Edit</a>
                                            <button type="button"
                                                onclick="deleteitem({{ $category->id }}, '{{ $category->title }}')"
                                                class="text-red-500 hover:underline cursor-pointer">Delete</button>
                                            <form id="delete-item-{{ $category->id }}"
                                                action="{{ route('category.destroy', ['category' => $category->id]) }}" method="POST">
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
                        {{ $categories->links() }}
                    </div>
                </div>
            @else
                <div class=" py-4 bg-gray-100 text-center">
                    Does not exists sny category
                </div>
            @endif


        </div>
    </main>
@endsection
