'use strict';

import __ from '../../../../i18n_module';
import Swal from "sweetalert2";

document.addEventListener('DOMContentLoaded', function (e) {
    (function () {
        const facility_form = document.getElementById('facility_form');

        if (facility_form) {
            const fv = FormValidation.formValidation(facility_form, {
                fields: {
                    name_en: {
                        validators: {
                            notEmpty: {
                                message: __('facilities.validation.name_en_empty')
                            },
                            stringLength: {
                                min: 3,
                                max: 255,
                                message: __('facilities.validation.name_en_length')
                            }
                        }
                    },
                    name_ar: {
                        validators: {
                            notEmpty: {
                                message: __('facilities.validation.name_ar_empty')
                            },
                            stringLength: {
                                min: 3,
                                max: 255,
                                message: __('facilities.validation.name_ar_length')
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap5: new FormValidation.plugins.Bootstrap5({
                        eleValidClass: '',
                        rowSelector: function (field, ele) {
                            return '.row';
                        }
                    }),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    autoFocus: new FormValidation.plugins.AutoFocus()
                },
                init: instance => {
                    // Handle what happens after validation passes
                    instance.on('core.form.valid', function () {
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
                                document.getElementById('facility_form').submit();
                            }
                        });
                    });
                }
            });
        }
    })();
});
