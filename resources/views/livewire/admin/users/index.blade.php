<div class="min-h-screen bg-gray-100 p-8">

    <div class="mx-auto max-w-6xl">

        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-3xl font-bold">Users Management</h1>

            <a href="{{ route('admin.dashboard') }}" class="rounded-lg bg-blue-600 px-5 py-3 text-white">
                ← Dashboard
            </a>
        </div>

        @if (session()->has('success'))
            <div class="mb-5 rounded-lg bg-green-100 p-4 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-5 rounded-lg bg-red-100 p-4 text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @if ($editingUserId !== null)
            <div class="mb-8 rounded-xl bg-white p-6 shadow-sm">

                <h2 class="mb-6 text-xl font-bold">
                    Edit User
                </h2>

                <form wire:submit="updateUser" class="space-y-5">

                    <div>
                        <label class="mb-2 block font-medium">Name</label>

                        <input type="text" wire:model="editName" class="w-full rounded-lg border p-3">

                        @error('editName')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block font-medium">Email</label>

                        <input type="email" wire:model="editEmail" class="w-full rounded-lg border p-3">

                        @error('editEmail')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block font-medium">Role</label>

                        <select wire:model="editRole" class="w-full rounded-lg border p-3">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>

                        @error('editRole')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="rounded-lg bg-blue-600 px-5 py-3 text-white">
                            Update User
                        </button>

                        <button type="button" wire:click="cancelEdit"
                            class="rounded-lg bg-gray-500 px-5 py-3 text-white">
                            Cancel
                        </button>
                    </div>

                </form>

            </div>
        @endif

        @can('create users')
            <div class="mb-8 rounded-xl bg-white p-6 shadow-sm">

                <h2 class="mb-6 text-xl font-bold text-gray-900">
                    + Add New User
                </h2>

                <form wire:submit="createUser" class="grid gap-5 md:grid-cols-2">

                    <div>
                        <label class="mb-2 block font-medium">Name</label>
                        <input type="text" wire:model="name" class="w-full rounded-lg border p-3">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block font-medium">Email</label>
                        <input type="email" wire:model="email" class="w-full rounded-lg border p-3">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block font-medium">Password</label>
                        <input type="password" wire:model="password" class="w-full rounded-lg border p-3">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block font-medium">Role</label>
                        <select wire:model="role" class="w-full rounded-lg border p-3">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <button type="submit" wire:loading.attr="disabled"
                            class="rounded-lg bg-blue-600 px-6 py-3 font-semibold text-white hover:bg-blue-700 disabled:opacity-50">
                            Save User
                        </button>
                    </div>

                </form>

            </div>
        @endcan

        <div class="overflow-x-auto rounded-xl bg-white shadow-sm">

            <table class="w-full text-left">

                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-4">ID</th>
                        <th class="p-4">Name</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Role</th>
                        <th class="p-4">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($users as $user)
                        <tr wire:key="user-{{ $user->id }}" class="border-t">

                            <td class="p-4">{{ $user->id }}</td>

                            <td class="p-4">{{ $user->name }}</td>

                            <td class="p-4">{{ $user->email }}</td>

                            <td class="p-4">
                                {{ $user->getRoleNames()->implode(', ') ?: 'No Role' }}
                            </td>

                            <td class="p-4">
                                @can('edit users')
                                    <button wire:click="editUser({{ $user->id }})"
                                        class="mr-2 rounded-lg bg-amber-500 px-4 py-2 text-white hover:bg-amber-600">
                                        Edit
                                    </button>
                                @endcan

                                @can('delete users')
                                    @if (auth()->id() !== $user->id)
                                        <button wire:click="deleteUser({{ $user->id }})"
                                            wire:confirm="Yakin ingin menghapus pengguna ini?"
                                            class="rounded-lg bg-red-600 px-4 py-2 text-white hover:bg-red-700">
                                            Delete
                                        </button>
                                    @else
                                        <span class="text-gray-400">Current User</span>
                                    @endif
                                @endcan
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500">
                                Belum ada pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>

    </div>

</div>
