'use strict';

import __ from '../../../../i18n_module';
import Swal from "sweetalert2";

document.addEventListener('DOMContentLoaded', function (e) {
    (function () {
        const doctor_form = document.getElementById('doctor_form'),
            hospital_select = jQuery(doctor_form.querySelector('[name="hospital_id"]')),
            specialization_select = jQuery(doctor_form.querySelector('[name="specialization_id"]'));

        const fv = FormValidation.formValidation(doctor_form, {
            fields: {
                name_en: {
                    validators: {
                        notEmpty: {
                            message: __('doctors.validation.name_en_empty')
                        },
                        stringLength: {
                            min: 3,
                            max: 255,
                            message: __('doctors.validation.name_en_length')
                        }
                    }
                },
                name_ar: {
                    validators: {
                        notEmpty: {
                            message: __('doctors.validation.name_ar_empty')
                        },
                        stringLength: {
                            min: 3,
                            max: 255,
                            message: __('doctors.validation.name_ar_length')
                        }
                    }
                },
                hospital_id: {
                    validators: {
                        notEmpty: {
                            message: __('doctors.validation.hospital_empty')
                        }
                    }
                },
                specialization_id: {
                    validators: {
                        notEmpty: {
                            message: __('doctors.validation.specialization_empty')
                        }
                    }
                },
                profile_picture: {
                    validators: {
                        file: {
                            extension: 'jpg,jpeg,png',
                            type: 'image/jpeg,image/png',
                            maxSize: 2097152, // 2MB
                            message: __('doctors.validation.image_invalid')
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    eleValidClass: '',
                    rowSelector: function (field, ele) {
                        switch (field) {
                            case 'name_en':
                            case 'name_ar':
                            case 'hospital_id':
                            case 'specialization_id':
                            case 'bio_en':
                            case 'bio_ar':
                            case 'profile_picture':
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
                            document.getElementById('doctor_form').submit();
                        }
                    });
                });

                instance.on('plugins.message.placed', function (e) {
                    // Move the error message out of the `input-group` element
                    if (e.element.parentElement.classList.contains('input-group')) {
                        e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
                    }
                    // Move the error message out of the `row` element for custom-options
                    if (e.element.parentElement.parentElement.classList.contains('custom-option')) {
                        e.element.closest('.row').insertAdjacentElement('afterend', e.messageElement);
                    }
                });
            }
        });

        // Select2 initialization
        if (hospital_select.length) {
            hospital_select.wrap('<div class="position-relative"></div>');
            hospital_select
                .select2({
                    placeholder: __('doctors.validation.hospital_select'),
                    dropdownParent: hospital_select.parent()
                })
                .on('change', function () {
                    fv.revalidateField('hospital_id');
                });
        }

        if (specialization_select.length) {
            specialization_select.wrap('<div class="position-relative"></div>');
            specialization_select
                .select2({
                    placeholder: __('doctors.validation.specialization_select'),
                    dropdownParent: specialization_select.parent()
                })
                .on('change', function () {
                    fv.revalidateField('specialization_id');
                });
        }

        // Doctor profile picture preview
        let doctorImage = document.getElementById('uploadedImage');
        const fileInput = document.querySelector('.doctor-file-input'),
            resetFileInput = document.querySelector('.doctor-image-reset');

        if (doctorImage) {
            const resetImage = doctorImage.src;
            fileInput.onchange = () => {
                if (fileInput.files[0]) {
                    doctorImage.src = window.URL.createObjectURL(fileInput.files[0]);
                }
            };
            resetFileInput.onclick = () => {
                fileInput.value = '';
                doctorImage.src = resetImage;
            };
        }
    })();
});
