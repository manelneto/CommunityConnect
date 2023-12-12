@extends('layouts.app')
@include ('layouts.errors')

@section('main')
    <main id="admin-page">
        <section id="admin">
            <h1 id="admin-title">Administration</h1>
            <details>
                <summary>Find a user</summary>
                <form action="#" method="get" class="form-admin">
                    @csrf
                    <label for="user">Username</label>
                    <input type="text" id="user" name="user" placeholder="Enter username here and click Tab for autocomplete">
                    <button id="find-user" class="admin-button" type="submit">Visit</button>
                </form>
            </details>
            @yield('errors')
            <details>
                <summary>Create a user</summary>
                <form action="../../users" method="post" class="form-admin">
                    @csrf
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter username here" class="user-details-input">
                    <p class="username-error">Username is already taken</p>
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" placeholder="Enter email here" class="user-details-input">
                    <p class="email-error">Email is already taken</p>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter password here" class="user-details-input">
                    <p class="password-error">Password needs to be at least 8 characters long </p>
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm password here" class="user-details-input">
                    <p class="password-confirmation-error">Passwords do not match</p>
                    <button class="admin-button submit" type="submit">Create User</button>
                </form>
            </details>
            <details>
                <summary>Block a user</summary>
                <form action="../admin/block" method="post" class="form-admin">
                    @csrf
                    <label for="block-user">Username</label>
                    <input type="text" id="block-user" name="block-user" placeholder="Enter username here and click Tab for autocomplete">
                    <input type="hidden" name="user" value="">
                    <button class="admin-button" type="submit">Block</button>
                </form>
            </details>
            <details>
                <summary>Unblock a user</summary>
                <form action="../admin/unblock" method="post" class="form-admin">
                    @csrf
                    <label for="unblock-user">Username</label>
                    <input type="text" id="unblock-user" name="unblock-user" placeholder="Enter username here and click Tab for autocomplete">
                    <input type="hidden" name="user" value="">
                    <button class="admin-button" type="submit">Unblock</button>
                </form>
            </details> 
            <details>
                <summary>Add new tag</summary>
                <form action="../tags" method="post" class="form-admin">
                    @csrf
                    <label for="add-tag-admin">Tag</label>
                    <input type="text" id="add-tag-admin" name="tag" placeholder="Enter tag name here" class="user-details-input">
                    <p class="tag-error">Tag already exists</p>
                    <button class="admin-button" type="submit">Add</button>
                </form>
            </details>
            <details>
                <summary>Delete tag</summary>
                <form action="../tags/delete" method="post" class="form-admin">
                    @csrf
                    <label for="delete-tag">Tag</label>
                    <input type="text" id="delete-tag" name="tag" placeholder="Enter tag name here and click Tab for autocomplete">
                    <input type="hidden" name="tag" value="">
                    <button class="admin-button" type="submit">Delete</button>
                </form>
            </details> 
        </section>
    </main>
@endsection
