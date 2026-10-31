<div class="min-h-screen bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-5 px-6 py-5">

            <!-- Logo -->
            <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">
                LaravelBlog
            </a>

            <!-- Navigation -->
            <div class="flex items-center gap-6">
                <a href="{{ route('home') }}"
                   class="text-gray-700 hover:text-blue-600">
                    Home
                </a>

                <a href="{{ route('home') }}#articles"
                   class="text-gray-700 hover:text-blue-600">
                    Articles
                </a>

                <a href="#about"
                   class="text-gray-700 hover:text-blue-600">
                    About
                </a>
            </div>

            <!-- Authentication -->
            <div class="flex items-center gap-4">

                @auth
                    @can('view users')
                        <a href="{{ route('admin.dashboard') }}"
                        class="font-medium text-purple-600 hover:text-purple-700">
                            Admin Dashboard
                        </a>
                    @endcan
                    
                    <a href="{{ route('posts.mine') }}"
                       class="font-medium text-gray-700 hover:text-blue-600">
                        My Articles
                    </a>

                    <a href="{{ route('posts.create') }}"
                       class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">
                        + Write Article
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit"
                                class="font-medium text-red-600 hover:text-red-700">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="font-medium text-blue-600 hover:text-blue-700">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">
                        Register
                    </a>
                @endauth

            </div>

        </div>
    </nav>

    <!-- Hero Section -->
    <section class="px-6 py-24 text-center">

        <h2 class="mb-6 text-5xl font-bold text-gray-900">
            Welcome to LaravelBlog
        </h2>

        <p class="mx-auto mb-8 max-w-2xl text-lg text-gray-600">
            Discover interesting articles about programming,
            technology, and web development.
        </p>

        <a href="#articles"
           class="inline-block rounded-lg bg-blue-600 px-8 py-3 font-semibold text-white hover:bg-blue-700">
            Explore Articles
        </a>

    </section>

    <!-- Latest Articles -->
    <section id="articles" class="mx-auto max-w-6xl px-6 pb-20">

        <h2 class="mb-8 text-3xl font-bold text-gray-900">
            Latest Articles
        </h2>

        <!-- Livewire Post List -->
        <livewire:pages.post-list />

    </section>

    <!-- About Section -->
    <section id="about" class="bg-white px-6 py-16 text-center">

        <h2 class="mb-4 text-3xl font-bold text-gray-900">
            About LaravelBlog
        </h2>

        <p class="mx-auto max-w-2xl text-gray-600">
            LaravelBlog is a modern blogging platform built with
            Laravel 12, Livewire 4, and Tailwind CSS.
        </p>

    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 px-6 py-6 text-center text-gray-300">
        <p>
            &copy; {{ date('Y') }} LaravelBlog. All rights reserved.
        </p>
    </footer>

</div>
