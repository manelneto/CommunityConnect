@section('errors')
    @if ($errors->any())
        <section class="error-box">
            <h2>Errors</h2>
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="error">{{ $error }}</li>
                @endforeach
            </ul>
        </section>
    @endif
@endsection
