@php
    use Illuminate\Support\Facades\Vite;
@endphp

<!-- Vendor Styles -->
@vite(['resources/assets/vendor/libs/toastr/toastr.scss', 'resources/assets/vendor/libs/animate-css/animate.scss'])

<!-- Vendor Script -->
@vite(['resources/assets/vendor/libs/toastr/toastr.js'])

@vite(['resources/js/app.js'])

<script>
    'use strict';
    document.addEventListener('DOMContentLoaded', function() {
        toastr.options = {
            closeButton: true,
            debug: false,
            newestOnTop: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            preventDuplicates: false,
            onclick: null,
            showDuration: '300',
            hideDuration: '1000',
            timeOut: '15000',
            extendedTimeOut: '1000',
            showEasing: 'swing',
            hideEasing: 'linear',
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut'
        };
    });
</script>

@if (session('alert'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            toastr.{{ session('alert')['type'] }}("{{ session('alert')['message'] }}", "", {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": 15000 // Time in ms
            });
        });
    </script>
@endif

@if (session()->has('notify'))
    @foreach (session('notify') as $msg)
        <script>
            'use strict';
            document.addEventListener('DOMContentLoaded', function() {
                toastr.{{ $msg[0] }}("{{ $msg[1] }}");
            });
        </script>
    @endforeach
@endif

@if ($errors->any())
    <script>
        'use strict';
        @foreach ($errors->all() as $error)
            document.addEventListener('DOMContentLoaded', function() {
                toastr.error('{{ $error }}');
            });
        @endforeach
    </script>
@endif
<script>
    'use strict';

    function notify(status, message) {
        document.addEventListener('DOMContentLoaded', function() {
            toastr[status](message);
        });

    }
</script>
