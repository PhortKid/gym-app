@php
                        use App\Models\SystemInfo;
                        $system=SystemInfo::first();  
@endphp
<!doctype html>
<html
  lang="en"
  class="layout-menu-fixed layout-compact"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Gym Dashboard</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../asssets/img/favicon/favicon.ico" />

   <!-- DataTables CSS and JS -->
    <link href="{{asset('assets/datatable/jquery.dataTables.min.css')}}" rel="stylesheet">
    <script src="{{asset('assets/datatable/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('assets/datatable/jquery.dataTables.min.js')}}"></script>



    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/iconify-icons.css')}}" />

    <!-- Core CSS -->
    <!-- build:css {{asset('assets/vendor/css/theme.css')}}  -->

    <link rel="stylesheet" href="{{asset('assets/vendor/css/core.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/demo.css')}}" />

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />

    <!-- endbuild -->

    <link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}" />

    <link rel="stylesheet" href="{{asset('assets/datatable/datatables.bootstrap5.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/datatable/responsive.bootstrap5.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/datatable/buttons.bootstrap5.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/datatable/flatpickr.css')}}" />
  <!-- Row Group CSS -->
  <link rel="stylesheet" href="{{asset('assets/datatable/rowgroup.bootstrap5.css')}}" />
  
    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{asset('assets/vendor/js/helpers.js')}}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

    <script src="{{asset('assets/js/config.js')}}"></script>

    <link rel="stylesheet" href="{{asset('assets/css/sweetalert2.min.css')}}">
      <!-- SweetAlert2 JS -->
      <script src="{{asset('assets/js/sweetalert2@11.js')}}"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

   <style>
    body{
      font-family: 'Lato', sans-serif;
    }
    .swal2-container {
  z-index: 2000 !important;
}

.z-top {
  z-index: 2000 !important;
}

.report-header {
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .company-logo {
            width: 200px;
        }

@media print {
    @import url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css');
      @page {
            margin: 0;
        }
        body {
            margin: 1cm;
            zoom: 75%; 
        }
        header, footer {
            display: none;
        }
        
        .table-dark {
    background-color: #343a40 !important;
    color: white !important;
    -webkit-print-color-adjust: exact; /* For Safari/Chrome */
    print-color-adjust: exact; 
  }

  .table-info {
    background-color: #d1ecf1 !important;
    color: #0c5460 !important;
    -webkit-print-color-adjust: exact; /* For Safari/Chrome */
    print-color-adjust: exact; 
  }
  .bg-primary {
    background-color: #0d6efd !important;
    -webkit-print-color-adjust: exact; /* For Safari/Chrome */
    print-color-adjust: exact; /* For Firefox */
    color: white !important;
  }

  /* Ongeza kwa classes nyingine kama unavyotaka */
  .bg-success {
    background-color: #198754 !important;
    color: white !important;
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
  }

    }


    /*small card */
    .small-card {
        min-height: auto;
    }

    .small-card .card-body {
        padding: 0.75rem 1rem;
    }

    .small-card .card-title {
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }

    .small-card h4 {
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
    }

    .avatar img {
        width: 32px;
        height: 32px;
    }
   </style>


  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

     @include('workspace_layout.sidebar')

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme"
            id="layout-navbar">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                <i class="icon-base bx bx-menu icon-md"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">
              <!-- Search -->
              <div class="navbar-nav align-items-center me-auto">
              {{-- <div class="nav-item d-flex align-items-center">
                  <span class="w-px-22 h-px-22"><i class="icon-base bx bx-search icon-md"></i></span>
                  <input
                    type="text"
                    class="form-control border-0 shadow-none ps-1 ps-sm-2 d-md-block d-none"
                    placeholder="Search..."
                    aria-label="Search..." />
                </div>--}} 
              </div>
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-md-auto">
                <!-- Place this tag where you want the button to render. -->
    

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a
                    class="nav-link dropdown-toggle hide-arrow p-0"
                    href="javascript:void(0);"
                    data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="{{asset('profile.png')}}" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="{{asset('profile.png')}}" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <h6 class="mb-0"></h6>
                            <small class="text-body-secondary">{{Auth::user()->name}}</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    {{--   <li>
                      <div class="dropdown-divider my-1"></div>
                    </li>
                  
                    <li>
                      <a class="dropdown-item" href="#">
                        <i class="icon-base bx bx-user icon-md me-3"></i><span>My Profile</span>
                      </a>
                    </li>--}}
                
                    <li>
                      <div class="dropdown-divider my-1"></div>
                    </li>
                    <li>
                    <a href="{{ route('signout') }}" class="dropdown-item">
                      <i class="icon-base bx bx-power-off icon-md me-3"></i>
                      <span>Log Out</span>
                    </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->
            <!-- Content wrapper -->
         <div class="content-wrapper">
            @yield('content')
         </div>
        
            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl">
                <div
                  class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                  <div class="mb-2 mb-md-0">
               
                    {{ $system->name ?? 'App Name' }}
                   @
                    <script>
                      document.write(new Date().getFullYear());
                    </script>
                    
                   {{-- <a href="#" target="_blank" class="footer-link">Nextgentz</a>--}}
                  </div>

                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

  
 
    <!-- Core JS -->



    <script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>

    <script src="{{asset('assets/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{asset('assets/vendor/js/bootstrap.js')}}"></script>

    <script src="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>

    <script src="{{asset('assets/vendor/js/menu.js')}}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>

    <!-- Main JS -->

    <script src="{{asset('assets/js/main.js')}}"></script>

    <!-- Page JS -->
    <script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>


       <!-- endbuild -->
<!-- CSS -->








       
    <!-- Vendors JS -->
    <script src="{{asset('assets/datatable/datatables-bootstrap5.js')}}"></script>
    <!-- Main JS -->
    <!-- Page JS -->
    <script src="{{asset('assets/datatable/tables-datatables-basic.js')}}"></script>

    <!-- Place this tag before closing body tag for github widget button. -->
    <script async defer src="{{asset('assets/datatable/buttons.js')}}"></script>
  </body>
</html>
