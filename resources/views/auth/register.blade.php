<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - LaravelBlog</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen items-center justify-center bg-gray-100 p-6">

    <form method="POST" action="{{ route('register.submit') }}"
          class="w-full max-w-md space-y-5 rounded-xl bg-white p-8 shadow">
        @csrf

        <h1 class="text-3xl font-bold">Register</h1>

        <input name="name" placeholder="Nama" required
               value="{{ old('name') }}"
               class="w-full rounded border p-3">

        <input type="email" name="email" placeholder="Email"
               value="{{ old('email') }}" required
               class="w-full rounded border p-3">

        <input type="password" name="password" placeholder="Password"
               required class="w-full rounded border p-3">

        <input type="password" name="password_confirmation"
               placeholder="Konfirmasi Password" required
               class="w-full rounded border p-3">

        @if ($errors->any())
            <p class="text-red-600">{{ $errors->first() }}</p>
        @endif

        <button class="w-full rounded bg-blue-600 p-3 text-white">
            Register
        </button>

        <a href="{{ route('login') }}" class="block text-blue-600">
            Sudah punya akun? Login
        </a>
    </form>

</body>
</html>
