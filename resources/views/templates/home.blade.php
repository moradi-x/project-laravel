@extends('layoutes.template')

@section('main')
<main class="container mx-auto px-5 ">
    <div class="mb-16">
        <h2 class="mt-16 mb-5 text-3xl text-yellow-500 font-bold">Random Posts</h2>
        @if ($randomPosts->count())
        <div class="w-full">
            <div class="grid grid-cols-3 gap-10 w-full">
                @foreach ($randomPosts as $post)

                <div class="md:col-span-1 col-span-3">
                    <a href="{{ route('single' , ['post' => $post->slug]) }}">
                        <div>
                            <img class="w-full rounded-x1"
                                src="{{ $post->thumbnail }}">
                        </div>
                    </a>
                    <div class="mt-3">
                        <div class="flex items-center mb-2">
                            <a href="{{ route('category' , ['category' => $post->categories->first()->id ]) }}" class="bg-red-600
                                        text-white
                                        rounded-xl px-3 py-1 text-sm mr-3">
                                {{ $post->categories->first()->name }}
                            </a>
                            <p class="text-gray-500 text-sm">{{ $post->created_at->format('d M Y - l ') }}</p>
                        </div>
                        <a href="{{ route('single' , ['post' => $post->slug]) }}" class="text-xl font-bold text-gray-900">{{ $post->title }}</a>
                    </div>

                </div>
                @endforeach
            </div>
        </div>
         @else
             <div class="bg-gray-300 p-5 text-center ">
                Dos Not exists any data
            </div>
        @endif
    </div>

    <hr>

    <div>

        <h2 class="mt-16 mb-5 text-3xl text-yellow-500 font-bold">Latest Posts</h2>
        @if ($posts->count())
        <div class="w-full mb-5">
            <div class="grid grid-cols-3 gap-10 gap-y-32 w-full">
                @foreach ($posts as $post)
                <div class="md:col-span-1 col-span-3">
                    <a href="{{ route('single' , ['post' => $post->slug]) }}">
                        <div>
                            <img class="w-full rounded-xl" src="{{ $post->thumbnail }}">
                        </div>
                    </a>
                    <div class="mt-3">
                        <div class="flex items-center mb-2">
                            <a href="{{ route('category' , ['category' =>$post->categories->first()->id ]) }}" class="bg-red-600 text-white rounded-xl px-3 py-1 text-sm mr-3">
                                {{ $post->categories->first()->name }}
                            </a>
                            <p class="text-gray-500 text-sm">{{ $post->created_at->format('d M Y - l ') }}</p>
                        </div>
                        <a href="{{ route('single' , ['post' => $post->slug]) }}">

                        <h3 class="text-xl font-bold text-gray-900">{{ $post->title }}</h3>
</a>
                        <small> {{ $post->user->name }} {{ $post->user->family }} </small>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="bg-gray-300 p-5 text-center ">
            Dos Not exists any data
        </div>
        @endif
        <a class="mt-10 block text-center text-lg text-yellow-500 font-semibold"
            href="{{ route('blog') }}">More Posts
        </a>
    </div>
</main>

@endsection
