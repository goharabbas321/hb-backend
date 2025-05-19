/**
 *  Pages Authentication
 */

'use strict';
const formAuthentication = document.querySelector('#formAuthentication');

document.addEventListener('DOMContentLoaded', function (e) {
    (function () {
        // Form validation for Add new record
        if (formAuthentication) {
            const fv = FormValidation.formValidation(formAuthentication, {
                fields: {
                    username: {
                        validators: {
                            notEmpty: {
                                message: __('messages.login.validation.username_empty')
                            },
                            stringLength: {
                                min: 4,
                                message: __('messages.login.validation.username_length')
                            }
                        }
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: __('messages.login.validation.email_empty')
                            },
                            emailAddress: {
                                message: __('messages.login.validation.email_valid')
                            }
                        }
                    },
                    'email-username': {
                        validators: {
                            notEmpty: {
                                message: __('messages.login.validation.email_username_empty')
                            },
                            stringLength: {
                                min: 4,
                                message: __('messages.login.validation.email_username_length')
                            }
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: __('messages.login.validation.password_empty')
                            },
                            stringLength: {
                                min: 8,
                                message: __('messages.login.validation.password_length')
                            }
                        }
                    },
                    'password_confirmation': {
                        validators: {
                            notEmpty: {
                                message: __('messages.login.validation.password_confirmation_empty')
                            },
                            identical: {
                                compare: function () {
                                    return formAuthentication.querySelector('[name="password"]').value;
                                },
                                message: __('messages.login.validation.password_confirmation_same')
                            },
                            stringLength: {
                                min: 8,
                                message: __('messages.login.validation.password_confirmation_length')
                            }
                        }
                    },
                    terms: {
                        validators: {
                            notEmpty: {
                                message: __('messages.login.validation.terms_empty')
                            }
                        }
                    }
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

        //  Two Steps Verification
        const numeralMask = document.querySelectorAll('.numeral-mask');

        // Verification masking
        if (numeralMask.length) {
            numeralMask.forEach(e => {
                new Cleave(e, {
                    numeral: true
                });
            });
        }
    })();
});
