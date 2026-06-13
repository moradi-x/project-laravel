    <aside class="w-64 bg-white shadow-md p-4 space-y-6">
      <h1 class=" text-2xl font-bold text-blue-600" > Admin Page </h1>
      <nav class=" space-y-2">
        <a href="{{ route('dashbord') }}" class="block px-4 py-4 rounded hover:bg-blue-100 text-gray-700 ">Dashboard</a>
        <a href="{{ route('post.index')  }}" class="block px-4 py-4 rounded hover:bg-blue-100 text-gray-700 ">Post</a>
        <a href="{{ route('category.index')  }}" class="block px-4 py-4 rounded hover:bg-blue-100 text-gray-700 ">Category</a>
        <a href="{{ route('comment.index')  }}" class="block px-4 py-4 rounded hover:bg-blue-100 text-gray-700 ">Comment</a>
        <a href="{{ route('user.index')  }}" class="block px-4 py-4 rounded hover:bg-blue-100 text-gray-700 ">User</a>
        <a href="{{ route('profile.edit')  }}" class="block px-4 py-4 rounded hover:bg-blue-100 text-gray-700 ">Profile</a>
        <a href="{{ route('logout')  }}" class="block px-4 py-4 rounded hover:bg-red-200 text-gray-700 ">Logout</a>
      </nav>
    </aside>