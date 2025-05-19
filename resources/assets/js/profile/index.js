/**
 * Profile
 */

'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
    (function () {
        const user_form = document.getElementById('user_form'),
            formChangePass = document.querySelector('#formAccountSettings'),
            twoFAEnable = document.querySelector('#otp_enable'),
            twoFADisable = document.querySelector('#otp_disable'),
            sessionForm = document.querySelector('#session_form'),
            country_select = jQuery(user_form.querySelector('[name="country"]')),
            language_select = jQuery(user_form.querySelector('[name="language"]')),
            currency_select = jQuery(user_form.querySelector('[name="currency"]')),
            time_zone_select = jQuery(user_form.querySelector('[name="time_zone"]'));

        let fv;

        // Form validation for User profile
        if (user_form) {
            fv = FormValidation.formValidation(user_form, {
                fields: {
                    username: {
                        validators: {
                            notEmpty: {
                                message: __('messages.profile.information.validation.username_empty')
                            },
                            stringLength: {
                                min: 4,
                                max: 12,
                                message: __('messages.profile.information.validation.username_length')
                            },
                            regexp: {
                                regexp: /^[a-zA-Z0-9_]+$/,
                                message: __('messages.profile.information.validation.username_regex')
                            }
                        }
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: __('messages.profile.information.validation.email_empty')
                            },
                            emailAddress: {
                                message: __('messages.profile.information.validation.email_valid')
                            }
                        }
                    },
                    name: {
                        validators: {
                            notEmpty: {
                                message: __('messages.profile.information.validation.name_empty')
                            },
                            stringLength: {
                                min: 6,
                                max: 30,
                                message: __('messages.profile.information.validation.name_length')
                            },
                            regexp: {
                                regexp: /^[a-zA-Z\u0600-\u06FF\s]+$/,
                                message: __('messages.profile.information.validation.name_regex')
                            }
                        }
                    },
                    phone: {
                        validators: {
                            notEmpty: {
                                message: __('messages.profile.information.validation.phone_empty')
                            },
                            regexp: {
                                regexp: /^\d{11}$/,
                                message: __('messages.profile.information.validation.phone_length')
                            }
                        }
                    },
                    country: {
                        validators: {
                            notEmpty: {
                                message: __('messages.profile.information.validation.country_empty')
                            }
                        }
                    },
                    address: {
                        validators: {
                            notEmpty: {
                                message: __('messages.profile.information.validation.address_empty')
                            }
                        }
                    },
                    language: {
                        validators: {
                            notEmpty: {
                                message: __('messages.profile.information.validation.language_empty')
                            }
                        }
                    },
                    currency: {
                        validators: {
                            notEmpty: {
                                message: __('messages.profile.information.validation.currency_empty')
                            }
                        }
                    },
                    time_zone: {
                        validators: {
                            notEmpty: {
                                message: __('messages.profile.information.validation.time_zone_empty')
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
                                confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                                cancelButton: 'btn btn-outline-secondary waves-effect'
                            },
                            buttonsStyling: !1
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
        }

        // Form validation for Change password
        if (formChangePass) {
            fv = FormValidation.formValidation(formChangePass, {
                fields: {
                    currentPassword: {
                        validators: {
                            notEmpty: {
                                message: __('messages.profile.change_password.validation.current_password_empty')
                            },
                            stringLength: {
                                min: 8,
                                message: __('messages.profile.change_password.validation.current_password_length')
                            }
                        }
                    },
                    newPassword: {
                        validators: {
                            notEmpty: {
                                message: __('messages.profile.change_password.validation.new_password_empty')
                            },
                            stringLength: {
                                min: 8,
                                message: __('messages.profile.change_password.validation.new_password_length')
                            }
                        }
                    },
                    newPassword_confirmation: {
                        validators: {
                            notEmpty: {
                                message: __('messages.profile.change_password.validation.confirm_password_empty')
                            },
                            identical: {
                                compare: function () {
                                    return formChangePass.querySelector('[name="newPassword"]').value;
                                },
                                message: __('messages.profile.change_password.validation.confirm_password_same')
                            },
                            stringLength: {
                                min: 8,
                                message: __('messages.profile.change_password.validation.confirm_password_length')
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
                                case 'currentPassword':
                                case 'newPassword':
                                case 'newPassword_confirmation':
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
                                document.getElementById('formAccountSettings').submit(); // Programmatically submit the form
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

        // Form validation for 2FA Enable
        if (twoFAEnable) {
            fv = FormValidation.formValidation(twoFAEnable, {
                fields: {
                    otp: {
                        validators: {
                            notEmpty: {
                                message: __('messages.profile.2fa.validation.otp_empty'),
                            },
                            regexp: {
                                regexp: /^\d{6}$/,
                                message: __('messages.profile.2fa.validation.otp_length')
                            },
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap5: new FormValidation.plugins.Bootstrap5({
                        eleValidClass: '',
                        rowSelector: '.mb-6'
                    }),
                    submitButton: new FormValidation.plugins.SubmitButton(),

                    defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                    autoFocus: new FormValidation.plugins.AutoFocus()
                },
                init: instance => {
                    instance.on('plugins.message.placed', function (e) {
                        if (e.element.parentElement.classList.contains('input-group')) {
                            e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
                        }
                    });
                }
            });
        }

        // Form validation for 2FA Disable
        if (twoFADisable) {
            fv = FormValidation.formValidation(twoFADisable, {
                fields: {
                    password: {
                        validators: {
                            notEmpty: {
                                message: __('messages.profile.2fa.validation.password_empty'),
                            },
                            stringLength: {
                                min: 8,
                                message: __('messages.profile.2fa.validation.password_length')
                            }
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap5: new FormValidation.plugins.Bootstrap5({
                        eleValidClass: '',
                        rowSelector: '.mb-6'
                    }),
                    submitButton: new FormValidation.plugins.SubmitButton(),

                    defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                    autoFocus: new FormValidation.plugins.AutoFocus()
                },
                init: instance => {
                    instance.on('plugins.message.placed', function (e) {
                        if (e.element.parentElement.classList.contains('input-group')) {
                            e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
                        }
                    });
                }
            });
        }

        // Form validation for Session Form
        if (sessionForm) {
            fv = FormValidation.formValidation(sessionForm, {
                fields: {
                    password: {
                        validators: {
                            notEmpty: {
                                message: __('messages.profile.sessions.validation.password_empty'),
                            },
                            stringLength: {
                                min: 8,
                                message: __('messages.profile.sessions.validation.password_length')
                            }
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap5: new FormValidation.plugins.Bootstrap5({
                        eleValidClass: '',
                        rowSelector: '.mb-6'
                    }),
                    submitButton: new FormValidation.plugins.SubmitButton(),

                    defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                    autoFocus: new FormValidation.plugins.AutoFocus()
                },
                init: instance => {
                    instance.on('plugins.message.placed', function (e) {
                        if (e.element.parentElement.classList.contains('input-group')) {
                            e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
                        }
                    });
                }
            });
        }

        //? Revalidation third-party libs inputs on change trigger

        // Select2 (Country)
        if (country_select.length) {
            country_select.wrap('<div class="position-relative"></div>');
            country_select
                .select2({
                    placeholder: __('messages.profile.information.validation.country_select'),
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
                    placeholder: __('messages.profile.information.validation.language_select'),
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
                    placeholder: __('messages.profile.information.validation.currency_select'),
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
                    placeholder: __('messages.profile.information.validation.time_zone_select'),
                    dropdownParent: time_zone_select.parent()
                })
                .on('change', function () {
                    // Revalidate the color field when an option is chosen
                    fv.revalidateField('time_zone');
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

    })();
});
