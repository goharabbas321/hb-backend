<!-- BEGIN: Theme CSS-->
<!-- Fonts -->
@if (app()->getLocale() == 'ar')
    <!-- Add custom fonts for Arabic -->
    <style>
        @font-face {
            font-family: 'SomarSansLight';
            src: url('/assets/fonts/SomarSans-Light.woff2') format('woff2');
        }
        @font-face {
            font-family: 'SomarSansRegular';
            src: url('/assets/fonts/SomarSans-Regular.woff2') format('woff2');
        }
        @font-face {
            font-family: 'SomarSansMedium';
            src: url('/assets/fonts/SomarSans-Medium.woff2') format('woff2');
        }
        @font-face {
            font-family: 'SomarSansBold';
            src: url('/assets/fonts/SomarSans-SemiBold.woff2') format('woff2');
        }

        body {
            font-family: 'SomarSansMedium', sans-serif !important;
        }
    </style>
@else
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
@endif

@vite(['resources/assets/vendor/fonts/tabler-icons.scss', 'resources/assets/vendor/fonts/fontawesome.scss', 'resources/assets/vendor/fonts/flag-icons.scss', 'resources/assets/vendor/libs/node-waves/node-waves.scss'])
<!-- Core CSS -->
@vite(['resources/assets/vendor/scss' . $configData['rtlSupport'] . '/core' . ($configData['style'] !== 'light' ? '-' . $configData['style'] : '') . '.scss', 'resources/assets/vendor/scss' . $configData['rtlSupport'] . '/' . $configData['theme'] . ($configData['style'] !== 'light' ? '-' . $configData['style'] : '') . '.scss', 'resources/assets/css/demo.css'])


<!-- Vendor Styles -->
@vite(['resources/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.scss', 'resources/assets/vendor/libs/typeahead-js/typeahead.scss'])
@yield('vendor-style')

<!-- Page Styles -->
@yield('page-style')
