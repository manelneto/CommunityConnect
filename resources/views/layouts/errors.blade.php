@section('errors')
    @if ($errors->any())
        <section class="error-box"><!-- TODO -->
            <h2>Errors</h2>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </section>
    @endif
@endsection
