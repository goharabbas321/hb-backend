'use strict';

import __ from '../../../../i18n_module';
import Swal from "sweetalert2";

document.addEventListener('DOMContentLoaded', function (e) {
    (function () {
        const type_select = jQuery(document.getElementById('addForm').querySelector('[name="type"]'));
        // add role form validation
        var fv = FormValidation.formValidation(document.getElementById('addForm'), {
            fields: {
                permissionName: {
                    validators: {
                        notEmpty: {
                            message: __('permissions.validation.permission_name_empty')
                        }
                    }
                },
                type: {
                    validators: {
                        notEmpty: {
                            message: __('permissions.validation.type_select')
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
                            document.getElementById('addForm').submit(); // Programmatically submit the form
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

        const roles_select = jQuery(document.getElementById('addForm').querySelector('[name="roles[]"]'));
        // Select2 (Country)
        if (roles_select.length) {
            roles_select.wrap('<div class="position-relative"></div>');
            roles_select
                .select2({
                    placeholder: __('permissions.validation.roles_select'),
                    dropdownParent: roles_select.parent()
                })
                .on('change', function () {
                    // Revalidate the color field when an option is chosen
                    fv.revalidateField('roles[]');
                });
        }

        // Select2 (Type)
        if (type_select.length) {
            type_select.wrap('<div class="position-relative"></div>');
            type_select
                .select2({
                    placeholder: __('permissions.validation.type_select'),
                    dropdownParent: type_select.parent()
                })
                .on('change', function () {
                    // Revalidate the color field when an option is chosen
                    fv.revalidateField('type');
                });
        }

    })();
});
