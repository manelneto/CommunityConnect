@section('success')
    @if (session()->has('success'))
        <section id="success">
            <h2>Success</h2>
            <p>{{ (session()->get('success')) }}</p>
        </section>
    @endif
@endsection
