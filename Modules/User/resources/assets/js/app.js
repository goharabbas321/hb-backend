'use strict';

import __ from '../../../../i18n_module';
import Swal from "sweetalert2";

document.addEventListener('DOMContentLoaded', function (e) {
    (function () {
        const user_form = document.getElementById('user_form'),
            country_select = jQuery(user_form.querySelector('[name="country"]')),
            language_select = jQuery(user_form.querySelector('[name="language"]')),
            currency_select = jQuery(user_form.querySelector('[name="currency"]')),
            time_zone_select = jQuery(user_form.querySelector('[name="time_zone"]')),
            role_select = jQuery(user_form.querySelector('[name="role"]'));

        const fv = FormValidation.formValidation(user_form, {
            fields: {
                username: {
                    validators: {
                        notEmpty: {
                            message: __('users.validation.username_empty')
                        },
                        stringLength: {
                            min: 4,
                            max: 12,
                            message: __('users.validation.username_length')
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9_]+$/,
                            message: __('users.validation.username_regex')
                        }
                    }
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: __('users.validation.email_empty')
                        },
                        emailAddress: {
                            message: __('users.validation.email_valid')
                        }
                    }
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: __('users.validation.password_empty')
                        },
                        stringLength: {
                            min: 8,
                            message: __('users.validation.password_length')
                        }
                    }
                },
                password_confirmation: {
                    validators: {
                        notEmpty: {
                            message: __('users.validation.password_confirmation_empty')
                        },
                        identical: {
                            compare: function () {
                                return user_form.querySelector('[name="password"]').value;
                            },
                            message: __('users.validation.password_confirmation_same')
                        }
                    }
                },
                name: {
                    validators: {
                        notEmpty: {
                            message: __('users.validation.name_empty')
                        },
                        stringLength: {
                            min: 6,
                            max: 30,
                            message: __('users.validation.name_length')
                        },
                        regexp: {
                            regexp: /^[a-zA-Z\u0600-\u06FF\s]+$/,
                            message: __('users.validation.name_regex')
                        }
                    }
                },
                phone: {
                    validators: {
                        notEmpty: {
                            message: __('users.validation.phone_empty')
                        },
                        regexp: {
                            regexp: /^\d{11}$/,
                            message: __('users.validation.phone_length')
                        }
                    }
                },
                country: {
                    validators: {
                        notEmpty: {
                            message: __('users.validation.country_empty')
                        }
                    }
                },
                address: {
                    validators: {
                        notEmpty: {
                            message: __('users.validation.address_empty')
                        }
                    }
                },
                language: {
                    validators: {
                        notEmpty: {
                            message: __('users.validation.language_empty')
                        }
                    }
                },
                currency: {
                    validators: {
                        notEmpty: {
                            message: __('users.validation.currency_empty')
                        }
                    }
                },
                time_zone: {
                    validators: {
                        notEmpty: {
                            message: __('users.validation.time_zone_empty')
                        }
                    }
                },
                role: {
                    validators: {
                        notEmpty: {
                            message: __('users.validation.role_empty')
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
                            case 'username':
                            case 'email':
                            case 'password':
                            case 'password_confirmation':
                            case 'name':
                            case 'phone':
                            case 'country':
                            case 'address':
                            case 'language':
                            case 'currency':
                            case 'timezone':
                            case 'role':
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
                            document.getElementById('user_form').submit(); // Programmatically submit the form
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

        //? Revalidation third-party libs inputs on change trigger

        // Select2 (Country)
        if (country_select.length) {
            country_select.wrap('<div class="position-relative"></div>');
            country_select
                .select2({
                    placeholder: __('users.validation.country_select'),
                    dropdownParent: country_select.parent()
                })
                .on('change', function () {
                    // Revalidate the color field when an option is chosen
                    fv.revalidateField('country');
                });
        }

        // Select2 (Language)
        if (language_select.length) {
            language_select.wrap('<div class="position-relative"></div>');
            language_select
                .select2({
                    placeholder: __('users.validation.language_select'),
                    dropdownParent: language_select.parent()
                })
                .on('change', function () {
                    // Revalidate the color field when an option is chosen
                    fv.revalidateField('language');
                });
        }

        // Select2 (Currency)
        if (currency_select.length) {
            currency_select.wrap('<div class="position-relative"></div>');
            currency_select
                .select2({
                    placeholder: __('users.validation.country_select'),
                    dropdownParent: currency_select.parent()
                })
                .on('change', function () {
                    // Revalidate the color field when an option is chosen
                    fv.revalidateField('currency');
                });
        }

        // Select2 (Time Zone)
        if (time_zone_select.length) {
            time_zone_select.wrap('<div class="position-relative"></div>');
            time_zone_select
                .select2({
                    placeholder: __('users.validation.time_zone_select'),
                    dropdownParent: time_zone_select.parent()
                })
                .on('change', function () {
                    // Revalidate the color field when an option is chosen
                    fv.revalidateField('time_zone');
                });
        }

        // Select2 (ROLE)
        if (role_select.length) {
            role_select.wrap('<div class="position-relative"></div>');
            role_select
                .select2({
                    placeholder: __('users.validation.role_select'),
                    dropdownParent: role_select.parent()
                })
                .on('change', function () {
                    // Revalidate the color field when an option is chosen
                    fv.revalidateField('role');
                });
        }

        // Update/reset user image of account page
        let accountUserImage = document.getElementById('uploadedAvatar');
        const fileInput = document.querySelector('.account-file-input'),
            resetFileInput = document.querySelector('.account-image-reset');

        if (accountUserImage) {
            const resetImage = accountUserImage.src;
            fileInput.onchange = () => {
                if (fileInput.files[0]) {
                    accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
                }
            };
            resetFileInput.onclick = () => {
                fileInput.value = '';
                accountUserImage.src = resetImage;
            };
        }

        // Click bulk action for blocking users
        $(document).on('click', '#btn-block-selected', function () {

            Swal.fire({
                title: __('alert.confirm_alert.title'),
                text: __('alert.confirm_alert.text'),
                icon: "warning",
                showCancelButton: true,
                cancelButtonText: __('alert.confirm_alert.btn_cancel'),
                confirmButtonText: __('alert.confirm_alert.btn_confirm'),
                customClass: {
                    confirmButton: "btn btn-primary me-3 waves-effect waves-light",
                    cancelButton: "btn btn-outline-secondary waves-effect",
                },
                buttonsStyling: !1,
            })
                .then((result) => {
                    if (result.isConfirmed) {
                        // If confirmed, submit the request
                        bulkSelected('block');
                    }
                });
        });

        // Click bulk action for unblocking users
        $(document).on('click', '#btn-unblock-selected', function () {

            Swal.fire({
                title: __('alert.confirm_alert.title'),
                text: __('alert.confirm_alert.text'),
                icon: "warning",
                showCancelButton: true,
                cancelButtonText: __('alert.confirm_alert.btn_cancel'),
                confirmButtonText: __('alert.confirm_alert.btn_confirm'),
                customClass: {
                    confirmButton: "btn btn-primary me-3 waves-effect waves-light",
                    cancelButton: "btn btn-outline-secondary waves-effect",
                },
                buttonsStyling: !1,
            })
                .then((result) => {
                    if (result.isConfirmed) {
                        // If confirmed, submit the request
                        bulkSelected('unblock');
                    }
                });
        });

        function bulkSelected(action) {
            var selectedRows = window.dataTable.rows({
                selected: true
            }).data();

            if (selectedRows.length > 0) {
                var ids = [];
                selectedRows.each(function (data) {
                    ids.push(data[
                        'id'
                    ]); // Assuming first column contains row ID (adjust if needed)
                });

                // Send selected IDs to Laravel controller in a single request
                $.ajax({
                    url: window.BulkURL, // Adjust the route to your bulk handler
                    method: 'POST',
                    data: {
                        _token: window.Token, // CSRF token
                        action: action,
                        ids: ids
                    },
                    success: function (response) {
                        // Handle success (e.g., reload table or notify user)
                        if (response.success) {
                            toastr.success(response.message, "", {
                                "closeButton": true,
                                "progressBar": true,
                                "positionClass": "toast-top-right",
                                "timeOut": 15000 // Time in ms
                            });

                            window.dataTable.rows({
                                selected: true
                            }).remove().draw();
                        } else {
                            toastr.error(response.message, "", {
                                "closeButton": true,
                                "progressBar": true,
                                "positionClass": "toast-top-right",
                                "timeOut": 15000 // Time in ms
                            });
                        }
                    },
                    error: function (xhr) {
                        // Handle error response
                        if (xhr.responseJSON) {
                            // Extract and display the message from the JSON response
                            var message = xhr.responseJSON.message;
                            toastr.error(message, "", {
                                "closeButton": true,
                                "progressBar": true,
                                "positionClass": "toast-top-right",
                                "timeOut": 15000 // Time in ms
                            });
                        } else {
                            toastr.error(__('messages.datatable.bulk.error'),
                                "", {
                                "closeButton": true,
                                "progressBar": true,
                                "positionClass": "toast-top-right",
                                "timeOut": 15000 // Time in ms
                            });
                        }
                    }
                });
            } else {
                alert('No rows selected');
            }
        }

    })();
});
