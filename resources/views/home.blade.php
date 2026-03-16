<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    @livewireStyles
</head>
<body>
    <h1>Home</h1>
    @if (session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif
    @auth
        <!-- If the user is logged in show welcome message, logout and list of their posts -->
        <p>Welcome, {{ auth()->user()->name }}!</p>
        <form action="/logout" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
        <livewire:create-post />
        <livewire:list-posts />

    @else
        <!-- If the user is not logged in show registration and login forms and top posts -->
        <livewire:register-user />
        <livewire:login />
        <livewire:post-dashboard />
    @endauth
    @livewireScripts
</body>
</html>