<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/')}}"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>JED | INVENTORY</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('assets/logo2.png')}}" />

     <!-- Fonts -->
     <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/boxicons.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/fontawesome.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/flag-icons.css')}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('assets/css/demo.css')}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/typeahead-js/typeahead.css')}}" /> 
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/bs-stepper/bs-stepper.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{asset('assets/vendor/js/helpers.js')}}"></script>
    <script src="{{asset('assets/vendor/js/template-customizer.js')}}"></script>
    <script src="{{asset('assets/js/config.js')}}"></script>

    <!-- Toast CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        @include('components.layouts.sidebar-menu')

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->
          @include('components.layouts.top-nav')
          
          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">

              @yield('content')

              </div>
            </div>
            @include('components.layouts.footer')
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
  <!-- build:js assets/vendor/js/core.js -->
  <script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/popper/popper.js')}}"></script>
  <script src="{{asset('assets/vendor/js/bootstrap.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/hammer/hammer.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/i18n/i18n.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/typeahead-js/typeahead.js')}}"></script>
  <script src="{{asset('assets/vendor/js/menu.js')}}"></script>
  
  <!-- endbuild -->

  <!-- Vendors JS -->
  <script src="{{asset('assets/vendor/libs/bs-stepper/bs-stepper.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>

  <!-- Main JS -->
  <script src="{{asset('assets/js/main.js')}}"></script>
  
  <!-- Page JS --> 
  <script src="{{asset('assets/js/form-wizard-numbered.js')}}"></script>
  <script src="{{asset('assets/js/form-wizard-validation.js')}}"></script>
  <script src="{{asset('assets/js/dynamic-input.js')}}"></script>

   
    <!-- Toast JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <!-- Toast Script For Livewire -->
    <script>
      $(document).ready(function() {
          toastr.options = {
              "progressBar": true,
              "positionClass": "toast-top-right",
              "timeOut": 3000,
              "progressBarClass": "custom-toast",
          };

          $('#drps').select2({
            dropdownParent: $('#dynamicFieldsContainer')
          });
      });
  
      window.addEventListener('success', (event) => {
          toastr.success(event.detail.message);
          document.querySelector('.custom-toast').classList.add('toast-success');
      });
  
      window.addEventListener('warning', (event) => {
          toastr.warning(event.detail.message);
          document.querySelector('.custom-toast').classList.add('toast-warning');
      });
  
      window.addEventListener('error', (event) => {
          toastr.error(event.detail.message);
          document.querySelector('.custom-toast').classList.add('toast-danger');
      });

      window.addEventListener('info', (event) => {
          toastr.info(event.detail.message);
          document.querySelector('.custom-toast').classList.add('toast-info');
      });


  </script>  

    <!-- Connect Component Files js -->
    <!-- @stack('scripts') -->
    @livewireScripts
    </body>
</html>