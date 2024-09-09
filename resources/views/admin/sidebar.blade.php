<div class="wrapper">
<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
      <!-- Logo Header -->
      <div class="logo-header" data-background-color="dark">
        <a href="{{url('/admin/dashboard')}}" class="logo" style="color: white; font-size: 20px">
          <img
            src="{{asset('tour_image/'.$site_settings->admin_logo)}}"
            alt="navbar brand"
            class="navbar-brand"
            width="50px"
            height="50"
          />
          {{$site_settings->admin_site_name}}
        </a>
        <div class="nav-toggle">
          <button class="btn btn-toggle toggle-sidebar">
            <i class="gg-menu-right"></i>
          </button>
          <button class="btn btn-toggle sidenav-toggler">
            <i class="gg-menu-left"></i>
          </button>
        </div>
        <button class="topbar-toggler more">
          <i class="gg-more-vertical-alt"></i>
        </button>
      </div>
      <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
      <div class="sidebar-content">
        <ul class="nav nav-secondary">
          <li class="nav-item {{ Route::is('admin.dashboard') ? 'active' : '' }}">
            <a
              href="{{url('/admin/dashboard')}}"
            >
              <i class="fas fa-home"></i>
              <p>Dashboard</p>
              {{-- <span class="caret"></span> --}}
            </a>
            {{-- <div class="collapse" id="dashboard">
              <ul class="nav nav-collapse">
                <li>
                  <a href="../demo1/index.html">
                    <span class="sub-item">Dashboard 1</span>
                  </a>
                </li>
              </ul>
            </div> --}}
          </li>
          {{-- <li class="nav-section">
            <span class="sidebar-mini-icon">
              <i class="fa fa-ellipsis-h"></i>
            </span>
            <h4 class="text-section">Components</h4>
          </li> --}}
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#base">
              <i class="fas fa-layer-group"></i>
              <p>Tour Packages</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="base">
              <ul class="nav nav-collapse">
                <li class="">
                  <a href="{{url('add_packages')}}">
                    <span class="sub-item">Add Packages</span>
                  </a>
                </li>
                <li>
                  <a href="{{url('view_packages')}}">
                    <span class="sub-item">View Packages</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#sidebarLayouts">
              <i class="fas fa-bookmark"></i>
              <p>Booking</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="sidebarLayouts">
              <ul class="nav nav-collapse">
                <li>
                  <a href="{{url('view_booking')}}">
                    <span class="sub-item">View Booking</span>
                  </a>
                </li>
                <li>
                    <a href="{{url('payment_details')}}">
                      <span class="sub-item">View Payment Details</span>
                    </a>
                </li>
                <li>
                    <a href="{{url('all_payment_report')}}">
                      <span class="sub-item">All Payment Report</span>
                    </a>
                </li>
                <li>
                    <a href="{{url('view_all_customer')}}">
                      <span class="sub-item">View All Customers</span>
                    </a>
                </li>
                <li>
                  {{-- <a href="icon-menu.html">
                    <span class="sub-item">Icon Menu</span>
                  </a> --}}
                </li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#sidebarLayouts19">
                <i class="mdi mdi-basket-unfill menu-icon"></i>
              <p>Sales Invoice</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="sidebarLayouts19">
              <ul class="nav nav-collapse">
                <li>
                  <a href="{{url('sales-form')}}">
                    <span class="sub-item">Sales Invoice</span>
                  </a>
                </li>
                <li>
                  {{-- <a href="icon-menu.html">
                    <span class="sub-item">Icon Menu</span>
                  </a> --}}
                </li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#sidebarLayouts110">
                <i class="mdi mdi-home-export-outline menu-icon"></i>
              <p>
                Sales Information
                </p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="sidebarLayouts110">
              <ul class="nav nav-collapse">
                <li>
                  <a href="{{url('suspended_orders')}}">
                    <span class="sub-item">Ordered Items</span>
                  </a>
                </li>

                <li>
                    <a href="{{url('daily_sales_report')}}">
                      <span class="sub-item">Daily Sales</span>
                    </a>
                  </li>

                <li>
                    <a href="{{url('all_sales_report')}}">
                      <span class="sub-item">All Sales</span>
                    </a>
                </li>

                <li>
                    <a href="{{url('accounts-receivable')}}">
                      <span class="sub-item">Accounts Receivable</span>
                    </a>
                </li>

              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#sidebarLayouts1">
                <i class="mdi mdi mdi-basket-fill menu-icon"></i>
              <p>Purchase Invoice</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="sidebarLayouts1">
              <ul class="nav nav-collapse">
                <li>
                  <a href="{{url('purchase-form')}}">
                    <span class="sub-item">Purchase Invoice</span>
                  </a>
                </li>
                <li>
                  {{-- <a href="icon-menu.html">
                    <span class="sub-item">Icon Menu</span>
                  </a> --}}
                </li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#sidebarLayouts122234">
                <i class="mdi mdi-home-import-outline menu-icon"></i>
              <p>Purchase Information</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="sidebarLayouts122234">
              <ul class="nav nav-collapse">
                <li>
                  <a href="{{url('daily-purchase-report')}}">
                    <span class="sub-item">Daily Purchase</span>
                  </a>
                </li>
                <li>
                    <a href="{{url('all-purchase-report')}}">
                        <span class="sub-item">All Purchase</span>
                      </a>
                </li>

                <li>
                    <a href="{{url('accounts-payable')}}">
                        <span class="sub-item">Accounts Payable</span>
                      </a>
                </li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#sidebarLayouts11">
                <i class="mdi mdi-sitemap menu-icon"></i>
              <p>
                Category & Items
                </p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="sidebarLayouts11">
              <ul class="nav nav-collapse">
                <li>
                  <a href="{{url('all-product-cat')}}">
                    <span class="sub-item">Categories</span>
                  </a>
                </li>
                <li>
                    <a href="{{url('all-subCat1')}}">
                      <span class="sub-item">Sub Categories</span>
                    </a>
                  </li>
                {{-- <li>
                    <a href="{{url('view_category')}}">
                      <span class="sub-item">View Category</span>
                    </a>
                </li> --}}

                  <li>
                    <a href="{{url('all-products')}}">
                      <span class="sub-item">Products</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{url('all-suppliers')}}">
                      <span class="sub-item">Suppliers</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{url('all-unit')}}">
                      <span class="sub-item">All Units</span>
                    </a>
                  </li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#sidebarLayouts12">
                <i class="mdi mdi-account-cash-outline menu-icon"></i>
              <p>Salary</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="sidebarLayouts12">
              <ul class="nav nav-collapse">
                <li>
                  <a href="{{url('salary-type')}}">
                    <span class="sub-item">Salary Type</span>
                  </a>
                </li>
                <li>
                    <a href="{{url('salary-info')}}">
                        <span class="sub-item">Salary Information</span>
                      </a>
                </li>
                <li>
                    <a href="{{url('salary-details')}}">
                        <span class="sub-item">Salary Details</span>
                      </a>
                </li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#sidebarLayouts122">
                <i class="mdi mdi-bank menu-icon"></i>
              <p>
                Bank & Payments
                </p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="sidebarLayouts122">
              <ul class="nav nav-collapse">
                <li>
                  <a href="{{url('bank-actions')}}">
                    <span class="sub-item">Bank</span>
                  </a>
                </li>
                <li>
                    <a href="{{url('trx-reports')}}">
                        <span class="sub-item">Bank Transaction Report</span>
                      </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#sidebarLayouts1225">
                <i class="mdi mdi-file-chart menu-icon"></i>
              <p>
                Reports
                </p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="sidebarLayouts1225">
              <ul class="nav nav-collapse">
                <li>
                  <a href="{{url('purchaseReport')}}">
                    <span class="sub-item">Purchase Report</span>
                  </a>
                </li>
                <li>
                    <a href="{{url('salesReport')}}">
                        <span class="sub-item">Sales Report</span>
                      </a>
                </li>
                <li>
                    <a href="{{url('expenseReport')}}">
                        <span class="sub-item">Expense Report</span>
                      </a>
                </li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#sidebarLayouts1222">
                <i class="mdi mdi-warehouse menu-icon"></i>
              <p>Stock</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="sidebarLayouts1222">
              <ul class="nav nav-collapse">
                <li>
                  <a href="{{url('all-stock-report')}}">
                    <span class="sub-item">Stock Report</span>
                  </a>
                </li>
                <li>
                    <a href="{{url('stock-transfer')}}">
                        <span class="sub-item">Stock Transfer</span>
                      </a>
                </li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#sidebarLayouts12223">
                <i class="fa-solid fa-money-check menu-icon"></i>
              <p>
                Accounts information
                </p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="sidebarLayouts12223">
              <ul class="nav nav-collapse">
                <li>
                  <a href="{{url('supplier-payment')}}">
                    <span class="sub-item">Supplier Payment</span>
                  </a>
                </li>
                <li>
                    <a href="{{url('supplier-balance')}}">
                        <span class="sub-item">Supplier Ledger</span>
                      </a>
                </li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#sidebarLayouts122230">
                <i class="mdi mdi-sync-alert menu-icon"></i>
              <p>
                Return
                </p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="sidebarLayouts122230">
              <ul class="nav nav-collapse">
                <li>
                  <a href="{{url('create-return')}}">
                    <span class="sub-item">Create Return</span>
                  </a>
                </li>
                <li>
                    <a href="{{url('all-return')}}">
                        <span class="sub-item">All Returned Requests</span>
                      </a>
                </li>
                <li>
                    <a href="{{url('completed-return')}}">
                        <span class="sub-item">Completed Return</span>
                      </a>
                </li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#sidebarLayouts123">
              {{-- <i class="fas fa-bookmark"></i> --}}
              <i class="mdi mdi-cash-100 menu-icon"></i>
              <p>Expense</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="sidebarLayouts123">
              <ul class="nav nav-collapse">
                <li>
                  <a href="{{url('expense')}}">
                    <span class="sub-item">Expense</span>
                  </a>
                </li>
                <li>
                    <a href="{{url('expense-category-list')}}">
                        <span class="sub-item">Expenses Category</span>
                      </a>
                </li>
                <li>
                    <a href="{{url('all-expenses')}}">
                        <span class="sub-item">All Expenses</span>
                      </a>
                </li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#tables">
              <i class="fas fa-phone"></i>
              <p>Manage Contacts</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="tables">
              <ul class="nav nav-collapse">
                <li>
                  <a href="{{url('view_message')}}">
                    <span class="sub-item">View All Messages</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>


          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#tables2">
              <i class="fas fa-users"></i>
              <p>Manage users</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="tables2">
              <ul class="nav nav-collapse">
                <li>
                  <a href="{{url('add_users')}}">
                    <span class="sub-item">Add user</span>
                  </a>
                </li>
                <li>
                  <a href="{{url('view_users')}}">
                    <span class="sub-item">Manage Users</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#forms">
              <i class="far fa-file-alt"></i>
              <p>Manage Pages</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="forms">
              <ul class="nav nav-collapse">
                <li>
                  <a href="{{url('update_about_us')}}">
                    <span class="sub-item">About Us</span>
                  </a>
                </li>
                <li>
                    <a href="{{url('add_our_services')}}">
                      <span class="sub-item">Services</span>
                    </a>
                </li>
                <li>
                    <a href="{{url('add_photo_gallery')}}">
                      <span class="sub-item">Photo Gallery</span>
                    </a>
                </li>
                <li>
                    {{-- <a href="#">
                      <span class="sub-item">Tour Packages</span>
                    </a> --}}
                </li>
                {{-- <li>
                    <a href="#">
                      <span class="sub-item">Contact</span>
                    </a>
                </li> --}}
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#maps">
              <i class="fas fa-cogs"></i>
              <p>Site Settings</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="maps">
              <ul class="nav nav-collapse">
                <li>
                  <a href="{{url('site_settings')}}">
                    <span class="sub-item">Manage Site Settings</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>


          {{-- <li class="nav-item">
            <a
              href="{{url('/purchase_form')}}"
            >
              <i class="fas fa-shopping-bag"></i>

              <span class="sub-item">Purchase Invoice</span>
            </a> --}}

        </ul>
      </div>
    </div>
  </div>
  <!-- End Sidebar -->
