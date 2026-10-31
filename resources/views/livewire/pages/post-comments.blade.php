<section class="mt-10 rounded-2xl bg-white p-8 shadow-sm">

    <h2 class="mb-6 text-2xl font-bold text-gray-900">
        💬 Comments ({{ $comments->count() }})
    </h2>

    @auth
        <form wire:submit="save" class="mb-8">

            <textarea
                wire:model="content"
                rows="4"
                placeholder="Write your comment..."
                class="w-full rounded-xl border border-gray-300 p-4"
            ></textarea>

            @error('content')
                <p class="mt-2 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="mt-3 rounded-lg bg-blue-600 px-6 py-3 text-white hover:bg-blue-700 disabled:opacity-50"
            >
                Post Comment
            </button>

        </form>
    @else
        <p class="mb-8 text-gray-600">
            Please
            <a href="{{ route('login') }}"
               class="font-semibold text-blue-600">
                login
            </a>
            to leave a comment.
        </p>
    @endauth

    <div class="space-y-5">

        @forelse ($comments as $comment)

            <div wire:key="comment-{{ $comment->id }}"
                 class="rounded-xl border border-gray-200 p-5">

                <div class="flex items-start justify-between gap-4">

                    <div>
                        <h3 class="font-semibold text-gray-900">
                            {{ $comment->user?->name ?? 'Unknown User' }}
                        </h3>

                        <p class="text-xs text-gray-400">
                            {{ $comment->created_at->diffForHumans() }}
                        </p>
                    </div>

                    @auth
                        @if (
                            auth()->id() === $comment->user_id
                            || auth()->user()->hasRole('admin')
                        )
                            <button
                                wire:click="deleteComment({{ $comment->id }})"
                                wire:confirm="Delete this comment?"
                                class="text-sm text-red-600 hover:underline"
                            >
                                Delete
                            </button>
                        @endif
                    @endauth

                </div>

                <p class="mt-4 whitespace-pre-line text-gray-700">
                    {{ $comment->content }}
                </p>

            </div>

        @empty

            <p class="text-gray-500">
                No comments yet. Be the first!
            </p>

        @endforelse

    </div>

</section>
