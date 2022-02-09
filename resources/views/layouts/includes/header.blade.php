@stack('before-styles')
{{ style(mix('css/dropzone.css')) }}
{{ style(mix('css/core.css')) }}
{{ style(mix('css/fontawesome.css')) }}
{{ style('vendor/summernote/summernote-bs4.css') }}
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css" />
<style>
    .table-btn {
        margin-top: 3px !important;
    }

    .dataTables_filter {
        margin-right: 20px;
    }

    .dataTables_length {
        margin-left: 20px;
    }

    .dataTables_info {
        margin: 0 0 10px 15px !important;
    }

    .dataTables_paginate {
        margin: 0 15px 10px 0 !important;
    }

    .th.sorting {
        display: non;
    }

    .pagniation .page-item.previous {
        margin-right: 50px !important;
    }

    .pagniation .page-item.next {
        margin-left: 50px !important;
    }
</style>
@stack('after-styles')