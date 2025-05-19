/**
 * Settings
 */
'use strict';

import __ from '../../../../i18n_module';

//Javascript to handle the Settings Page

document.addEventListener('DOMContentLoaded', function (e) {
    (function () {
        // Select2
        var select2 = $('.select2');
        if (select2.length) {
            select2.each(function () {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    dropdownParent: $this.parent(),
                    placeholder: $this.data('placeholder') // for dynamic placeholder
                });
            });
        }

        $('#backups-link').on('click', function (e) {
            e.preventDefault(); // Prevents the default link action
            // Prevent default submission and show confirmation
            Swal.fire({
                title: __('alert.confirm_alert.title'),
                text: __('alert.confirm_alert.text'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: __('alert.confirm_alert.btn_confirm'),
                cancelButtonText: __('alert.confirm_alert.btn_cancel'),
                customClass: {
                    confirmButton: "btn btn-primary me-3 waves-effect waves-light",
                    cancelButton: "btn btn-outline-secondary waves-effect",
                },
                buttonsStyling: !1,
            }).then(result => {
                if (result.isConfirmed) {
                    const swalInstance = Swal.fire({
                        title: __('alert.confirm_refresh.title'),
                        text: __('alert.confirm_refresh.text'),
                        icon: "info",
                        showConfirmButton: false, // Disable OK button
                        showCancelButton: false, // Disable Cancel button
                        allowOutsideClick: false, // Prevent closing by clicking outside
                        cancelButtonText: __('alert.confirm_refresh.btn_cancel'),
                        confirmButtonText: __('alert.confirm_refresh.btn_confirm'),
                        customClass: {
                            confirmButton: "btn btn-primary me-3 waves-effect waves-light d-none",
                            cancelButton: "btn btn-outline-secondary waves-effect d-none",
                        },
                        buttonsStyling: !1,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: window.StoreURL, // Adjust the route as needed
                        method: 'GET',
                        data: {
                            _token: window.Token, // CSRF token
                        },
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            xhr.addEventListener('progress', function (e) {
                                if (e.lengthComputable) {
                                    var percent = (e.loaded / e.total) *
                                        100;
                                    // Step 2: Update the progress bar and text dynamically
                                    swalInstance.$content.find(
                                        '#progressBar').val(
                                            percent);
                                    swalInstance.$content.find(
                                        '#progressText').text(
                                            Math.round(percent) + '%');
                                }
                            });
                            return xhr;
                        },
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: __('alert.confirm_refresh.success'),
                                text: response.message,
                                showConfirmButton: true, // Disable OK button
                                showCancelButton: false, // Disable Cancel button
                                allowOutsideClick: false, // Prevent closing by clicking outside
                                cancelButtonText: __('alert.confirm_refresh.btn_cancel'),
                                confirmButtonText: __('alert.confirm_refresh.btn_confirm'),
                                customClass: {
                                    confirmButton: "btn btn-primary me-3 waves-effect waves-light",
                                    cancelButton: "btn btn-outline-secondary waves-effect d-none",
                                },
                                buttonsStyling: !1,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Refresh the window after the user clicks OK
                                    window.location.reload();
                                }
                            });
                        },
                        error: function (error) {
                            Swal.fire({
                                icon: 'error',
                                title: "{{ __('alert.confirm_refresh.error') }}",
                                text: error.responseJSON.message,
                                showConfirmButton: true, // Disable OK button
                                showCancelButton: false, // Disable Cancel button
                                allowOutsideClick: false, // Prevent closing by clicking outside
                                cancelButtonText: "{{ __('alert.confirm_refresh.btn_cancel') }}",
                                confirmButtonText: "{{ __('alert.confirm_refresh.btn_confirm') }}",
                                customClass: {
                                    confirmButton: "btn btn-primary me-3 waves-effect waves-light",
                                    cancelButton: "btn btn-outline-secondary waves-effect d-none",
                                },
                                buttonsStyling: !1,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Refresh the window after the user clicks OK
                                    window.location.reload();
                                }
                            });
                        }
                    });
                } else {
                    console.log('Form submission canceled.');
                }
            });
        });

        const create_form = document.getElementById('create_form');

        if (create_form) {
            const fv = FormValidation.formValidation(create_form, {
                fields: {
                    clearance: {
                        validators: {
                            notEmpty: {
                                message: __('messages.years.create.validation.name_empty')
                            },
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap5: new FormValidation.plugins.Bootstrap5({
                        // Use this for enabling/changing valid/invalid class
                        // eleInvalidClass: '',
                        eleValidClass: '',
                        rowSelector: function (field, ele) {
                            // field is the field name & ele is the field element
                            switch (field) {
                                case 'clearance':
                                default:
                                    return '.row';
                            }
                        }
                    }),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    autoFocus: new FormValidation.plugins.AutoFocus()
                },
                init: instance => {
                    // Handle what happens after validation passes
                    instance.on('core.form.valid', function () {
                        console.log('Form is valid. You can now handle submission.');

                        // Prevent default submission and show confirmation
                        Swal.fire({
                            title: __('alert.confirm_alert.title'),
                            text: __('alert.confirm_alert.text'),
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: __('alert.confirm_alert.btn_confirm'),
                            cancelButtonText: __('alert.confirm_alert.btn_cancel'),
                            customClass: {
                                confirmButton: "btn btn-primary me-3 waves-effect waves-light",
                                cancelButton: "btn btn-outline-secondary waves-effect",
                            },
                            buttonsStyling: !1,
                        }).then(result => {
                            if (result.isConfirmed) {
                                const swalInstance = Swal.fire({
                                    title: __('alert.confirm_refresh.title'),
                                    text: __('alert.confirm_refresh.text'),
                                    icon: "info",
                                    showConfirmButton: false, // Disable OK button
                                    showCancelButton: false, // Disable Cancel button
                                    allowOutsideClick: false, // Prevent closing by clicking outside
                                    cancelButtonText: __('alert.confirm_refresh.btn_cancel'),
                                    confirmButtonText: __('alert.confirm_refresh.btn_confirm'),
                                    customClass: {
                                        confirmButton: "btn btn-primary me-3 waves-effect waves-light d-none",
                                        cancelButton: "btn btn-outline-secondary waves-effect d-none",
                                    },
                                    buttonsStyling: !1,
                                    didOpen: () => {
                                        Swal.showLoading();
                                    }
                                });

                                $.ajax({
                                    url: window.StoreURL, // Adjust the route as needed
                                    method: 'PUT',
                                    data: {
                                        _token: window.Token, // CSRF token
                                        clearance: $("#clearance").val(),
                                    },
                                    xhr: function () {
                                        var xhr = new window.XMLHttpRequest();
                                        xhr.addEventListener('progress', function (e) {
                                            if (e.lengthComputable) {
                                                var percent = (e.loaded / e.total) *
                                                    100;
                                                // Step 2: Update the progress bar and text dynamically
                                                swalInstance.$content.find(
                                                    '#progressBar').val(
                                                        percent);
                                                swalInstance.$content.find(
                                                    '#progressText').text(
                                                        Math.round(percent) + '%');
                                            }
                                        });
                                        return xhr;
                                    },
                                    success: function (response) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: __('alert.confirm_refresh.success'),
                                            text: response.message,
                                            showConfirmButton: true, // Disable OK button
                                            showCancelButton: false, // Disable Cancel button
                                            allowOutsideClick: false, // Prevent closing by clicking outside
                                            cancelButtonText: __('alert.confirm_refresh.btn_cancel'),
                                            confirmButtonText: __('alert.confirm_refresh.btn_confirm'),
                                            customClass: {
                                                confirmButton: "btn btn-primary me-3 waves-effect waves-light",
                                                cancelButton: "btn btn-outline-secondary waves-effect d-none",
                                            },
                                            buttonsStyling: !1,
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                // Refresh the window after the user clicks OK
                                                window.location.reload();
                                            }
                                        });
                                    },
                                    error: function (error) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: "{{ __('alert.confirm_refresh.error') }}",
                                            text: error.responseJSON.message,
                                            showConfirmButton: true, // Disable OK button
                                            showCancelButton: false, // Disable Cancel button
                                            allowOutsideClick: false, // Prevent closing by clicking outside
                                            cancelButtonText: "{{ __('alert.confirm_refresh.btn_cancel') }}",
                                            confirmButtonText: "{{ __('alert.confirm_refresh.btn_confirm') }}",
                                            customClass: {
                                                confirmButton: "btn btn-primary me-3 waves-effect waves-light",
                                                cancelButton: "btn btn-outline-secondary waves-effect d-none",
                                            },
                                            buttonsStyling: !1,
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                // Refresh the window after the user clicks OK
                                                window.location.reload();
                                            }
                                        });
                                    }
                                });
                            } else {
                                console.log('Form submission canceled.');
                            }
                        });
                    });

                    instance.on('plugins.message.placed', function (e) {
                        //* Move the error message out of the `input-group` element
                        if (e.element.parentElement.classList.contains('input-group')) {
                            // `e.field`: The field name
                            // `e.messageElement`: The message element
                            // `e.element`: The field element
                            e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
                        }
                        //* Move the error message out of the `row` element for custom-options
                        if (e.element.parentElement.parentElement.classList.contains('custom-option')) {
                            e.element.closest('.row').insertAdjacentElement('afterend', e.messageElement);
                        }
                    });
                }
            });
        }

    })()

});
