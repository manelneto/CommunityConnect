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
                <section class="add-tooltip-admin">
                    <label for="user">Username</label>
                    <div class="tooltip-icon">
                        <svg fill="#000000" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px" viewBox="0 0 416.979 416.979" xml:space="preserve">
                            <path d="M356.004,61.156c-81.37-81.47-213.377-81.551-294.848-0.182c-81.47,81.371-81.552,213.379-0.181,294.85 c81.369,81.47,213.378,81.551,294.849,0.181C437.293,274.636,437.375,142.626,356.004,61.156z M237.6,340.786 c0,3.217-2.607,5.822-5.822,5.822h-46.576c-3.215,0-5.822-2.605-5.822-5.822V167.885c0-3.217,2.607-5.822,5.822-5.822h46.576 c3.215,0,5.822,2.604,5.822,5.822V340.786z M208.49,137.901c-18.618,0-33.766-15.146-33.766-33.765 c0-18.617,15.147-33.766,33.766-33.766c18.619,0,33.766,15.148,33.766,33.766C242.256,122.755,227.107,137.901,208.49,137.901z" />
                        </svg>
                        <p class="tooltip-text">You can find a user by entering their username in the respective field. When you're done, click on the <b>Visit</b> button. You will be redirected to their profile page.</p>
                    </div>
                </section>
                <input type="text" id="user" name="user" placeholder="Enter username here and click Tab for autocomplete">
                <button id="find-user" class="admin-button" type="submit">Visit</button>
            </form>
        </details>
        @yield('errors')
        <details>
            <summary>Create a user</summary>
            <form action="../../users" method="post" class="form-admin">
                @csrf
                <section class="add-tooltip-admin">
                    <label for="block-user">Username</label>
                    <div class="tooltip-icon">
                        <svg fill="#000000" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px" viewBox="0 0 416.979 416.979" xml:space="preserve">
                            <path d="M356.004,61.156c-81.37-81.47-213.377-81.551-294.848-0.182c-81.47,81.371-81.552,213.379-0.181,294.85 c81.369,81.47,213.378,81.551,294.849,0.181C437.293,274.636,437.375,142.626,356.004,61.156z M237.6,340.786 c0,3.217-2.607,5.822-5.822,5.822h-46.576c-3.215,0-5.822-2.605-5.822-5.822V167.885c0-3.217,2.607-5.822,5.822-5.822h46.576 c3.215,0,5.822,2.604,5.822,5.822V340.786z M208.49,137.901c-18.618,0-33.766-15.146-33.766-33.765 c0-18.617,15.147-33.766,33.766-33.766c18.619,0,33.766,15.148,33.766,33.766C242.256,122.755,227.107,137.901,208.49,137.901z" />
                        </svg>
                        <p class="tooltip-text">You can create a user by entering their user details in the respective fields. When you're done, click on the <b>Create User</b> button.</p>
                    </div>
                </section>
                <input type="text" id="username" name="username" placeholder="Enter username here" class="user-details-input">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Enter email here" class="user-details-input">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter password here" class="user-details-input">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm password here" class="user-details-input">
                <button class="admin-button submit" type="submit">Create User</button>
            </form>
        </details>
        <details>
            <summary>Block a user</summary>
            <form action="../admin/block" method="post" class="form-admin">
                @csrf
                <section class="add-tooltip-admin">
                    <label for="block-user">Username</label>
                    <div class="tooltip-icon">
                        <svg fill="#000000" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px" viewBox="0 0 416.979 416.979" xml:space="preserve">
                            <path d="M356.004,61.156c-81.37-81.47-213.377-81.551-294.848-0.182c-81.47,81.371-81.552,213.379-0.181,294.85 c81.369,81.47,213.378,81.551,294.849,0.181C437.293,274.636,437.375,142.626,356.004,61.156z M237.6,340.786 c0,3.217-2.607,5.822-5.822,5.822h-46.576c-3.215,0-5.822-2.605-5.822-5.822V167.885c0-3.217,2.607-5.822,5.822-5.822h46.576 c3.215,0,5.822,2.604,5.822,5.822V340.786z M208.49,137.901c-18.618,0-33.766-15.146-33.766-33.765 c0-18.617,15.147-33.766,33.766-33.766c18.619,0,33.766,15.148,33.766,33.766C242.256,122.755,227.107,137.901,208.49,137.901z" />
                        </svg>
                        <p class="tooltip-text">You can block a user by entering their username in the respective field. By blocking a user, you remove their capabilities to interact with the website in any way apart from viewing content. When you're done, click on the <b>Block</b> button.</p>
                    </div>
                </section>
                <input type="text" id="block-user" name="block-user" placeholder="Enter username here and click Tab for autocomplete">
                <input type="hidden" name="user" value="0">
                <button class="admin-button" type="submit">Block</button>
            </form>
        </details>
        <details>
            <summary>Unblock a user</summary>
            <form action="../admin/unblock" method="post" class="form-admin">
                @csrf
                <section class="add-tooltip-admin">
                    <label for="unblock-user">Username</label>
                    <div class="tooltip-icon">
                        <svg fill="#000000" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px" viewBox="0 0 416.979 416.979" xml:space="preserve">
                            <path d="M356.004,61.156c-81.37-81.47-213.377-81.551-294.848-0.182c-81.47,81.371-81.552,213.379-0.181,294.85 c81.369,81.47,213.378,81.551,294.849,0.181C437.293,274.636,437.375,142.626,356.004,61.156z M237.6,340.786 c0,3.217-2.607,5.822-5.822,5.822h-46.576c-3.215,0-5.822-2.605-5.822-5.822V167.885c0-3.217,2.607-5.822,5.822-5.822h46.576 c3.215,0,5.822,2.604,5.822,5.822V340.786z M208.49,137.901c-18.618,0-33.766-15.146-33.766-33.765 c0-18.617,15.147-33.766,33.766-33.766c18.619,0,33.766,15.148,33.766,33.766C242.256,122.755,227.107,137.901,208.49,137.901z" />
                        </svg>
                        <p class="tooltip-text">You can unblock a user by entering their username in the respective field. When you're done, click on the <b>Unblock</b> button.</p>
                    </div>
                </section>
                <input type="text" id="unblock-user" name="unblock-user" placeholder="Enter username here and click Tab for autocomplete">
                <input type="hidden" name="user" value="0">
                <button class="admin-button" type="submit">Unblock</button>
            </form>
        </details>
        <details>
            <summary>Add a new tag</summary>
            <form action="../tags" method="post" class="form-admin">
                @csrf
                <section class="add-tooltip-admin">
                    <label for="add-tag-admin">Tag</label>
                    <div class="tooltip-icon">
                        <svg fill="#000000" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px" viewBox="0 0 416.979 416.979" xml:space="preserve">
                            <path d="M356.004,61.156c-81.37-81.47-213.377-81.551-294.848-0.182c-81.47,81.371-81.552,213.379-0.181,294.85 c81.369,81.47,213.378,81.551,294.849,0.181C437.293,274.636,437.375,142.626,356.004,61.156z M237.6,340.786 c0,3.217-2.607,5.822-5.822,5.822h-46.576c-3.215,0-5.822-2.605-5.822-5.822V167.885c0-3.217,2.607-5.822,5.822-5.822h46.576 c3.215,0,5.822,2.604,5.822,5.822V340.786z M208.49,137.901c-18.618,0-33.766-15.146-33.766-33.765 c0-18.617,15.147-33.766,33.766-33.766c18.619,0,33.766,15.148,33.766,33.766C242.256,122.755,227.107,137.901,208.49,137.901z" />
                        </svg>
                        <p class="tooltip-text">You can create a tag by entering its name in the respective field. Each tag must be unique. When you're done, click on the <b>Add</b> button.</p>
                    </div>
                </section>
                <input type="text" id="add-tag-admin" name="name" placeholder="Enter tag name here" class="user-details-input">
                <button class="admin-button" type="submit">Add</button>
            </form>
        </details>
        <details>
            <summary>Edit a tag</summary>
            <form id="edit-tag" action="../tags/edit" method="post" class="form-admin">
                @csrf
                <section class="add-tooltip-admin">
                    <label for="old-tag-admin">Old Tag</label>
                    <div class="tooltip-icon">
                        <svg fill="#000000" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px" viewBox="0 0 416.979 416.979" xml:space="preserve">
                            <path d="M356.004,61.156c-81.37-81.47-213.377-81.551-294.848-0.182c-81.47,81.371-81.552,213.379-0.181,294.85 c81.369,81.47,213.378,81.551,294.849,0.181C437.293,274.636,437.375,142.626,356.004,61.156z M237.6,340.786 c0,3.217-2.607,5.822-5.822,5.822h-46.576c-3.215,0-5.822-2.605-5.822-5.822V167.885c0-3.217,2.607-5.822,5.822-5.822h46.576 c3.215,0,5.822,2.604,5.822,5.822V340.786z M208.49,137.901c-18.618,0-33.766-15.146-33.766-33.765 c0-18.617,15.147-33.766,33.766-33.766c18.619,0,33.766,15.148,33.766,33.766C242.256,122.755,227.107,137.901,208.49,137.901z" />
                        </svg>
                        <p class="tooltip-text">You can edit a tag by entering its name in the respective field and the new name in the following field. Each tag must be unique. When you're done, click on the <b>Edit</b> button.</p>
                    </div>
                </section>
                <input type="text" id="old-tag-admin" name="old_tag" placeholder="Enter old tag name here" class="user-details-input">
                <input type="hidden" name="id" value="">
                <label for="new-tag-admin">New Tag</label>
                <input type="text" id="new-tag-admin" name="name" placeholder="Enter new tag name here" class="user-details-input">
                <button class="admin-button" type="submit">Edit</button>
            </form>
        </details>
        <details>
            <summary>Delete tag</summary>
            <form action="../tags/delete" method="post" class="form-admin">
                @csrf
                <section class="add-tooltip-admin">
                    <label for="delete-tag">Tag</label>
                    <div class="tooltip-icon">
                        <svg fill="#000000" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px" viewBox="0 0 416.979 416.979" xml:space="preserve">
                            <path d="M356.004,61.156c-81.37-81.47-213.377-81.551-294.848-0.182c-81.47,81.371-81.552,213.379-0.181,294.85 c81.369,81.47,213.378,81.551,294.849,0.181C437.293,274.636,437.375,142.626,356.004,61.156z M237.6,340.786 c0,3.217-2.607,5.822-5.822,5.822h-46.576c-3.215,0-5.822-2.605-5.822-5.822V167.885c0-3.217,2.607-5.822,5.822-5.822h46.576 c3.215,0,5.822,2.604,5.822,5.822V340.786z M208.49,137.901c-18.618,0-33.766-15.146-33.766-33.765 c0-18.617,15.147-33.766,33.766-33.766c18.619,0,33.766,15.148,33.766,33.766C242.256,122.755,227.107,137.901,208.49,137.901z" />
                        </svg>
                        <p class="tooltip-text">You can delete a tag by entering its name in the respective field. When you're done, click on the <b>Delete</b> button.</p>
                    </div>
                </section>
                <input type="text" id="delete-tag" name="tag" placeholder="Enter tag name here and click Tab for autocomplete" class="user-details-input">
                <input type="hidden" name="id" value="">
                <button class="admin-button" type="submit">Delete</button>
            </form>
        </details>
        <details id="last-tag">
            <summary>Add a new community</summary>
            <form action="../communities" method="post" class="form-admin">
                @csrf
                <section class="add-tooltip-admin">
                    <label for="add-community-admin">Community</label>
                    <div class="tooltip-icon">
                        <svg fill="#000000" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px" viewBox="0 0 416.979 416.979" xml:space="preserve">
                            <path d="M356.004,61.156c-81.37-81.47-213.377-81.551-294.848-0.182c-81.47,81.371-81.552,213.379-0.181,294.85 c81.369,81.47,213.378,81.551,294.849,0.181C437.293,274.636,437.375,142.626,356.004,61.156z M237.6,340.786 c0,3.217-2.607,5.822-5.822,5.822h-46.576c-3.215,0-5.822-2.605-5.822-5.822V167.885c0-3.217,2.607-5.822,5.822-5.822h46.576 c3.215,0,5.822,2.604,5.822,5.822V340.786z M208.49,137.901c-18.618,0-33.766-15.146-33.766-33.765 c0-18.617,15.147-33.766,33.766-33.766c18.619,0,33.766,15.148,33.766,33.766C242.256,122.755,227.107,137.901,208.49,137.901z" />
                        </svg>
                        <p class="tooltip-text">You can create a community by entering its name in the respective field. Each community must be unique. When you're done, click on the <b>Add</b> button.</p>
                    </div>
                </section>
                <input type="text" id="add-community-admin" name="name" placeholder="Enter community name here" class="user-details-input">
                <button class="admin-button" type="submit">Add</button>
            </form>
        </details>
    </section>
</main>
@endsection
