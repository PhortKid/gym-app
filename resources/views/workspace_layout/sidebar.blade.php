<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="#" class="app-brand-link">
      <span class="app-brand-logo demo">
        <img src="{{ asset('favicon.png') }}" width="200" height="150" alt="Logo">
      </span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="bx bx-chevron-left d-block d-xl-none align-middle"></i>
    </a>
  </div>

  <div class="menu-divider mt-0"></div>
  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    
    <!-- Dashboard -->
    <li class="menu-item">
      <a href="#" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div class="text-truncate">Dashboard</div>
      </a>
    </li>

    <!-- Member Section -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-id-card"></i>
        <div class="text-truncate">Member</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="/membership_plan" class="menu-link">
            <div class="text-truncate">Membership Type</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="/customer" class="menu-link">
            <div class="text-truncate">New Member</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="/scann" class="menu-link" target="_blank">
            <div class="text-truncate">Scan</div>
          </a>
        </li>
      </ul>
    </li>

    <!-- Attendance -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-calendar-check"></i>
        <div class="text-truncate">Attendance</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="/attendance" class="menu-link">
            <div class="text-truncate">Add</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="/attendance_tracking" class="menu-link">
            <div class="text-truncate">Track</div>
          </a>
        </li>
      </ul>
    </li>

    <!-- Users -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-group"></i>
        <div class="text-truncate">Users</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="/users" class="menu-link">
            <div class="text-truncate">Management</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="/trainer" class="menu-link">
            <div class="text-truncate">Trainer</div>
          </a>
        </li>
      </ul>
    </li>

    <!-- Financial -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-wallet"></i>
        <div class="text-truncate">Financial</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="/payment_report" class="menu-link">
            <div class="text-truncate">Payment Report</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="/financial_report" class="menu-link">
            <div class="text-truncate">Financial Report</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="/invoice" class="menu-link">
            <div class="text-truncate">Invoice</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="/paid_customer" class="menu-link">
            <div class="text-truncate">Paid Members</div>
          </a>
        </li>
      </ul>
    </li>

    <!-- Income -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-money"></i>
        <div class="text-truncate">Income Module</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="/income_category" class="menu-link">
            <div class="text-truncate">Income Category</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="/income" class="menu-link">
            <div class="text-truncate">Incomes</div>
          </a>
        </li>
      </ul>
    </li>

    <!-- Expense -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-credit-card-alt"></i>
        <div class="text-truncate">Expense Module</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="/expense_category" class="menu-link">
            <div class="text-truncate">Expense Category</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="/expense" class="menu-link">
            <div class="text-truncate">Expenses</div>
          </a>
        </li>
      </ul>
    </li>

  </ul>
</aside>
