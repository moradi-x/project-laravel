@extends('layoutes.template', ['title' => 'login page'])

@section('main')
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <div class="text-gray-800 font-semibold text-center ">
                <span class="text-yellow-500 text-xl">&lt;YELO&gt;</span> Code
            </div>
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">login in to WebSite</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form action="{{ route('authenticate') }}" method="POST" class="space-y-6">
                @method('POSt')
                @csrf
                <div>
                    <label for="email" class="block text-sm/6 font-medium text-gray-900">Email address</label>
                    <div class="mt-2">
                        <input id="email" type="text" name="email"  autocomplete="email" value=" {{ old('email') }}"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                        @error('email')
                            <div class="text-red-500 mt-1 text-sm ">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <div>
                    <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
                    <div class="mt-2">
                        <input id="password" type="password" name="password"  autocomplete="current-password"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                        @error('password')
                            <div class="text-red-500 mt-1 text-sm ">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md px-3 py-1.5 text-sm/6 font-semibold shadow-xs  bg-yellow-500 hover:bg-yellow-900 text-white cursor-pointer ">Sign
                        in</button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm/6 text-gray-500">
                Not a member?
                <a href="{{ route('register') }}" class="font-semibold text-yellow-500 hover:text-yellow-900">Register to
                    WebSite</a>
            </p>
        </div>
    </div>
@endsection
