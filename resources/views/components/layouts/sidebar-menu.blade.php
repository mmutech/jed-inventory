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

            <!-- SRA -->
            @can('index-sra')
            <li class="menu-item {{ Request::is('sra') || Request::is('create-sra') || Request::is('show-sra/*') || Request::is('confirm-item/*') || Request::is('quality-check/*') || Request::is('edit-sra/*') ? 'active open' : '' }}">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-folder-open"></i>
                <div data-i18n="sra Settings">SRA</div>
              </a>
              <ul class="menu-sub">
              <li class="menu-item {{ Request::is('sra') ? 'active open' : '' }}">
                  <a href="{{url('sra');}}" class="menu-link">
                    <div data-i18n="sra">SRA</div>
                  </a>
                </li>
                <li class="menu-item {{ Request::is('create-sra') ? 'active open' : '' }}">
                  <a href="{{url('create-sra');}}" class="menu-link">
                    <div data-i18n="sra">New SRA</div>
                  </a>
                </li>
              </ul>
            </li>
            @endcan

            <li class="menu-item {{ Request::is('request-index') || Request::is('request-item') || Request::is('request-view/*') || Request::is('request-scn/*') ? 'active open' : '' }}">
              <a href="{{url('request-index');}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Basic">Requests</div>
              </a>
            </li> 

            <!-- <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-folder-open"></i>
                <div data-i18n="Settings">Request</div>
              </a>
              <ul class="menu-sub">

                @can('index-srcn')
                <li class="menu-item">
                  <a href="{{url('srcn-index');}}" class="menu-link">
                    <div data-i18n="Basic">SRCN</div>
                  </a>
                </li> 
                @endcan

                @can('index-srin')
                <li class="menu-item">
                  <a href="{{url('srin-index');}}" class="menu-link">
                    <div data-i18n="Basic">SRIN</div>
                  </a>
                </li> 
                @endcan

                @can('index-scn')
                <li class="menu-item">
                  <a href="{{url('scn-index');}}" class="menu-link">
                    <div data-i18n="Basic">SCN</div>
                  </a>
                </li> 
                @endcan
              </ul>
            </li> -->

            <!-- Report -->
            <li class="menu-item {{ Request::is('bin-card-show') || Request::is('store-ledger-show') ? 'active open' : '' }}">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-folder-open"></i>
                <div data-i18n="sra Settings">Report</div>
              </a>
              <ul class="menu-sub">
                <!-- Store Bin Card-->
                @can('index-bin-card')
                <li class="menu-item {{ Request::is('bin-card-show') ? 'active open' : '' }}">
                  <a href="{{url('bin-card-show');}}" class="menu-link">
                    <div data-i18n="bin_card">Stores Bin Card</div>
                  </a>
                </li>
                @endcan

                <!-- Store Ledger-->
                @can('index-ledger')
                <li class="menu-item {{ Request::is('store-ledger-show') ? 'active open' : '' }}">
                  <a href="{{url('store-ledger-show');}}" class="menu-link">
                    <div data-i18n="ledger">Stores Ledger</div>
                  </a>
                </li>
                @endcan
              </ul>
            </li>

            <!-- <li class="menu-item">
              <a href="{{url('/barcode');}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-scan"></i>
                <div data-i18n="Basic">Barcode Scanner</div>
              </a>
            </li>  -->

            <!-- Store -->
            @can('index-store')
            <li class="menu-item {{Request::is('store-index') || Request::is('store-edit/*') || Request::is('store-create') ? 'active' : '' }}">
              <a href="{{url('store-index');}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Basic">Store</div>
              </a>
            </li> 
            @endcan

            <!-- Stock -->
            @can('index-stock')
            <li class="menu-item {{ Request::is('stock-category-index') || Request::is('stock-class-index') || Request::is('stock-code-index') || Request::is('stock-code-create') || Request::is('stock-code-edit') || Request::is('stock-class-create') || Request::is('stock-class-edit') || Request::is('stock-category-create') || Request::is('stock-category-edit') ? 'active open' : '' }}">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-folder-open"></i>
                <div data-i18n="sra Settings">Stock</div>
              </a>
              <ul class="menu-sub">
              <li class="menu-item {{Request::is('stock-category-index') || Request::is('stock-category-create') || Request::is('stock-category-edit') ? 'active' : '' }}">
                  <a href="{{url('stock-category-index');}}" class="menu-link">
                    <div data-i18n="category">Category</div>
                  </a>
                </li>
                <li class="menu-item {{Request::is('stock-class-index') || Request::is('stock-class-create') || Request::is('stock-class-edit') ? 'active' : '' }}">
                  <a href="{{url('stock-class-index');}}" class="menu-link">
                    <div data-i18n="class">Class</div>
                  </a>
                </li>
                <li class="menu-item {{Request::is('stock-code-index') || Request::is('stock-code-create') || Request::is('stock-code-edit') ? 'active' : '' }}">
                  <a href="{{url('stock-code-index');}}" class="menu-link">
                    <div data-i18n="code">Codes</div>
                  </a>
                </li>
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