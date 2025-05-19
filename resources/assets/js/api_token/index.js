/**
 * API Tokens
 */

'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
    (function () {
        const formApiKey = document.querySelector('#formAccountSettingsApiKey');

        // Form validation for API key
        if (formApiKey) {
            const fvApi = FormValidation.formValidation(formApiKey, {
                fields: {
                    name: {
                        validators: {
                            notEmpty: {
                                message: __('messages.api_tokens.create.validation.name_empty')
                            }
                        }
                    },
                    'permissions[]': {
                        validators: {
                            notEmpty: {
                                message: __('messages.api_tokens.create.validation.permission_empty')
                            }
                        }
                    }
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
                                case 'name':
                                case 'permissions[]':
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
                            title: __('messages.validation.confirm_alert.title'),
                            text: __('messages.validation.confirm_alert.text'),
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: __('messages.validation.confirm_alert.btn_confirm'),
                            cancelButtonText: __('messages.validation.confirm_alert.btn_cancel'),
                            customClass: {
                                confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                                cancelButton: 'btn btn-outline-secondary waves-effect'
                            },
                            buttonsStyling: !1
                        }).then(result => {
                            if (result.isConfirmed) {
                                document.getElementById('formAccountSettingsApiKey').submit(); // Programmatically submit the form
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
    })();

    $(document).on('click', '.delete-record', function (e) {
        e.preventDefault(); // Prevent any default action

        var form = $(this).closest("form"); // Reference the form being submitted

        Swal.fire({
            title: __('messages.validation.confirm_delete.title'),
            text: __('messages.validation.confirm_delete.text'),
            icon: "warning",
            showCancelButton: true,
            cancelButtonText: __('messages.validation.confirm_delete.btn_cancel'),
            confirmButtonText: __('messages.validation.confirm_delete.btn_confirm'),
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

    $(document).on('click', '.btn-copy', function (e) {
        e.preventDefault();

        // Find the nearest .my-token text
        const tokenText = $(this).closest('.token-container').find('.my-token').text();

        // Copy the token text to the clipboard
        navigator.clipboard.writeText(tokenText)
            .then(() => {
                // Display success message using SweetAlert2
                Swal.fire({
                    icon: 'success',
                    title: __('messages.api_tokens.show.validation.alert_copy.success.title'),
                    text: __('messages.api_tokens.show.validation.alert_copy.success.text'),
                    timer: 2000,
                    showConfirmButton: false
                });
            })
            .catch(err => {
                // Display error message using SweetAlert2
                Swal.fire({
                    icon: 'error',
                    title: __('messages.api_tokens.show.validation.alert_copy.error.title'),
                    text: __('messages.api_tokens.show.validation.alert_copy.error.text'),
                    showConfirmButton: true
                });
                console.error('Failed to copy token:', err);
            });
    });


});

// Select2 (jquery)
$(function () {
    var select2 = $('.select2');

    // Initialize Select2
    if (select2.length) {
        select2.each(function () {
            var $this = $(this);
            $this.wrap('<div class="position-relative"></div>');
            $this.select2({
                dropdownParent: $this.parent(),
                multiple: true, // Enable multiple selection
                placeholder: __('messages.api_tokens.create.placeholder_api_access'), // Optional: Add a placeholder
                allowClear: true // Optional: Allow clearing selections
            });
        });
    }
});
