@extends('layouts.app-cc')
@include('layouts.header')
@include('layouts.footer')
@include('layouts.main-navigation-list')

@yield('header')

<section>
    <h1>Admin</h1>
    <details>
        <summary>Find a user</summary>
        <form action="../../users/" method="get">
            @csrf
            <label for="user">Username</label>
            <select id="user" name="user">
                <option value="0">None</option>
                <?php foreach ($users as $user) { ?>
                <option value="{{ $user->id }}">{{ $user->username }}</option>
                <?php } ?>
            </select>
            <button id="find-user" type="submit">Visit</button>
        </form>
    </details>
    @if ($errors->any())
        <div class="error-box">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="../../users" method="post">
        @csrf
        <h2>Create a user</h2>
        <label for="username">Username</label>
        <input type="text" id="username" name="username">
        <label for="email">Email</label>
        <input type="text" id="email" name="email">
        <label for="password">Password</label>
        <input type="password" id="password" name="password">
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation">
        <button id="create-user" type="submit">Create User</button>
    </form>
</section>

@yield('footer')
