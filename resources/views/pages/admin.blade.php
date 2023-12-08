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
                    <select id="user" name="user">
                        <option value="0">None</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->username }}</option>
                        @endforeach
                    </select>
                    <button id="find-user" type="submit">Visit</button>
                </form>
            </details>
            @yield('errors')
            <details>
                <summary>Create a user</summary>
                <form action="../../users" method="post" class="form-admin">
                    @csrf
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter username here">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" placeholder="Enter email here">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter password here">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm password here">
                    <button id="create-user" type="submit">Create User</button>
                </form>
            </details>
            <details>
                <summary>Block a user</summary>
                <form action="../admin/block" method="post" class="form-admin">
                    @csrf
                    <label for="user">Username</label>
                    <select id="user" name="user">
                        <option value="0">None</option>
                        @foreach ($users as $user)
                            @if ($user->blocked === false)
                                <option value="{{ $user->id }}">{{ $user->username }}</option>
                            @endif
                        @endforeach
                    </select>
                    <button id="find-user" type="submit">Block</button>
                </form>
            </details>
            <details>
                <summary>Unblock a user</summary>
                <form action="../admin/unblock" method="post" class="form-admin">
                    @csrf
                    <label for="user">Username</label>
                    <select id="user" name="user">
                        <option value="0">None</option>
                        @foreach ($users as $user)
                            @if ($user->blocked === true)
                                <option value="{{ $user->id }}">{{ $user->username }}</option>
                            @endif
                        @endforeach
                    </select>
                    <button id="find-user" type="submit">Unblock</button>
                </form>
            </details> 
            <details>
                <summary>Add new tag</summary>
                <form action="../tags" method="post" class="form-admin">
                    @csrf
                    <label for="tag">Tag</label>
                    <input type="text" id="tag" name="tag" placeholder="Enter tag name here">
                    <button id="find-user" type="submit">Add</button>
                </form>
            </details>
            <details>
                <summary>Delete tag</summary>
                <form action="../tags/delete" method="post" class="form-admin">
                    @csrf
                    <label for="tag">Tag</label>
                    <select id="tag" name="tag">
                        <option value="0">None</option>
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                    <button id="find-user" type="submit">Delete</button>
                </form>
            </details> 
        </section>
    </main>
@endsection
