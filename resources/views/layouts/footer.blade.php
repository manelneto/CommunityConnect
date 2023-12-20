@section('footer')
    <img class="footer-img" src="{{ asset('assets/logo.png') }}" alt="Community Connect logo" />
    <ul class="footer-links">
        <li class="footer-link">
            <a href="{{ route('about-contact-us') }}">About & Contact Us</a>
        </li>
        <li class="footer-link">
            <a href="{{ route('main-features') }}">Main Features</a>
        </li>
        <li class="footer-link">
            <a href="{{ route('faq') }}">FAQ</a>
        </li>
    </ul>
@endsection
