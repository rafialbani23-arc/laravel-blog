<div class="min-h-screen bg-gray-50 py-12">
    <div class="mx-auto max-w-3xl rounded-xl bg-white p-8 shadow">

        <h1 class="mb-8 text-3xl font-bold">Edit Article</h1>

        <form wire:submit="update" class="space-y-6">

            <div>
                <label class="mb-2 block">Title</label>
                <input wire:model="title"
                       class="w-full rounded border p-3">
                @error('title')
                    <p class="text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block">Content</label>
                <textarea wire:model="content" rows="8"
                          class="w-full rounded border p-3"></textarea>
                @error('content')
                    <p class="text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block">Status</label>
                <select wire:model="status"
                        class="w-full rounded border p-3">
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
            </div>
            <div class="space-y-4">

                <label class="block font-semibold text-gray-800">
                    Featured Image
                </label>

                @if ($image)
                    <img
                        src="{{ $image->temporaryUrl() }}"
                        class="h-48 w-full rounded-lg object-cover"
                        alt="Preview gambar baru"
                    >
                @elseif ($post->image)
                    <img
                        src="{{ asset('storage/' . $post->image) }}"
                        class="h-48 w-full rounded-lg object-cover"
                        alt="Gambar artikel saat ini"
                    >
                @endif

                <input
                    type="file"
                    wire:model="image"
                    accept="image/*"
                    class="w-full rounded-lg border p-3"
                >

                @error('image')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror

                <div wire:loading wire:target="image"
                    class="text-sm text-blue-600">
                    Uploading...
                </div>

            </div>

            <button type="submit"
                    class="rounded bg-blue-600 px-6 py-3 text-white">
                Update Article
            </button>

        </form>
    </div>
</div>
