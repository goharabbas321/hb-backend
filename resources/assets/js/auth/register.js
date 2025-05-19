'use strict';

import Swal from "sweetalert2";

document.addEventListener('DOMContentLoaded', function (e) {
    (function () {
        const user_form = document.getElementById('user_form'),
            country_select = jQuery(user_form.querySelector('[name="country"]')),
            language_select = jQuery(user_form.querySelector('[name="language"]')),
            currency_select = jQuery(user_form.querySelector('[name="currency"]')),
            time_zone_select = jQuery(user_form.querySelector('[name="time_zone"]'));

        const fv = FormValidation.formValidation(user_form, {
            fields: {
                username: {
                    validators: {
                        notEmpty: {
                            message: __('messages.registration.validation.username_empty')
                        },
                        stringLength: {
                            min: 4,
                            max: 12,
                            message: __('messages.registration.validation.username_length')
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9_]+$/,
                            message: __('messages.registration.validation.username_regex')
                        }
                    }
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: __('messages.registration.validation.email_empty')
                        },
                        emailAddress: {
                            message: __('messages.registration.validation.email_valid')
                        }
                    }
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: __('messages.registration.validation.password_empty')
                        },
                        stringLength: {
                            min: 8,
                            message: __('messages.registration.validation.password_length')
                        }
                    }
                },
                password_confirmation: {
                    validators: {
                        notEmpty: {
                            message: __('messages.registration.validation.password_confirmation_empty')
                        },
                        identical: {
                            compare: function () {
                                return user_form.querySelector('[name="password"]').value;
                            },
                            message: __('messages.registration.validation.password_confirmation_same')
                        }
                    }
                },
                terms: {
                    validators: {
                        notEmpty: {
                            message: __('messages.registration.validation.terms_empty')
                        }
                    }
                },
                name: {
                    validators: {
                        notEmpty: {
                            message: __('messages.registration.validation.name_empty')
                        },
                        stringLength: {
                            min: 6,
                            max: 30,
                            message: __('messages.registration.validation.name_length')
                        },
                        regexp: {
                            regexp: /^[a-zA-Z\u0600-\u06FF\s]+$/,
                            message: __('messages.registration.validation.name_regex')
                        }
                    }
                },
                phone: {
                    validators: {
                        notEmpty: {
                            message: __('messages.registration.validation.phone_empty')
                        },
                        regexp: {
                            regexp: /^\d{11}$/,
                            message: __('messages.registration.validation.phone_length')
                        }
                    }
                },
                country: {
                    validators: {
                        notEmpty: {
                            message: __('messages.registration.validation.country_empty')
                        }
                    }
                },
                address: {
                    validators: {
                        notEmpty: {
                            message: __('messages.registration.validation.address_empty')
                        }
                    }
                },
                language: {
                    validators: {
                        notEmpty: {
                            message: __('messages.registration.validation.language_empty')
                        }
                    }
                },
                currency: {
                    validators: {
                        notEmpty: {
                            message: __('messages.registration.validation.currency_empty')
                        }
                    }
                },
                time_zone: {
                    validators: {
                        notEmpty: {
                            message: __('messages.registration.validation.time_zone_empty')
                        }
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
                            case 'username':
                            case 'email':
                            case 'password':
                            case 'password_confirmation':
                            case 'terms':
                            case 'name':
                            case 'phone':
                            case 'country':
                            case 'address':
                            case 'language':
                            case 'currency':
                            case 'timezone':
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
                    placeholder: __('messages.registration.validation.country_select'),
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
                    placeholder: __('messages.registration.validation.language_select'),
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
                    placeholder: __('messages.registration.validation.currency_select'),
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
                    placeholder: __('messages.registration.validation.time_zone_select'),
                    dropdownParent: time_zone_select.parent()
                })
                .on('change', function () {
                    // Revalidate the color field when an option is chosen
                    fv.revalidateField('time_zone');
                });
        }
    })();
});
