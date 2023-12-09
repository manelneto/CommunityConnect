@extends('layouts.app')
@include ('layouts.errors')

@section('main')
    <main>
        <section id="admin">
            <details>
                <summary>Find a user</summary>
                <form action="../../users/" method="get" class="form-admin">
                    @csrf
                    <label for="user">Username</label>
                    <input type="text" id="user" name="user" placeholder="Enter username here and click Tab for autocomplete">
                    <button class="admin-button" type="submit">Visit</button>
                </form>
            </details>
            @yield('errors')
            <details>
                <summary>Create a user</summary>
                <form action="../../users" method="post" class="form-admin">
                    @csrf
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter username here" class="user-details-input">
                    <span class="username-error">Username is already taken</span>
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" placeholder="Enter email here" class="user-details-input">
                    <span class="email-error">Email is already taken</span>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter password here" class="user-details-input">
                    <span class="password-error">Password needs to be at least 8 characters long </span>
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm password here" class="user-details-input">
                    <span class="password-confirmation-error">Passwords do not match</span>
                    <button id="admin-button" type="submit" class="submit">Create User</button>
                </form>
            </details>
            <details>
                <summary>Block a user</summary>
                <form action="../admin/block" method="post" class="form-admin">
                    @csrf
                    <label for="user">Username</label>
                    <input type="text" id="block-user" name="user" placeholder="Enter username here and click Tab for autocomplete">
                    <button class="admin-button" type="submit">Block</button>
                </form>
            </details>
            <details>
                <summary>Unblock a user</summary>
                <form action="../admin/unblock" method="post" class="form-admin">
                    @csrf
                    <label for="user">Username</label>
                    <input type="text" id="unblock-user" name="user" placeholder="Enter username here and click Tab for autocomplete">
                    <button class="admin-button" type="submit">Unblock</button>
                </form>
            </details> 
            <details>
                <summary>Add new tag</summary>
                <form action="../tags" method="post" class="form-admin">
                    @csrf
                    <label for="tag">Tag</label>
<<<<<<< resources/views/pages/admin.blade.php
                    <input type="text" id="tag" name="tag" placeholder="Enter tag name here" class="user-details-input">
                    <span class="tag-error">Tag already exists</span>
                    <button id="find-user" type="submit" class="submit">Add</button>
=======
                    <input type="text" id="add-tag" name="tag" placeholder="Enter tag name here">
                    <button class="admin-button" type="submit">Add</button>
>>>>>>> resources/views/pages/admin.blade.php
                </form>
            </details>
            <details>
                <summary>Delete tag</summary>
                <form action="../tags/delete" method="post" class="form-admin">
                    @csrf
                    <label for="tag">Tag</label>
                    <input type="text" id="delete-tag" name="tag" placeholder="Enter tag name here and click Tab for autocomplete">
                    <button class="admin-button" type="submit">Delete</button>
                </form>
            </details> 
        </section>
    </main>
@endsection
