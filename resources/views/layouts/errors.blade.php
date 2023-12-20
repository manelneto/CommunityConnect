@section('errors')
    @if ($errors->any())
        <section id="errors">
            <h2>Errors</h2>
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="error">{{ $error }}</li>
                @endforeach
            </ul>
        </section>
    @endif
@endsection
