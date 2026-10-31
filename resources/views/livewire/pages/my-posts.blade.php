<div class="min-h-screen bg-gray-50 py-12">
    <div class="mx-auto max-w-5xl px-6">

        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-3xl font-bold">My Articles</h1>

            <a href="{{ route('posts.create') }}"
               class="rounded bg-blue-600 px-5 py-3 text-white">
                + Create Article
            </a>
        </div>

        <div class="space-y-4">
            @forelse ($posts as $post)
                <article class="rounded-xl bg-white p-6 shadow-sm">

                    <h2 class="text-xl font-bold">
                        {{ $post->title }}
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        Status: {{ ucfirst($post->status) }}
                    </p>

                    <div class="mt-5 flex gap-3">
                        <a href="{{ route('posts.edit', $post) }}"
                           class="rounded bg-amber-500 px-4 py-2 text-white">
                            Edit
                        </a>

                        <button
                            wire:click="delete({{ $post->id }})"
                            wire:confirm="Yakin ingin menghapus artikel ini?"
                            class="rounded bg-red-600 px-4 py-2 text-white">
                            Delete
                        </button>
                    </div>
                </article>
            @empty
                <p>Belum ada artikel.</p>
            @endforelse
        </div>

    </div>
</div>
