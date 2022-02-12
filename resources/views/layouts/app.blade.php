<html dir="{{ config('settings.application.layout') }}" lang="<?php

                                                                use Illuminate\Support\Facades\Cookie;

                                                                app()->getLocale(); ?>">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>@yield('title') - {{ config('app.name') }}</title>
    <link rel="shortcut icon" href="{{ request()->root().config('settings.application.company_icon') }}" />
    <link rel="apple-touch-icon" href="{{ request()->root().config('settings.application.company_icon') }}" />
    <link rel="apple-touch-icon-precomposed" href="{{ request()->root().config('settings.application.company_icon') }}" />
    <style>
        [v-cloak] {
            display: none;
        }
    </style>

    @include('layouts.includes.header')
</head>

<body>
    <div id="app">
        <div class="container-scroller">
            <!--Top Navbar-->
            @section('nav-bar')
            @include('layouts.includes.navbar')
            @show

            <!--Sidebar-->
            @section('side-bar')
            @include('layouts.includes.sidebar')
            @show

            <div class="container-fluid page-body-wrapper">
                <div class="main-panel">
                    <!--Contents-->
                    @yield('contents')

                </div>
            </div>
        </div>
    </div>

    @include('layouts.includes.footer')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    @if( Cookie::has('error_for_create_reading') && Cookie::has('error_for_create_reading_field') )
    <script>
        swal({
            title: "{{ Cookie::get('error_for_create_reading_field') }}",
            text: "{{ Cookie::get('error_for_create_reading') }}",
            icon: "error",
            button: "Okay",
        });
    </script>
    <?php
    unset($_COOKIE['error_for_create_reading']);
    setcookie('error_for_create_reading', null, -1, '/');
    unset($_COOKIE['error_for_create_reading_field']);
    setcookie('error_for_create_reading_field', null, -1, '/');
    ?>
    @endif

    @if( Cookie::has('delete_record_from_table') )
    <script>
        swal({
            title: "{{ Cookie::get('delete_record_from_table').' Deleted!!' }}",
            icon: "success",
            button: "Okay",
        });
    </script>
    <?php
    unset($_COOKIE['delete_record_from_table']);
    setcookie('delete_record_from_table', null, -1, '/');
    ?>
    @endif
    @if( Cookie::has('not_delete_record_from_table') )
    <script>
        swal({
            title: "{{ 'Problem in deleting '.Cookie::get('not_delete_record_from_table') }}",
            icon: "error",
            button: "Okay",
        });
    </script>
    <?php
    unset($_COOKIE['not_delete_record_from_table']);
    setcookie('not_delete_record_from_table', null, -1, '/');
    ?>
    @endif

    @if( Cookie::has('not_delete_user_record_from_table') )
    <script>
        swal({
            title: "This User has some water tank reading records are available, so you can not delete this user",
            icon: "error",
            button: "Okay",
        });
    </script>
    <?php
    unset($_COOKIE['not_delete_user_record_from_table']);
    setcookie('not_delete_user_record_from_table', null, -1, '/');
    ?>
    @endif

    @if( Cookie::has('not_delete_houselot_record_from_table') )
    <script>
        swal({
            title: "This House Lot is linked with some water tank reading records, so you can not delete this record",
            icon: "error",
            button: "Okay",
        });
    </script>
    <?php
    unset($_COOKIE['not_delete_houselot_record_from_table']);
    setcookie('not_delete_houselot_record_from_table', null, -1, '/');
    ?>
    @endif

    @if( Cookie::has('not_delete_branch_record_from_table') )
    <script>
        swal({
            title: "This Branch is linked with some user or house lots, so you can not delete this record",
            icon: "error",
            button: "Okay",
        });
    </script>
    <?php
    unset($_COOKIE['not_delete_branch_record_from_table']);
    setcookie('not_delete_branch_record_from_table', null, -1, '/');
    ?>
    @endif

    @if( Cookie::has('reading_created') && Cookie::get('reading_created') )
    <script>
        swal({
            title: "Reading Created!",
            icon: "success",
            button: "Okay",
        });
    </script>
    <?php
    unset($_COOKIE['reading_created']);
    setcookie('reading_created', null, -1, '/');
    ?>
    @endif
    @if( Cookie::has('reading_updated') && Cookie::get('reading_updated') )
    <script>
        swal({
            title: "Reading Updated!",
            icon: "success",
            button: "Okay",
        });
    </script>
    <?php
    unset($_COOKIE['reading_updated']);
    setcookie('reading_updated', null, -1, '/');
    ?>
    @endif
    @if( Cookie::has('reading_not_updated') && Cookie::get('reading_not_updated') )
    <script>
        swal({
            title: "Reading Not Updated!",
            text: "There is problem updating Reading !!",
            icon: "error",
            button: "Okay",
        });
    </script>
    <?php
    unset($_COOKIE['reading_not_updated']);
    setcookie('reading_not_updated', null, -1, '/');
    ?>
    @endif


</body>

</html>