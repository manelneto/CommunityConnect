@section('errors')
    @if ($errors->any())
        <section class="error-box">
            <h2>Errors</h2>
            <ul>
                @foreach ($errors->all() as $error)
                @if ($error == "The provided credentials do not match our records.")
                    <li>Username/Email or Password incorrect. Please try again.</li>
                @endif
                @if ($error == "The email has already been taken.")
                    <li>That email has already been taken. Please try again.</li>
                @endif
                @if ($error == "The username has already been taken.")
                    <li>That username has already been taken. Please try again.</li>
                @endif
                @if ($error == "The password confirmation does not match.")
                    <li>The passwords do not match. Please try again.</li>
                @endif
                @endforeach
            </ul>
        </section>
    @endif
@endsection
