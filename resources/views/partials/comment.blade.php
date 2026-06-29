 <div id="comment" class="mt-10 comments-box border-t border-gray-100 pt-10">
     <h2 class="text-2xl font-semibold text-gray-900 mb-5">Comment</h2>


     @if (session()->has('message'))
         <input type="hidden" id="message" value="{{ session('message') }}">
     @endif

     <form action="{{ route('comment', ['post' => $post->id]) }}" method="POST">
         @method('POST')
         @csrf
         <div class="grid grid-cols-2 gap-3 mb-3 ">
             <div>
                 <input type="text" name="name" placeholder="Enter your name" value="{{ old('name') }}"
                     class=" w-full rounded-lg p-4 bg-gray-200 focus:outline-none text-sm text-gray-700 border-gray-200 placeholder:text-gray-400">
                 @error('name')
                     <div class="text-red-500 mt-1 text-sm ">{{ $message }}</div>
                 @enderror
             </div>
             <div>
                 <input type="email" name="email" placeholder="Enter your email" value="{{ old('email') }}"
                     class="w-full rounded-lg p-4 bg-gray-200 focus:outline-none text-sm text-gray-700 border-gray-200 placeholder:text-gray-400">
                 @error('email')
                     <div class="text-red-500 mt-1 text-sm ">{{ $message }}</div>
                 @enderror
             </div>
         </div>

         <textarea name="comment" placeholder="Enter your text"
             class="w-full rounded-lg p-4 bg-gray-200 focus:outline-none text-sm text-gray-700 border-gray-200 placeholder:text-gray-400"
             cols="30" rows="7"> {{ old('comment') }}</textarea>
         @error('comment')
             <div class="text-red-500 mt-1 text-sm ">{{ $message }}</div>
         @enderror

         <div class=" flex mt-2 gap-2 justify-between " >
             <div class=" w-1/4" >
                 <img src="{{ captcha_src() }}" class=" w-full rounded-md"  alt="captcha">
             </div>

             <div class=" w-3/4" >
                 <input type="text" name="captcha" placeholder="Enter your captcha" value="{{ old('captcha') }}"
                     class="w-full rounded-lg p-4 bg-gray-200 focus:outline-none text-sm text-gray-700 border-gray-200 placeholder:text-gray-400">
                 @error('captcha')
                     <div class="text-red-500 mt-1 text-sm ">{{ $message }}</div>
                 @enderror
             </div>
         </div>

         <button type="submit"
             class="mt-3 inline-flex items-center justify-center h-10 px-4 font-medium tracking-wide text-white transition duration-200 bg-gray-900 rounded-lg hover:bg-gray-800 focus:shadow-outline focus:outline-none cursor-pointer ">
             Post Comment
         </button>


     </form>
     <!-- <a class="text-yellow-500 underline py-1" href=""> Login to Post Comments</a> -->

     <div class="user-comments px-3 py-2 mt-5">

         @if ($post->comments->count())
             @foreach ($post->comments as $comment)
                 <div class="comment [&:not(:last-child)]:border-b border-gray-100 py-5">
                     <div class="user-meta flex mb-4 text-sm items-center">
                         <img class="w-7 h-7 rounded-full mr-3" src="{{ asset('images/avatar.jpg') }}" alt="mn">
                         <span class="mr-1">{{ $comment->name }}</span>
                         <span class="text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                     </div>
                     <div class="text-justify text-gray-700  text-sm">
                         {{ $comment->comment }}
                     </div>
                 </div>
             @endforeach
         @else
             <div class="text-gray-500 text-center">
                 <span> No Comments Posted</span>
             </div>
         @endif
     </div>
 </div>
