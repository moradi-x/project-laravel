@extends('layoutes.template', ['title' => 'blog page'])

@section('main')

    <main class="container mx-auto px-5 flex flex-grow ">
        <div class="w-full grid grid-cols-4 gap-10">
            <div class="md:col-span-3 col-span-4">
                <div id="posts" class=" px-3 lg:px-7 py-6">
                    <div class="flex justify-between items-center border-b border-gray-100">
                        <div id="filter-selector" class="flex items-center space-x-4 font-light ">
                            <a class="text-gray-500 py-4
                             {{ request('order') != 'asc' ? 'text-gray-900 border-b border-gray-900 ' : '' }} "
                                href=" {{ route('blog', ['order' => 'desc']) }} ">Latest</a>

                            <a class="text-gray-500 py-4
                             {{ request('order') == 'asc' ? 'text-gray-900 border-b border-gray-900 ' : '' }} "
                                href=" {{ route('blog', ['order' => 'asc']) }}">Oldest</a>
                        </div>
                    </div>

                    @if ($posts->count())
                        <div class="py-4">
                            @foreach ($posts as $post)
                                <article class="[&:not(:last-child)]:border-b border-gray-100 pb-10">
                                    <div class="article-body grid grid-cols-12 gap-3 mt-5 items-start">
                                        <div class="article-thumbnail col-span-4 flex items-center">
                                            <a href="{{ route('single', ['post' => $post->slug]) }}">
                                                <img class="mw-100 mx-auto rounded-xl" src="{{ $post->thumbnail }}"
                                                    alt="thumbnail">
                                            </a>
                                        </div>
                                        <div class="col-span-8">
                                            <div class="article-meta flex py-1 text-sm items-center">
                                                <img class="w-7 h-7 rounded-full mr-3"
                                                    src="{{ asset('images/avatar.jpg') }}" alt="avatar">
                                                <span class="mr-1 text-xs">{{ $post->user->name }}
                                                    {{ $post->user->family }}</span>
                                                <span
                                                    class="text-gray-500 text-xs">{{ $post->created_at->diffForHumans() }}</span>
                                            </div>
                                            <h2 class="text-xl font-bold text-gray-900">
                                                <a href="{{ route('single', ['post' => $post->slug]) }}">
                                                    {{ $post->title }}
                                                </a>
                                            </h2>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-300 p-5 text-center ">
                            Dos Not exists any data
                        </div>
                    @endif
                </div>
                <div class="py-3">
                    {{ $posts->links() }}

                </div>
            </div>
            @include('partials.sidebar')
        </div>
    </main>

@endsection
