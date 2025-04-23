<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{url('/')}}" class="app-brand-link">
            <span class="app-brand-logo demo mr-2">
                <img src="{{ asset('assets/img/jed-pics/logo2.png') }}" style="width: 70px" />
            </span>
            <span class="h4 fw-bolder mt-4 text-right">JED PLC</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item {{ Request::is('dashboard') ? 'active open' : '' }}">
        <a href="{{url('dashboard');}}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
        </a>
    </li>

    <!-- Purchase Order -->
    @can('index-po')
    <li class="menu-item {{ Request::is('purchase-order') || Request::is('purchase-order-create') || Request::is('purchase-order-show/*') || Request::is('purchase-order-edit/*') || Request::is('purchase-order-edit-item/*') ? 'active open' : '' }}">
        <a href="{{url('purchase-order');}}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-collection"></i>
        <div data-i18n="Basic">Purchase Order</div>
        </a>
    </li>
    @endcan

    @can('quality-check')
    <li class="menu-item {{ Request::is('quality-check') || Request::is('quality-check-single/*') ? 'active open' : '' }}">
        <a href="{{url('quality-check');}}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-collection"></i>
        <div data-i18n="Basic">Quality Check</div>
        </a>
    </li>
    @endcan

    <!-- SRA -->
    @can('index-sra')
    <li class="menu-item {{ Request::is('sra') || Request::is('create-sra') || Request::is('show-sra/*') || Request::is('confirm-item/*') || Request::is('edit-sra/*') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-folder-open"></i>
        <div data-i18n="sra Settings">SRA</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{ Request::is('sra') || Request::is('show-sra/*') ? 'active open' : '' }}">
                <a href="{{url('sra');}}" class="menu-link">
                <div data-i18n="sra">SRA</div>
                </a>
            </li>
            @can('create-sra')
            <li class="menu-item {{ Request::is('create-sra') || Request::is('confirm-item/*') ? 'active open' : '' }}">
                <a href="{{url('create-sra');}}" class="menu-link">
                <div data-i18n="sra">Raise SRA</div>
                </a>
            </li>
            @endcan
        </ul>
    </li>
    @endcan

    <li class="menu-item {{ Request::is('request-index') || Request::is('request-item') || Request::is('request-view/*') || Request::is('request-scn/*') ? 'active open' : '' }}">
        <a href="{{url('request-index');}}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-collection"></i>
        <div data-i18n="Basic">Requests</div>
        </a>
    </li>

    <!-- Report -->
    <li class="menu-item {{ Request::is('bin-card') || Request::is('single-bin-card/*') || Request::is('journal-report') || Request::is('general-report') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-folder-open"></i>
        <div data-i18n="sra Settings">Report</div>
        </a>
        <ul class="menu-sub">
        <!-- Store Bin Card-->
        @can('bin-card')
        <li class="menu-item {{ Request::is('bin-card') || Request::is('single-bin-card/*') ? 'active open' : '' }}">
            <a href="{{url('bin-card');}}" class="menu-link">
            <div data-i18n="bin_card">Stores Bin Card</div>
            </a>
        </li>
        @endcan

        <!-- Journal -->
        @can('journal-report')
        <li class="menu-item {{ Request::is('journal-report') ? 'active open' : '' }}">
            <a href="{{url('journal-report');}}" class="menu-link">
            <div data-i18n="journal-report">Journal</div>
            </a>
        </li>
        @endcan

        <!-- General Report-->
        @can('general-report')
        <li class="menu-item {{ Request::is('general-report') ? 'active open' : '' }}">
            <a href="{{url('general-report');}}" class="menu-link">
            <div data-i18n="general-report">General Report</div>
            </a>
        </li>
        @endcan
        </ul>
    </li>

    <!-- Stock -->
    @can('stocks')
    <li class="menu-item {{ Request::is('stock-categories') || Request::is('stock-classes') || Request::is('stock-codes') || Request::is('general-ledger') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-folder-open"></i>
        <div data-i18n="sra Settings">Stock Management</div>
        </a>
        <ul class="menu-sub">
        @can('classes')
        <li class="menu-item {{Request::is('stock-classes') ? 'active' : '' }}">
            <a href="{{url('stock-classes');}}" class="menu-link">
            <div data-i18n="class">Stock Classes</div>
            </a>
        </li>
        @endcan
        @can('categories')
        <li class="menu-item {{Request::is('stock-categories') ? 'active' : '' }}">
            <a href="{{url('stock-categories');}}" class="menu-link">
            <div data-i18n="category">Stock Categories</div>
            </a>
        </li>
        @endcan
        @can('ledgers')
        <li class="menu-item {{Request::is('general-ledger') ? 'active' : '' }}">
            <a href="{{url('general-ledger');}}" class="menu-link">
            <div data-i18n="ledger">General Ledger</div>
            </a>
        </li>
        @endcan
        @can('codes')
        <li class="menu-item {{Request::is('stock-codes') ? 'active' : '' }}">
            <a href="{{url('stock-codes');}}" class="menu-link">
            <div data-i18n="code">Stock Codes</div>
            </a>
        </li>
        @endcan
        </ul>
    </li>
    @endcan

    <!-- Others -->
    @can('others')
    <li class="menu-item {{ Request::is('stores') || Request::is('units') || Request::is('locations') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-folder-open"></i>
        <div data-i18n="sra Settings">Others</div>
        </a>
        <ul class="menu-sub">
        <!-- Store-->
        @can('stores')
        <li class="menu-item {{ Request::is('stores') ? 'active open' : '' }}">
            <a href="{{url('stores');}}" class="menu-link">
            <div data-i18n="bin_card">Stores</div>
            </a>
        </li>
        @endcan

        <!-- Unit -->
        @can('units')
        <li class="menu-item {{ Request::is('units') ? 'active open' : '' }}">
            <a href="{{url('units');}}" class="menu-link">
            <div data-i18n="units">Units</div>
            </a>
        </li>
        @endcan

        <!-- Locations-->
        @can('locations')
        <li class="menu-item {{ Request::is('locations') ? 'active open' : '' }}">
            <a href="{{url('locations');}}" class="menu-link">
            <div data-i18n="locations">Locations</div>
            </a>
        </li>
        @endcan
        </ul>
    </li>
    @endcan

    @canany(['index-user', 'index-role', 'index-permission'])
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Users</span>
    </li>
    <li class="menu-item {{ Request::is('users') || Request::is('roles') || Request::is('permissions') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-folder-open"></i>
        <div data-i18n="Account Settings">User Management</div>
        </a>
        <ul class="menu-sub">
        @can('index-user')
        <li class="menu-item {{Request::is('users') ? 'active' : '' }}">
            <a href="{{url('users');}}" class="menu-link">
            <div data-i18n="Account">Users</div>
            </a>
        </li>
        @endcan

        @can('index-role')
        <li class="menu-item {{Request::is('roles') ? 'active' : '' }}">
            <a href="{{url('roles');}}" class="menu-link">
            <div data-i18n="Account">Role</div>
            </a>
        </li>
        @endcan

        @can('index-permission')
        <li class="menu-item {{Request::is('permissions') ? 'active' : '' }}">
            <a href="{{url('permissions');}}" class="menu-link">
            <div data-i18n="Notifications">Permission</div>
            </a>
        </li>
        @endcan
        </ul>
    </li>
    @endcanany
    </ul>
</aside>
