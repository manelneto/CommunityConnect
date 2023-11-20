@extends('layouts.app-cc')
@include('layouts.header')
@include('layouts.footer')
@include('layouts.main-navigation-list')

@yield('header')
@yield('main-navigation-list')

<section id="admin">
    <details>
        <summary>Find a user</summary>
        <form action="../../users/" method="get">
            @csrf
            <label for="username">Username</label>
            <select id="username" name="username">
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
    <details>
        <summary>Create a user</summary>
        <form action="../../users" method="post">
            @csrf
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
    </details>
</section>

@yield('footer')
