 <header class="flex items-center justify-between py-3 px-6 border-b border-gray-100">
        <div id="header-left" class="flex items-center">
            <div class="text-gray-800 font-semibold">
                <span class="text-yellow-500 text-xl">&lt;YELO&gt;</span> Code
            </div>
            <div class="top-menu ml-10">
                <ul class="flex space-x-4">
                    <li>
                        <a href="{{ route('home') }}" class="flex space-x-2 items-center text-sm {{ request()->route()->getName() == 'home' ? ' text-yellow-500 hover:text-yellow-900' :' hover:text-yellow-500  text-gray-500 ' }} "
                            >
                            Home
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('blog') }}" class="flex space-x-2 items-center text-sm {{ request()->route()->getName() == 'blog' ? ' text-yellow-500 hover:text-yellow-900' :' hover:text-yellow-500  text-gray-500' }} "
                            >
                            Blog
                        </a>
                    </li>

                </ul>
            </div>
        </div>
        <div id="header-right" class="flex items-center md:space-x-6">
            <div class="flex space-x-5">
                <a class="flex space-x-2 items-center  text-sm {{ request()->route()->getName() == 'login' ? ' text-yellow-500 hover:text-yellow-900' :' hover:text-yellow-500  text-gray-500' }} "
                    href="{{ route('login') }}">
                    Login
                </a>
                <a class="flex space-x-2 items-center   {{ request()->route()->getName() == 'register' ? ' text-yellow-500 hover:text-yellow-900' :' hover:text-yellow-500  text-gray-500' }}"
                    href="{{ route('register') }}">
                    Register
                </a>
            </div>
        </div>
    </header>

    @if( request()->route()->getName() == 'home' )
    <div class="w-full text-center py-32">
        <h1 class="text-2xl md:text-3xl font-bold text-center lg:text-5xl text-gray-700">
            Welcome to <span class="text-yellow-500">&lt;YELO&gt;</span> <span class="text-gray-900"> News</span>
        </h1>
        <p class="text-gray-500 text-lg mt-1">Best Blog in the universe</p>
        <a class="px-3 py-2 text-lg text-white bg-gray-800 rounded mt-5 inline-block"
            href="http://127.0.0.1:8000/blog">Start
            Reading</a>
    </div>
    @endif
