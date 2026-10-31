<div class="min-h-screen bg-gray-50 py-12">
    <div class="mx-auto max-w-3xl rounded-xl bg-white p-8 shadow">

        <a href="{{ route('home') }}" class="text-blue-600">
            ← Back to Home
        </a>

        <h1 class="mb-8 mt-6 text-3xl font-bold">
            Create New Article
        </h1>

        <form wire:submit="save" class="space-y-6">

            <div>
                <label class="mb-2 block font-semibold">Title</label>

                <input type="text" wire:model="title"
                    class="w-full rounded-lg border p-3">

                @error('title')
                    <p class="mt-1 text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block font-semibold">Content</label>

                <textarea wire:model="content" rows="8"
                    class="w-full rounded-lg border p-3"></textarea>

                @error('content')
                    <p class="mt-1 text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block font-semibold">Status</label>

                <select wire:model="status"
                    class="w-full rounded-lg border p-3">
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
            </div>

            <button type="submit"
                class="rounded-lg bg-blue-600 px-6 py-3 text-white hover:bg-blue-700">
                Save Article
            </button>

            <div>
                <label class="mb-2 block font-semibold">
                    Featured Image
                </label>

                <input
                    type="file"
                    wire:model="image"
                    accept="image/*"
                    class="w-full rounded-lg border p-3"
                >

                @error('image')
                    <p class="mt-1 text-sm text-red-500">
                        {{ $message }}
                    </p>
                @enderror

                @if ($image)
                    <img
                        src="{{ $image->temporaryUrl() }}"
                        alt="Preview gambar"
                        class="mt-4 h-48 w-full rounded-lg object-cover"
                    >
                @endif
            </div>
        </form>
    </div>
</div>
