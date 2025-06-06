/**
 *  Page auth two steps
 */

'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
    (function () {
        let maskWrapper = document.querySelector('.numeral-mask-wrapper');

        for (let pin of maskWrapper.children) {
            pin.onkeyup = function (e) {
                // Check if the key pressed is a number (0-9)
                if (/^\d$/.test(e.key)) {
                    // While entering value, go to next
                    if (pin.nextElementSibling) {
                        if (this.value.length === parseInt(this.attributes['maxlength'].value)) {
                            pin.nextElementSibling.focus();
                        }
                    }
                } else if (e.key === 'Backspace') {
                    // While deleting entered value, go to previous
                    if (pin.previousElementSibling) {
                        pin.previousElementSibling.focus();
                    }
                }
            };
            // Prevent the default behavior for the minus key
            pin.onkeypress = function (e) {
                if (e.key === '-') {
                    e.preventDefault();
                }
            };
        }

        const twoStepsForm = document.querySelector('#twoStepsForm');

        // Form validation for OTP Code
        if (twoStepsForm) {
            const fv = FormValidation.formValidation(twoStepsForm, {
                fields: {
                    code: {
                        validators: {
                            notEmpty: {
                                message: __('messages.2fa.validation.code_empty')
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
                }
            });

            const numeralMaskList = twoStepsForm.querySelectorAll('.numeral-mask');
            const keyupHandler = function () {
                let otpFlag = true,
                    otpVal = '';
                numeralMaskList.forEach(numeralMaskEl => {
                    if (numeralMaskEl.value === '') {
                        otpFlag = false;
                        twoStepsForm.querySelector('[name="code"]').value = '';
                    }
                    otpVal = otpVal + numeralMaskEl.value;
                });
                if (otpFlag) {
                    twoStepsForm.querySelector('[name="code"]').value = otpVal;
                }
            };
            numeralMaskList.forEach(numeralMaskEle => {
                numeralMaskEle.addEventListener('keyup', keyupHandler);
            });
        }

        const recoveryForm = document.querySelector('#recoveryCodeForm');

        // Form validation for Recovery Code
        if (recoveryForm) {
            const fv = FormValidation.formValidation(recoveryForm, {
                fields: {
                    recovery_code: {
                        validators: {
                            notEmpty: {
                                message: __('messages.2fa.validation.recovery_code_empty')
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

    })();
});
