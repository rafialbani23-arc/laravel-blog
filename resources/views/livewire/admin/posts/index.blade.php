<div class="min-h-screen bg-gray-100 p-6 md:p-10">

    <div class="mx-auto max-w-7xl">

        <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    Manage Articles
                </h1>
                <p class="mt-2 text-gray-500">
                    Kelola seluruh artikel LaravelBlog.
                </p>
            </div>

            <a href="{{ route('admin.dashboard') }}"
               class="rounded-lg bg-gray-900 px-5 py-3 text-white">
                ← Dashboard
            </a>
        </div>

        @if (session()->has('success'))
            <div class="mb-6 rounded-lg bg-green-100 p-4 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6 rounded-xl bg-white p-5 shadow-sm">
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Cari judul artikel..."
                class="w-full rounded-lg border border-gray-300 p-3 focus:border-blue-500 focus:outline-none"
            >
        </div>

        <div class="overflow-x-auto rounded-xl bg-white shadow-sm">

            <table class="w-full text-left">

                <thead class="bg-gray-50 text-sm text-gray-600">
                    <tr>
                        <th class="p-4">Image</th>
                        <th class="p-4">Title</th>
                        <th class="p-4">Author</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($posts as $post)
                        <tr wire:key="post-{{ $post->id }}" class="border-t">

                            <td class="p-4">
                                @if ($post->image)
                                    <img
                                        src="{{ asset('storage/' . $post->image) }}"
                                        alt="{{ $post->title }}"
                                        class="h-16 w-24 rounded-lg object-cover"
                                    >
                                @else
                                    <div class="flex h-16 w-24 items-center justify-center rounded-lg bg-gray-100 text-xs text-gray-400">
                                        No Image
                                    </div>
                                @endif
                            </td>

                            <td class="p-4 font-semibold text-gray-900">
                                {{ $post->title }}
                            </td>

                            <td class="p-4 text-gray-600">
                                {{ $post->user?->name ?? 'Unknown' }}
                            </td>

                            <td class="p-4">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold
                                    {{ $post->status === 'published'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ ucfirst($post->status) }}
                                </span>
                            </td>

                            <td class="p-4">
                                <div class="flex gap-2">

                                    @can('edit posts')
                                        <a
                                            href="{{ route('posts.edit', $post) }}"
                                            class="rounded-lg bg-blue-600 px-4 py-2 text-white">
                                            Edit
                                        </a>
                                    @endcan

                                    @can('delete posts')
                                        <button
                                            wire:click="deletePost({{ $post->id }})"
                                            wire:confirm="Yakin ingin menghapus artikel ini?"
                                            class="rounded-lg bg-red-600 px-4 py-2 text-white">
                                            Delete
                                        </button>
                                    @endcan

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-10 text-center text-gray-500">
                                Tidak ada artikel ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>

    </div>

</div>
