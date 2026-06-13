@extends('layoutes.template', ['title' => $post->title])

@section('main')
    <main class="container mx-auto px-5 flex flex-grow">
        <article class="col-span-4 md:col-span-3 mt-10 mx-auto py-5 w-full" style="max-width:700px">
            <img class="w-full my-2 rounded-lg" src="{{ asset($post->thumbnail) }}" alt="{{ $post->title }}">
            <h1 class="text-4xl font-bold text-left text-gray-800">
                {{ $post->title }}
            </h1>
            <div class="mt-2 flex justify-between items-center">
                <div class="flex py-5 text-base items-center">
                    <img class="w-10 h-10 rounded-full mr-3" src="{{ asset('images/avatar.jpg') }}" alt="avatar">
                    <span class="mr-1">{{ $post->user->name . ' ' . $post->user->family }}</span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-500 mr-2">{{ $post->created_at->diffForHumans() }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.3"
                        stroke="currentColor" class="w-5 h-5 text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <div
                class="article-actions-bar my-6 flex text-sm items-center justify-between border-t border-b border-gray-100 py-4 px-2">
                <div class="flex items-center">
                    <a class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6 text-gray-600 hover:text-gray-900">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                        </svg>
                        <span class="text-gray-600 ml-2">
                            1
                        </span>
                    </a>
                </div>
                <div>
                    <div class="flex items-center">
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5 text-gray-500 hover:text-gray-800">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                            </svg>
                        </button>

                    </div>
                </div>
            </div>

            <div class="article-content py-3 text-gray-800 text-lg text-justify">
                {!! nl2br($post->content) !!}
            </div>

            @if ($post->categories->count())
                <div class="flex items-center space-x-4 mt-10">
                    @foreach ($post->categories as $category)
                        <a href="{{ route('category', ['category' => $category->id]) }}"
                            class="bg-blue-400 text-white rounded-xl px-3 py-1 text-base">{{ $category->name }}</a>
                    @endforeach
                </div>
            @endif
            @include('partials.comment')
        </article>
    </main>

@endsection
