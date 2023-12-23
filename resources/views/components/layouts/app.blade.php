<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default"
    data-assets-path="../../assets/" data-template="vertical-menu-template">

<head>
    <title>{{ $title ?? 'View Ads' }}</title>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <meta name="description" content="" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ '/assets/img/favicon/favicon.ico' }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ '/assets/vendor/fonts/fontawesome.css' }}" />
    <link rel="stylesheet" href="{{ '/assets/vendor/fonts/tabler-icons.css' }}" />
    <link rel="stylesheet" href="{{ '/assets/vendor/fonts/flag-icons.css' }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ '/assets/vendor/css/rtl/core.css' }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ '/assets/vendor/css/rtl/theme-default.css' }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ '/assets/css/demo.css' }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ '/assets/vendor/libs/node-waves/node-waves.css' }}" />
    <link rel="stylesheet" href="{{ '/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css' }}" />
    <link rel="stylesheet" href="{{ '/assets/vendor/libs/typeahead-js/typeahead.css' }}" />
    <link rel="stylesheet" href="{{ '/assets/vendor/libs/apex-charts/apex-charts.css' }}" />
    <link rel="stylesheet" href="{{ '/assets/vendor/libs/swiper/swiper.css' }}" />
    <link rel="stylesheet" href="{{ '/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css' }}" />
    <link rel="stylesheet" href="{{ '/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css' }}" />
    <link rel="stylesheet" href="{{ '/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css' }}" />
    <link rel="stylesheet" href="{{ '/assets/vendor/libs/@form-validation/umd/styles/index.min.css' }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">


    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ '/assets/vendor/css/pages/cards-advance.css' }}" />
    <!-- Helpers -->
    <script src="{{ '/assets/vendor/js/helpers.js' }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ '/assets/vendor/js/template-customizer.js' }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ '/assets/js/config.js' }}"></script>
    @livewireStyles
    @livewireScripts
    <Style>
        .swal2-container {
            z-index: 1100 !important;

        }

        button.swal2-cancel {
            margin-left: 10px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 6px 12px !important;
            margin-top: 10px !important;
        }

        div#DataTables_Table_0_length {
            position: absolute;
            top: 90px;

        }

        div#DataTables_Table_0_filter {
            margin-top: 0px !important
        }

        div.dataTables_wrapper div.dataTables_length select {
            padding: 0.322rem 0.45rem 0.322rem 0.875rem;
            font-size: 0.9375rem;
            font-weight: 400;
            line-height: 1.5;
            color: #6f6b7d;
            appearance: none;
            background-color: #fff;
            background-repeat: no-repeat;
            background-position: right 0.875rem center;
            background-size: 22px 20px;
            border: 0.5px solid #dbdade;
            outline: none;
            border-radius: 4px;
        }

        input[type="search"] {
            outline: none;
            height: 38px;
            min-width: 210px;
            padding-left: 10px;
            border-radius: 6px;
            border-width: 0.5px;
            border-color: #767283;
            color: #767283
        }

        a.paginate_button.current {
            background: #7367f0;
            color: #fff;
            border-radius: 5px;
        }

        th {
            padding-right: 0px !important;
        }

        th::before {
            content: none !important;
        }

        th::after {
            content: none !important;
        }

        table.dataTable.no-footer {
            border-bottom: none !important
        }
    </Style>


</head>

<body>
    {{-- {{ $slot }} --}}
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('components.layouts.sidebar')
            <!-- / Menu -->
            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('components.layouts.navbar')

                <!-- / Navbar -->
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @include('components.layouts.main')
                        @yield('main')
                    </div>
                    <!-- / Content -->
                    <!-- Footer -->
                    @include('components.layouts.footer')
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js /assets/vendor/js/core.js -->

    <script src="{{ '/assets/vendor/libs/jquery/jquery.js' }}"></script>
    <script src="{{ '/assets/vendor/libs/popper/popper.js' }}"></script>
    <script src="{{ '/assets/vendor/js/bootstrap.js' }}"></script>
    <script src="{{ '/assets/vendor/libs/node-waves/node-waves.js' }}"></script>
    <script src="{{ '/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js' }}"></script>
    <script src="{{ '/assets/vendor/libs/hammer/hammer.js' }}"></script>
    <script src="{{ '/assets/vendor/libs/i18n/i18n.js' }}"></script>
    <script src="{{ '/assets/vendor/libs/typeahead-js/typeahead.js' }}"></script>
    <script src="{{ '/assets/vendor/js/menu.js' }}"></script>

    <!-- endbuild -->
    <!-- Vendors JS -->
    <script src="{{ '/assets/vendor/libs/apex-charts/apexcharts.js' }}"></script>
    <script src="{{ '/assets/vendor/libs/swiper/swiper.js' }}"></script>
    <script src="{{ '/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js' }}"></script>

    <!-- Main JS -->
    <script src="{{ '/assets/js/main.js' }}"></script>
    <script src="{{ asset('livewire/index.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ '/assets/js/dashboards-analytics.js' }}"></script>
    <script src="{{ '/assets/js/tables-datatables-advanced.js' }}"></script>
    <script src="{{ '/assets/vendor/libs/@form-validation/umd/bundle/popular.min.js' }}"></script>
    <script src="{{ '/assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js' }}"></script>
    <script src="{{ '/assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js' }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    @yield('script_page')
</body>

</html>
