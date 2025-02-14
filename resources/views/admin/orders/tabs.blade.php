<div class="conatiner px-2">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link {{ $active == 'pending' ? 'active' : '' }}" aria-current="page" href="{{ route('admin.orders.index') }}">Pending</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $active == 'confirmed' ? 'active' : '' }}" href="{{ route('admin.orders.confirmed') }}">Confirmed</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $active == 'pickup' ? 'active' : '' }}" href="{{ route('admin.orders.ready-to-move') }}">Ready to Pickup</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $active == 'deliveried' ? 'active' : '' }}" href="{{ route('admin.orders.deliveried') }}">Deliveried</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $active == 'returned' ? 'active' : '' }}" href="{{ route('admin.orders.returned') }}">Returned</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $active == 'cancelled' ? 'active' : '' }}" href="{{ route('admin.orders.cancelled') }}">Cancelled</a>
        </li>

    </ul>

    <div class="py-3">
        {{-- @include('admin.properties.filter') --}}
    </div>

</div>
