<div class="card">
        <ul class="nav nav-pills nav-fill">
            <li class="nav-item">
                <a href="{{route('slider.index')}}" class="nav-link @if(\Request::segment(2)=='slider') active @endif">Sliders</a>
            </li>
            <li class="nav-item">
                <a href="{{route('faq.index')}}" class="nav-link @if(\Request::segment(2)=='faq') active @endif">FAQ</a>
            </li>
            <li class="nav-item">
                <a href="{{route('suburbs')}}" class="nav-link @if(\Request::segment(2)=='suburbs') active @endif">Suburbs</a>
            </li>
            <li class="nav-item">
                <a href="{{route('coupons.index')}}" class="nav-link @if(\Request::segment(2)=='coupons') active @endif">Coupons</a>
            </li>
            <li class="nav-item">
                <a href="{{route('units.index')}}" class="nav-link @if(\Request::segment(2)=='units') active @endif">Units</a>
            </li>
            <li class="nav-item">
                <a href="{{route('setting')}}" class="nav-link @if(\Request::segment(2)=='setting') active @endif">Settings</a>
            </li>
        </ul>
    </div>
