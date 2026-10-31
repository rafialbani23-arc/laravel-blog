<div class="grid gap-6 md:grid-cols-3">

    @foreach ($posts as $post)

        <div class="rounded-xl bg-white p-6 shadow-sm">

            @if ($post->image)
                <img
                    src="{{ asset('storage/' . $post->image) }}"
                    alt="{{ $post->title }}"
                    class="mb-4 h-48 w-full rounded-lg object-cover"
                >
            @endif

            <h3 class="text-xl font-bold">
                {{ $post->title }}
            </h3>

            <p class="mt-3 text-gray-600">
                {{ Str::limit($post->content, 100) }}
            </p>

            <p class="mt-4 text-sm text-gray-400">
                {{ $post->created_at->format('d M Y') }}
            </p>

            <a href="{{ route('posts.show', $post->slug) }}"
               class="mt-5 inline-block rounded-lg bg-blue-600 px-5 py-2 text-white hover:bg-blue-700">
                Read More →
            </a>

        </div>

    @endforeach

</div>
