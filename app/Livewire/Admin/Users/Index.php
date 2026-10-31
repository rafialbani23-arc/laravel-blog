<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

#[Layout('layouts.app')]
class Index extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $role = 'user';

    public function createUser()
    {
        abort_unless(auth()->user()->can('create users'), 403);

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', Rule::in(['admin', 'user'])],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->assignRole($validated['role']);

        $this->reset(['name', 'email', 'password']);
        $this->role = 'user';

        session()->flash('success', 'User berhasil ditambahkan.');
    }

    public function deleteUser($id)
    {
        abort_unless(auth()->user()->can('delete users'), 403);

        if (auth()->id() == $id) {
            session()->flash('error', 'Tidak bisa menghapus akun sendiri.');
            return;
        }

        $user = User::findOrFail($id);

        $user->delete();

        session()->flash('success', 'User berhasil dihapus.');
    }
    
    public ?int $editingUserId = null;
    public string $editName = '';
    public string $editEmail = '';
    public string $editRole = 'user';

    public function editUser(int $id): void
    {
        abort_unless(auth()->user()->can('edit users'), 403);

        $user = User::findOrFail($id);

        $this->editingUserId = $user->id;
        $this->editName = $user->name;
        $this->editEmail = $user->email;
        $this->editRole = $user->hasRole('admin') ? 'admin' : 'user';
    }

    public function updateUser(): void
    {
        abort_unless(auth()->user()->can('edit users'), 403);

        $user = User::findOrFail($this->editingUserId);

        $validated = $this->validate([
            'editName' => ['required', 'string', 'max:255'],
            'editEmail' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'editRole' => ['required', Rule::in(['admin', 'user'])],
        ]);

        // Cegah admin menghapus role admin miliknya sendiri
        if ($user->id === auth()->id() && $validated['editRole'] !== 'admin') {
            $this->addError('editRole', 'Tidak bisa menghapus role admin sendiri.');
            return;
        }

        $user->update([
            'name' => $validated['editName'],
            'email' => $validated['editEmail'],
        ]);

        $user->syncRoles([$validated['editRole']]);

        $this->cancelEdit();

        session()->flash('success', 'User berhasil diperbarui.');
    }

    public function cancelEdit(): void
    {
        $this->reset([
            'editingUserId',
            'editName',
            'editEmail',
        ]);

        $this->editRole = 'user';
    }

    public function render()
    {
        abort_unless(auth()->user()->can('view users'), 403);

        return view('livewire.admin.users.index', [
            'users' => User::with('roles')->latest()->get(),
        ]);
    }
}
