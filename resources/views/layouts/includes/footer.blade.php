<footer>
    <script>
        window.settings = <?php echo json_encode($settings) ?>
    </script>

    @stack('before-scripts')
    <script>
        window.localStorage.setItem('app-language', '<?php echo app()->getLocale() ?? "en"; ?>');

        window.localStorage.setItem('app-languages',
            JSON.stringify(
                <?php echo json_encode(include resource_path() . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . (app()->getLocale() ?? 'en') . DIRECTORY_SEPARATOR . 'default.php') ?>
            )
        );

        window.appLanguage = window.localStorage.getItem('app-language');
        window.localStorage.setItem('base_url', '{{request()->root()}}');
    </script>
    @if(auth()->check())
    <script>
        window.user = <?php echo auth()->user(); ?>;
    </script>
    @endif

    {!! script('https://js.stripe.com/v3/') !!}
    {!! script(mix('js/manifest.js')) !!}
    {!! script(mix('js/vendor.js')) !!}
    {!! script(mix('js/core.js')) !!}
    {!! script('vendor/summernote/summernote-bs4.js') !!}

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            // $('#water_reading_table').DataTable();
            // $('#branches_table').DataTable();
            // $('#house_lots_table').DataTable();
            // $('#users_table').DataTable();
        });
    </script>
    @stack('after-scripts')
</footer>