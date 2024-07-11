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
            <li class="menu-item active">
              <a href="{{url('dashboard');}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>

            <!-- Purchase Order -->
            @can('index-po')
            <li class="menu-item">
              <a href="{{url('purchase-order');}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Basic">Purchased Order</div>
              </a>
            </li> 
            @endcan

            <!-- SRA -->
            @can('index-sra')
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-folder-open"></i>
                <div data-i18n="sra Settings">SRA</div>
              </a>
              <ul class="menu-sub">
              <li class="menu-item">
                  <a href="{{url('sra');}}" class="menu-link">
                    <div data-i18n="sra">SRA</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{url('create-sra');}}" class="menu-link">
                    <div data-i18n="sra">New SRA</div>
                  </a>
                </li>
              </ul>
            </li>
            @endcan
            
            <!-- SRCN -->
            @can('index-srcn')
            <li class="menu-item">
              <a href="{{url('srcn-index');}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Basic">SRCN</div>
              </a>
            </li> 
            @endcan

             <!-- SRIN -->
             @can('index-srin')
             <li class="menu-item">
              <a href="{{url('srin-index');}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Basic">SRIN</div>
              </a>
            </li> 
            @endcan

            <!-- SCN -->
            @can('index-scn')
            <li class="menu-item">
              <a href="{{url('scn-index');}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Basic">SCN</div>
              </a>
            </li> 
            @endcan

            <!-- Store -->
            @can('index-store')
            <li class="menu-item">
              <a href="{{url('store-index');}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Basic">Store</div>
              </a>
            </li> 
            @endcan

            <!-- Store Bin Card-->
            @can('index-bin-card')
            <li class="menu-item">
              <a href="{{url('bin-card-index');}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Basic">Stores Bin Card</div>
              </a>
            </li> 
            @endcan

            <!-- Store Ledger-->
            @can('index-ledger')
            <li class="menu-item">
              <a href="{{url('store-ledger-index');}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Basic">Stores Ledger</div>
              </a>
            </li> 
            @endcan

            <!-- STock -->
            @can('index-stock')
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-folder-open"></i>
                <div data-i18n="sra Settings">Stock</div>
              </a>
              <ul class="menu-sub">
              <li class="menu-item">
                  <a href="{{url('stock-category-index');}}" class="menu-link">
                    <div data-i18n="category">Category</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{url('stock-class-index');}}" class="menu-link">
                    <div data-i18n="class">Class</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{url('stock-code-index');}}" class="menu-link">
                    <div data-i18n="code">Codes</div>
                  </a>
                </li>
              </ul>
            </li>
            @endcan

            @can('index-user')
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Users</span>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-folder-open"></i>
                <div data-i18n="Account Settings">User Management</div>
              </a>
              <ul class="menu-sub">
              <li class="menu-item">
                  <a href="{{url('users');}}" class="menu-link">
                    <div data-i18n="Account">Users</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{url('roles');}}" class="menu-link">
                    <div data-i18n="Account">Role</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{url('permissions');}}" class="menu-link">
                    <div data-i18n="Notifications">Permission</div>
                  </a>
                </li>
              </ul>
            </li>
            @endcan
          </ul>
        </aside>