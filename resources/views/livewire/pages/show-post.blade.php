<div class="min-h-screen bg-gray-50 py-12">

    <article class="mx-auto max-w-4xl px-6">

        <a href="{{ route('home') }}"
           class="mb-8 inline-block text-blue-600 hover:underline">
            ← Back to Home
        </a>

        <div class="overflow-hidden rounded-2xl bg-white shadow-sm">

            @if ($post->image)
                <img
                    src="{{ asset('storage/' . $post->image) }}"
                    alt="{{ $post->title }}"
                    class="h-80 w-full object-cover"
                >
            @endif

            <div class="p-8 md:p-12">

                <span class="rounded-full bg-green-100 px-3 py-1 text-sm text-green-700">
                    Published
                </span>

                <h1 class="mt-5 text-4xl font-bold text-gray-900">
                    {{ $post->title }}
                </h1>

                <p class="mt-4 text-sm text-gray-500">
                    {{ $post->user?->name ?? 'Unknown Author' }}
                    • {{ $post->created_at->format('d M Y') }}
                </p>

                <hr class="my-8">

                <div class="whitespace-pre-line leading-8 text-gray-700">
                    {{ $post->content }}
                </div>

            </div>

        </div>
        
        <livewire:pages.post-comments
            :post="$post"
            :key="'comments-'.$post->id"
        />

    </article>

</div>
