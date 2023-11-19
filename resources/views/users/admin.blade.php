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
</section>

@yield('footer')
