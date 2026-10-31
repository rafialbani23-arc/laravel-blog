<div class="min-h-screen bg-slate-100 text-slate-900">

    <div class="flex min-h-screen">

        <!-- SIDEBAR -->
        <aside class="hidden w-64 shrink-0 bg-slate-950 p-6 text-white md:block">

            <h1 class="mb-10 text-2xl font-extrabold">
                Laravel<span class="text-blue-400">Blog</span>
            </h1>

            <nav class="space-y-3">

                <a href="{{ route('admin.dashboard') }}"
                   class="block rounded-xl bg-blue-600 px-4 py-3">
                    📊 Dashboard
                </a>

                <a href="{{ route('admin.posts') }}"
                   class="block rounded-xl px-4 py-3 hover:bg-slate-800">
                    📰 Manage Articles
                </a>

                <a href="{{ route('admin.users') }}"
                   class="block rounded-xl px-4 py-3 hover:bg-slate-800">
                    👥 Manage Users
                </a>

                <a href="{{ route('posts.create') }}"
                   class="block rounded-xl px-4 py-3 hover:bg-slate-800">
                    ✍️ Create Article
                </a>

                <a href="{{ route('home') }}"
                   class="block rounded-xl px-4 py-3 hover:bg-slate-800">
                    🌐 View Website
                </a>

            </nav>

        </aside>

        <!-- MAIN CONTENT -->
        <main class="min-w-0 flex-1 p-6 md:p-10">

            <div class="mb-10 flex flex-wrap items-center justify-between gap-4">

                <div>
                    <h1 class="text-3xl font-extrabold">
                        Admin Dashboard
                    </h1>

                    <p class="mt-2 text-slate-500">
                        Welcome back, {{ auth()->user()->name }} 👋
                    </p>
                </div>

                <a href="{{ route('home') }}"
                   class="rounded-xl bg-white px-5 py-3 shadow-sm">
                    ← Back to Website
                </a>

            </div>

            <!-- STATISTICS -->
            <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-5">

                @foreach ([
                    ['Total Articles', $totalPosts, '📰'],
                    ['Published', $publishedPosts, '✅'],
                    ['Drafts', $draftPosts, '📝'],
                    ['Users', $totalUsers, '👥'],
                    ['Comments', $totalComments, '💬'],
                ] as [$label, $value, $icon])

                    <div class="rounded-2xl bg-white p-6 shadow-sm">

                        <div class="mb-5 text-3xl">
                            {{ $icon }}
                        </div>

                        <p class="text-sm font-medium text-slate-500">
                            {{ $label }}
                        </p>

                        <h2 class="mt-2 text-3xl font-extrabold">
                            {{ $value }}
                        </h2>

                    </div>

                @endforeach

            </div>

            <!-- LATEST ARTICLES -->
            <div class="mt-10 overflow-hidden rounded-2xl bg-white shadow-sm">

                <div class="flex flex-wrap items-center justify-between gap-3 border-b p-6">

                    <h2 class="text-xl font-bold">
                        Latest Articles
                    </h2>

                    <a href="{{ route('admin.posts') }}"
                       class="font-semibold text-blue-600">
                        View All →
                    </a>

                </div>

                <div class="overflow-x-auto">

                    <table class="w-full text-left">

                        <thead class="bg-slate-50 text-sm text-slate-500">
                            <tr>
                                <th class="p-5">Article</th>
                                <th class="p-5">Author</th>
                                <th class="p-5">Status</th>
                                <th class="p-5">Date</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($latestPosts as $post)

                                <tr class="border-t">

                                    <td class="p-5 font-semibold">
                                        {{ $post->title }}
                                    </td>

                                    <td class="p-5">
                                        {{ $post->user?->name ?? 'Unknown' }}
                                    </td>

                                    <td class="p-5">

                                        <span class="rounded-full px-3 py-1 text-xs font-bold
                                            {{ $post->status === 'published'
                                                ? 'bg-green-100 text-green-700'
                                                : 'bg-yellow-100 text-yellow-700' }}">

                                            {{ ucfirst($post->status) }}

                                        </span>

                                    </td>

                                    <td class="p-5 text-slate-500">
                                        {{ $post->created_at->format('d M Y') }}
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="4" class="p-10 text-center text-slate-500">
                                        No articles yet.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            <!-- QUICK ACTIONS -->
            <div class="mt-10 grid gap-5 md:grid-cols-3">

                <a href="{{ route('posts.create') }}"
                   class="rounded-2xl bg-blue-600 p-6 text-white transition hover:bg-blue-700">

                    <h3 class="text-xl font-bold">✍️ Create Article</h3>
                    <p class="mt-2 text-blue-100">
                        Write and publish a new article.
                    </p>

                </a>

                <a href="{{ route('admin.posts') }}"
                   class="rounded-2xl bg-white p-6 shadow-sm transition hover:shadow-md">

                    <h3 class="text-xl font-bold">📰 Manage Articles</h3>
                    <p class="mt-2 text-slate-500">
                        Edit and manage published articles.
                    </p>

                </a>

                <a href="{{ route('admin.users') }}"
                   class="rounded-2xl bg-white p-6 shadow-sm transition hover:shadow-md">

                    <h3 class="text-xl font-bold">👥 Manage Users</h3>
                    <p class="mt-2 text-slate-500">
                        Manage registered users and roles.
                    </p>

                </a>

            </div>

        </main>

    </div>

</div>
