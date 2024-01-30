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
            <li class="menu-item">
              <a href="{{url('purchase-order');}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Basic">Purchased Order</div>
              </a>
            </li> 

            <!-- SRA -->
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
            
            <!-- SRCN -->
            <li class="menu-item">
              <a href="{{url('srcn-index');}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Basic">SRCN</div>
              </a>
            </li> 

             <!-- SRIN -->
             <li class="menu-item">
              <a href="{{url('srin-index');}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Basic">SRIN</div>
              </a>
            </li> 

            <!-- SCN -->
            <li class="menu-item">
              <a href="cards-basic.html" class="menu-link">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Basic">SCN</div>
              </a>
            </li> 

            <!-- Store -->
            <li class="menu-item">
              <a href="{{url('store-index');}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Basic">Store</div>
              </a>
            </li> 

            <!-- Store Bin Card-->
            <li class="menu-item">
              <a href="{{url('bin-card-index');}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Basic">Stores Bin Card</div>
              </a>
            </li> 

             <!-- STock -->
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

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Users</span>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-folder-open"></i>
                <div data-i18n="Account Settings">Account Settings</div>
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
                  <a href="pages-account-settings-notifications.html" class="menu-link">
                    <div data-i18n="Notifications">Permission</div>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </aside>