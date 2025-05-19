'use strict';

import __ from '../../../../i18n_module';
import Swal from "sweetalert2";

document.addEventListener('DOMContentLoaded', function (e) {
    (function () {
        // add role form validation
        FormValidation.formValidation(document.getElementById('addRoleForm'), {
            fields: {
                roleName: {
                    validators: {
                        notEmpty: {
                            message: __('roles.validation.role_name_empty')
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
                    rowSelector: '.col-12'
                }),
                submitButton: new FormValidation.plugins.SubmitButton(),
                // Submit the form when all fields are valid
                //defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
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
                            document.getElementById('addRoleForm').submit(); // Programmatically submit the form
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

        // Select All checkbox click
        const selectAll = document.querySelector('#selectAll'),
            checkboxList = document.querySelectorAll('[type="checkbox"]');
        selectAll.addEventListener('change', t => {
            checkboxList.forEach(e => {
                e.checked = t.target.checked;
            });
        });
    })();
});
