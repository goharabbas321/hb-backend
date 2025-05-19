'use strict';

import __ from '../../../../i18n_module';
import Swal from "sweetalert2";

document.addEventListener('DOMContentLoaded', function (e) {
    (function () {
        const hospital_form = document.getElementById('hospital_form'),
            city_select = jQuery(hospital_form.querySelector('[name="city_id"]')),
            specialization_select = jQuery(hospital_form.querySelector('[name="specializations[]"]')),
            facility_select = jQuery(hospital_form.querySelector('[name="facilities[]"]'));

        const fv = FormValidation.formValidation(hospital_form, {
            fields: {
                name_en: {
                    validators: {
                        notEmpty: {
                            message: __('hospitals.validation.name_en_empty')
                        },
                        stringLength: {
                            min: 3,
                            max: 255,
                            message: __('hospitals.validation.name_en_length')
                        }
                    }
                },
                name_ar: {
                    validators: {
                        notEmpty: {
                            message: __('hospitals.validation.name_ar_empty')
                        },
                        stringLength: {
                            min: 3,
                            max: 255,
                            message: __('hospitals.validation.name_ar_length')
                        }
                    }
                },
                city_id: {
                    validators: {
                        notEmpty: {
                            message: __('hospitals.validation.city_empty')
                        }
                    }
                },
                address_en: {
                    validators: {
                        notEmpty: {
                            message: __('hospitals.validation.address_en_empty')
                        }
                    }
                },
                address_ar: {
                    validators: {
                        notEmpty: {
                            message: __('hospitals.validation.address_ar_empty')
                        }
                    }
                },
                contact_en: {
                    validators: {
                        notEmpty: {
                            message: __('hospitals.validation.contact_en_empty')
                        }
                    }
                },
                contact_ar: {
                    validators: {
                        notEmpty: {
                            message: __('hospitals.validation.contact_ar_empty')
                        }
                    }
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: __('hospitals.validation.email_empty')
                        },
                        emailAddress: {
                            message: __('hospitals.validation.email_valid')
                        }
                    }
                },
                website: {
                    validators: {
                        uri: {
                            message: __('hospitals.validation.website_valid')
                        }
                    }
                },
                working_hours_en: {
                    validators: {
                        notEmpty: {
                            message: __('hospitals.validation.working_hours_en_empty')
                        }
                    }
                },
                working_hours_ar: {
                    validators: {
                        notEmpty: {
                            message: __('hospitals.validation.working_hours_ar_empty')
                        }
                    }
                },
                image: {
                    validators: {
                        file: {
                            extension: 'jpg,jpeg,png',
                            type: 'image/jpeg,image/png',
                            maxSize: 2097152, // 2MB
                            message: __('hospitals.validation.image_invalid')
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
                            case 'name_en':
                            case 'name_ar':
                            case 'city_id':
                            case 'address_en':
                            case 'address_ar':
                            case 'contact_en':
                            case 'contact_ar':
                            case 'email':
                            case 'website':
                            case 'working_hours_en':
                            case 'working_hours_ar':
                            case 'description_en':
                            case 'description_ar':
                            case 'image':
                            case 'specializations[]':
                            case 'facilities[]':
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
                            document.getElementById('hospital_form').submit();
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
        if (city_select.length) {
            city_select.wrap('<div class="position-relative"></div>');
            city_select
                .select2({
                    placeholder: __('hospitals.validation.city_select'),
                    dropdownParent: city_select.parent()
                })
                .on('change', function () {
                    fv.revalidateField('city_id');
                });
        }

        if (specialization_select.length) {
            let isEditPage = window.location.href.includes('/edit');
            let storedWorkingDays = {};

            // If on edit page, collect all the existing working days data
            if (isEditPage) {
                document.querySelectorAll('.working-days-data').forEach(el => {
                    const id = el.getAttribute('data-specialization-id');
                    const days = JSON.parse(el.getAttribute('data-working-days') || '[]');
                    storedWorkingDays[id] = days;
                });
            }

            specialization_select.wrap('<div class="position-relative"></div>');
            specialization_select
                .select2({
                    placeholder: __('hospitals.validation.specialization_select'),
                    dropdownParent: specialization_select.parent()
                })
                .on('change', function (e) {
                    // Handle booking limit fields and working days when specializations change
                    const bookingLimitsContainer = document.getElementById('booking-limits-container');
                    const workingDaysContainer = document.getElementById('working-days-container');

                    if (bookingLimitsContainer && workingDaysContainer) {
                        // Clear the containers
                        bookingLimitsContainer.innerHTML = '';
                        workingDaysContainer.innerHTML = '';

                        // Get selected options
                        const selectedOptions = specialization_select.select2('data');
                        if (selectedOptions.length > 0) {
                            selectedOptions.forEach(option => {
                                const specializationId = option.id;
                                const specializationName = option.text;
                                let bookingLimit = 40; // Default value
                                let workingDays = []; // Default value

                                // Check if we have stored working days for this specialization (from database)
                                if (isEditPage && storedWorkingDays[specializationId]) {
                                    workingDays = storedWorkingDays[specializationId];
                                }

                                // Check if this specialization had a previous value set
                                const existingBookingItem = document.querySelector(`.booking-limit-item[data-specialization-id="${specializationId}"]`);
                                if (existingBookingItem) {
                                    const input = existingBookingItem.querySelector('input');
                                    if (input) {
                                        bookingLimit = input.value;
                                    }
                                }

                                // Check if this specialization had previous working days set in this session
                                const existingWorkingDaysItem = document.querySelector(`.working-days-item[data-specialization-id="${specializationId}"]`);
                                if (existingWorkingDaysItem) {
                                    const inputs = existingWorkingDaysItem.querySelectorAll('input:checked');
                                    if (inputs.length) {
                                        workingDays = [];
                                        inputs.forEach(input => {
                                            workingDays.push(input.value);
                                        });
                                    }
                                }

                                // Check data-booking-limit attribute on the option
                                const optionElement = specialization_select.find(`option[value="${specializationId}"]`)[0];
                                if (optionElement && optionElement.dataset.bookingLimit) {
                                    bookingLimit = optionElement.dataset.bookingLimit;
                                }

                                // Create booking limit field for the selected specialization
                                const bookingLimitItem = document.createElement('div');
                                bookingLimitItem.className = 'mb-2 booking-limit-item';
                                bookingLimitItem.setAttribute('data-specialization-id', specializationId);

                                bookingLimitItem.innerHTML = `
                                    <label class="form-label">${specializationName} ${__('hospitals.field.label_booking_limit')}</label>
                                    <input type="number" class="form-control" name="booking_limit[${specializationId}]"
                                        value="${bookingLimit}" min="1" placeholder="40">
                                `;

                                bookingLimitsContainer.appendChild(bookingLimitItem);

                                // Create working days field for the selected specialization
                                const workingDaysItem = document.createElement('div');
                                workingDaysItem.className = 'mb-3 working-days-item';
                                workingDaysItem.setAttribute('data-specialization-id', specializationId);

                                const workingDaysLabel = document.createElement('label');
                                workingDaysLabel.className = 'form-label';
                                workingDaysLabel.textContent = `${specializationName} Working Days - أيام العمل`;

                                workingDaysItem.appendChild(workingDaysLabel);

                                const daysContainer = document.createElement('div');
                                daysContainer.className = 'd-flex flex-wrap gap-2';

                                // Add checkboxes for each day
                                const days = {
                                    'monday': 'Monday - الاثنين',
                                    'tuesday': 'Tuesday - الثلاثاء',
                                    'wednesday': 'Wednesday - الأربعاء',
                                    'thursday': 'Thursday - الخميس',
                                    'friday': 'Friday - الجمعة',
                                    'saturday': 'Saturday - السبت',
                                    'sunday': 'Sunday - الأحد'
                                };

                                Object.keys(days).forEach(dayValue => {
                                    const dayLabel = days[dayValue];

                                    const dayCheckbox = document.createElement('div');
                                    dayCheckbox.className = 'form-check';

                                    // For create mode, all days are checked by default
                                    // For edit mode, only check days that are in the database or were selected in this session
                                    const isNewSpecialization = !isEditPage && workingDays.length === 0;
                                    const isChecked = isNewSpecialization ? true : workingDays.includes(dayValue);

                                    dayCheckbox.innerHTML = `
                                        <input class="form-check-input" type="checkbox"
                                            id="day_${specializationId}_${dayValue}"
                                            name="working_days[${specializationId}][]"
                                            value="${dayValue}"
                                            ${isChecked ? 'checked' : ''}>
                                        <label class="form-check-label"
                                            for="day_${specializationId}_${dayValue}">
                                            ${dayLabel}
                                        </label>
                                    `;

                                    daysContainer.appendChild(dayCheckbox);
                                });

                                workingDaysItem.appendChild(daysContainer);
                                workingDaysContainer.appendChild(workingDaysItem);
                            });
                        }
                    }
                });

            // Trigger change event to initialize booking limit fields
            setTimeout(() => {
                if (specialization_select.val() && specialization_select.val().length > 0) {
                    specialization_select.trigger('change');
                }
            }, 500);
        }

        if (facility_select.length) {
            facility_select.wrap('<div class="position-relative"></div>');
            facility_select
                .select2({
                    placeholder: __('hospitals.validation.facility_select'),
                    dropdownParent: facility_select.parent()
                });
        }

        // Hospital image preview
        let hospitalImage = document.getElementById('uploadedImage');
        const fileInput = document.querySelector('.hospital-file-input'),
            resetFileInput = document.querySelector('.hospital-image-reset');

        if (hospitalImage) {
            const resetImage = hospitalImage.src;
            fileInput.onchange = () => {
                if (fileInput.files[0]) {
                    hospitalImage.src = window.URL.createObjectURL(fileInput.files[0]);
                }
            };
            resetFileInput.onclick = () => {
                fileInput.value = '';
                hospitalImage.src = resetImage;
            };
        }
    })();
});
