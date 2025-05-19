<!DOCTYPE html>
@php
    $menuFixed =
        $configData['layout'] === 'vertical'
            ? $menuFixed ?? ''
            : ($configData['layout'] === 'front'
                ? ''
                : $configData['headerType']);
    $navbarType =
        $configData['layout'] === 'vertical'
            ? $configData['navbarType'] ?? ''
            : ($configData['layout'] === 'front'
                ? 'layout-navbar-fixed'
                : '');
    $isFront = ($isFront ?? '') == true ? 'Front' : '';
    $contentLayout = isset($container) ? ($container === 'container-xxl' ? 'layout-compact' : 'layout-wide') : '';
    $current_language = app()->getLocale();
@endphp

<html lang="{{ session()->get('locale') ?? app()->getLocale() }}"
    class="{{ $configData['style'] }}-style {{ $contentLayout ?? '' }} {{ $navbarType ?? '' }} {{ $menuFixed ?? '' }} {{ $menuCollapsed ?? '' }} {{ $menuFlipped ?? '' }} {{ $menuOffcanvas ?? '' }} {{ $footerFixed ?? '' }} {{ $customizerHidden ?? '' }}"
    dir="{{ $configData['textDirection'] }}" data-theme="{{ $configData['theme'] }}"
    data-assets-path="{{ asset('/assets') . '/' }}" data-base-url="{{ url('/') }}" data-framework="laravel"
    data-template="{{ $configData['layout'] . '-menu-' . $configData['themeOpt'] . '-' . $configData['styleOpt'] }}"
    data-style="{{ $configData['styleOptVal'] }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@yield('title') |
        {{ $current_language == 'ar' ? $systemSettings['name_ar'] : $systemSettings['name'] }}
    </title>
    <meta name="author"
        content="{{ $current_language == 'ar' ? $systemSettings['creator_name_ar'] : $systemSettings['creator_name'] }}">
    <meta name="title"
        content="{{ $current_language == 'ar' ? $systemSettings['title_ar'] : $systemSettings['title'] }}">
    <meta name="description"
        content="{{ $current_language == 'ar' ? $systemSettings['description_ar'] : $systemSettings['description'] }}" />
    <meta name="keywords"
        content="{{ $current_language == 'ar' ? $systemSettings['keywords_ar'] : $systemSettings['keywords'] }}">
    <!-- laravel CRUD token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Canonical SEO -->
    <link rel="canonical" href="{{ url()->full() }}">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('/storage/' . $systemSettings['favicon']) }}" />


    <!-- Include Styles -->
    <!-- $isFront is used to append the front layout styles only on the front layout otherwise the variable will be blank -->
    @include('layouts/sections/styles' . $isFront)

    <!-- Include Scripts for customizer, helper, analytics, config -->
    <!-- $isFront is used to append the front layout scriptsIncludes only on the front layout otherwise the variable will be blank -->
    @include('layouts/sections/scriptsIncludes' . $isFront)
    @livewireStyles
</head>

<body>

    <!-- Layout Content -->
    @yield('layoutContent')
    <!--/ Layout Content -->



    <!-- Include Scripts -->
    <!-- $isFront is used to append the front layout scripts only on the front layout otherwise the variable will be blank -->
    @include('layouts/sections/scripts' . $isFront)
    @livewireScripts

    @include('layouts/sections/notifyScripts')

    <script>
        window.APP_LOCALE = "{{ app()->getLocale() }}";
        window.APP_URL = "{{ url('/') }}";
    </script>


    @stack('script-page')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select2
            var select2 = $('.main_select2');
            if (select2.length) {
                select2.each(function() {
                    var $this = $(this);
                    $this.wrap('<div class="position-relative"></div>').select2({
                        dropdownParent: $this.parent(),
                        placeholder: $this.data('placeholder') // for dynamic placeholder
                    });
                });
            }

            $(document).on('submit', 'form.delete-record', function(event) {
                event.preventDefault(); // Prevent the default form submission

                const form = this; // Reference the form being submitted

                Swal.fire({
                        title: "{{ __('messages.validation.confirm_delete.title') }}",
                        text: "{{ __('messages.validation.confirm_delete.text') }}",
                        icon: "warning",
                        showCancelButton: true,
                        cancelButtonText: "{{ __('messages.validation.confirm_delete.btn_cancel') }}",
                        confirmButtonText: "{{ __('messages.validation.confirm_delete.btn_confirm') }}",
                        customClass: {
                            confirmButton: "btn btn-primary me-3 waves-effect waves-light",
                            cancelButton: "btn btn-outline-secondary waves-effect",
                        },
                        buttonsStyling: !1,
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            // If confirmed, submit the form
                            form.submit();
                        }
                    });
            });
        });
    </script>

</body>

</html>
