<div class="header" id="travelHeader">
    <div class="container mb-2">
        <div class="d-flex justify-content-between align-items-center">
            <div class="logo-brand">
                <a href="{{ route('index') }}">
                    <img src="{{ asset('images/logo1.png') }}" width="20%" alt="logo-brand">
                </a>
            </div>
            <nav class="navbar navbar-expand-lg navbar-light">
                <!-- <div class="navbar-toggler border-0">
                    <div id="nav-icon1">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div> -->
                <div class="navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav justify-content-center" id="navHeader">
                        <!-- <li class="nav-item">
                            <a class="nav-link {{ url()->current() == route('index') ? 'active' : '' }}"
                               href="{{ route('index') }}">Trang chủ</a>
                        </li> -->
                        <li class="nav-item">
                        <a class="nav-link {{ url()->current() == route('client.search.index') ? 'active' : '' }}"
                            href="{{ route('client.search.index') }}">Du lịch</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ url()->current() == route('client.flight_tickets.index') ? 'active' : '' }}"
                               href="{{ route('client.flight_tickets.index') }}">Vé máy bay</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ url()->current() == route('client.hottel.index') ? 'active' : '' }}"
                               href="{{ route('client.hottel.index') }}">Khách sạn</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ url()->current() == route('client.car.index') ? 'active' : '' }}"
                               href="{{ route('client.car.index') }}">Thuê xe</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link {{ url()->current() == route('client.destination.index') ? 'active' : '' }}"
                        href="{{ route('client.destination.index') }}">Tin tức</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link {{ url()->current() == route('client.contact.index') ? 'active' : '' }}"
                        href="{{ route('client.contact.index') }}">Giới thiệu</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link {{ url()->current() == route('client.destination.index') ? 'active' : '' }}"
                               href="{{ route('client.destination.index') }}">Điểm điến</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ url()->current() == route('client.search.index') ? 'active' : '' }}"
                               href="{{ route('client.search.index') }}">Tours</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ url()->current() == route('client.contact.index') ? 'active' : '' }}"
                               href="{{ route('client.contact.index') }}">Liên hệ</a>
                        </li> -->
                        <!-- {{-- <li class="nav-item">
                            <a class="nav-link {{ url()->current() == route('client.contact.index') ? 'active' : '' }}"
                               href="{{ route('client.contact.index') }}">Lịch sử đặt tour</a>
                        </li> --}} -->
                        <div class="navigator-bar" id="navigatorBar"></div>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</div>
