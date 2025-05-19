'use strict';

import __ from '../../../../i18n_module';
import Swal from "sweetalert2";

document.addEventListener('DOMContentLoaded', function (e) {
    // Appointment form handling (for both create and edit)
    (function () {
        // Initialize flatpickr for date picker in create form
        const appointmentCreateDate = document.querySelector('#add-new-record #appointment_date');
        if (appointmentCreateDate) {
            flatpickr(appointmentCreateDate, {
                dateFormat: "Y-m-d",
                minDate: "today",
                onChange: function (selectedDates, dateStr) {
                    console.log('Date selected:', dateStr); // Debug log
                    updateBookingNumber('add-new-record');
                }
            });
        }

        // Initialize flatpickr for date picker in edit form
        const appointmentEditDate = document.querySelector('#appointment_edit_form #appointment_date');
        if (appointmentEditDate) {
            flatpickr(appointmentEditDate, {
                dateFormat: "Y-m-d",
                minDate: "today",
                onChange: function (selectedDates, dateStr) {
                    console.log('Edit form date selected:', dateStr); // Debug log
                    updateBookingNumber('appointment_edit_form');
                }
            });
        }

        // Function to update booking number based on hospital, specialization and date selection
        function updateBookingNumber(formId) {
            const form = document.getElementById(formId);
            if (!form) {
                console.error('Form not found:', formId);
                return;
            }

            const hospitalId = form.querySelector('#hospital_id').value;
            const specializationId = form.querySelector('#specialization_id').value;
            const dateField = form.querySelector('#appointment_date');
            const bookingNumberField = form.querySelector('#appointment_number');

            console.log('Update booking number called with:', {
                formId,
                hospitalId,
                specializationId,
                date: dateField ? dateField.value : 'null',
            });

            // Only proceed if hospital, specialization, and date are all selected
            if (hospitalId && specializationId && dateField && dateField.value) {
                const selectedDate = dateField.value;

                // Show loading indicator
                if (bookingNumberField) {
                    bookingNumberField.disabled = true;
                    bookingNumberField.placeholder = 'Loading...';
                }

                // Make AJAX call to backend to check availability and get booking number
                const csrfToken = document.querySelector('meta[name="csrf-token"]')
                    ? document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    : '';

                console.log('Making API request to check availability with specialization ID:', specializationId);

                // Use JSON payload instead of FormData
                fetch('/api/check-appointment-availability', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        hospital_id: hospitalId,
                        date: selectedDate,
                        specialization_id: specializationId
                    })
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('API response:', data); // Debug log

                        if (data.success && bookingNumberField) {
                            // If booking number is provided, use it
                            if (data.booking_number !== null) {
                                bookingNumberField.value = data.booking_number;

                                // Check if the date has been changed due to availability
                                if (data.date && data.date !== selectedDate) {
                                    // Update the date field with the new date
                                    dateField._flatpickr.setDate(data.date);

                                    // Notify the user about the date change
                                    Swal.fire({
                                        title: 'Date Changed',
                                        text: data.message || 'The requested date was unavailable. You have been booked for the next available date.',
                                        icon: 'info',
                                        customClass: {
                                            confirmButton: "btn btn-primary waves-effect waves-light"
                                        },
                                        buttonsStyling: false
                                    });
                                } else if (data.message && data.message.includes("working day")) {
                                    // Show info about working days
                                    Swal.fire({
                                        title: 'Appointment Available',
                                        text: data.message,
                                        icon: 'success',
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 5000,
                                        timerProgressBar: true
                                    });
                                }
                            }
                            // If auto booking is enabled (booking_number is null), generate a temporary number
                            else if (data.message && data.message.includes("Auto booking is enabled")) {
                                // For auto booking hospitals, let's fetch the current count of appointments for this date
                                fetch('/api/get-appointment-count', {
                                    method: 'POST',
                                    headers: {
                                        'Accept': 'application/json',
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': csrfToken
                                    },
                                    body: JSON.stringify({
                                        hospital_id: hospitalId,
                                        date: selectedDate,
                                        specialization_id: specializationId
                                    })
                                })
                                    .then(response => response.json())
                                    .then(countData => {
                                        // Set booking number to count + 1 as a placeholder
                                        if (countData.success) {
                                            bookingNumberField.value = countData.count + 1;
                                        } else {
                                            // If count API fails, just set to 1 as fallback
                                            bookingNumberField.value = 1;
                                        }
                                    })
                                    .catch(() => {
                                        // If API call fails, set to 1 as fallback
                                        bookingNumberField.value = 1;
                                    });

                                // Show message about auto booking
                                Swal.fire({
                                    title: 'Auto Booking',
                                    text: 'This hospital uses auto booking. The system will assign the final booking number.',
                                    icon: 'info',
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 5000,
                                    timerProgressBar: true
                                });
                            }

                            // If there's any message to show
                            if (data.message && !data.message.includes("Auto booking") && !data.message.includes("working day")) {
                                console.log('API message:', data.message);

                                // Show general message as toast
                                Swal.fire({
                                    title: 'Appointment Information',
                                    text: data.message,
                                    icon: 'info',
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 5000,
                                    timerProgressBar: true
                                });
                            }
                        } else if (data.message) {
                            // Show error message for no available slots or not a working day
                            Swal.fire({
                                title: 'Appointment Unavailable',
                                text: data.message,
                                icon: 'warning',
                                customClass: {
                                    confirmButton: "btn btn-primary waves-effect waves-light"
                                },
                                buttonsStyling: false
                            });

                            // Clear the booking number field
                            bookingNumberField.value = '';
                        }
                    })
                    .catch(error => {
                        console.error('Error checking appointment availability:', error);

                        // Show error message
                        Swal.fire({
                            title: __('alert.error_alert.title'),
                            text: error.message || __('appointments.validation.availability_check_failed'),
                            icon: 'error',
                            customClass: {
                                confirmButton: "btn btn-primary waves-effect waves-light"
                            },
                            buttonsStyling: false
                        });
                    })
                    .finally(() => {
                        if (bookingNumberField) {
                            bookingNumberField.disabled = false;
                            bookingNumberField.placeholder = '';
                        }
                    });
            } else {
                console.log('Missing hospital ID, specialization ID, or date value');
                if (bookingNumberField) {
                    // Clear the booking number if any required field is not selected
                    bookingNumberField.value = '';
                }
            }
        }

        // Trigger booking number update when hospital changes
        const hospitalCreateSelect = document.querySelector('#add-new-record #hospital_id');
        if (hospitalCreateSelect) {
            $(hospitalCreateSelect).on('change', function () {
                console.log('Hospital changed:', this.value); // Debug log
                updateBookingNumber('add-new-record');
            });
        }

        const hospitalEditSelect = document.querySelector('#appointment_edit_form #hospital_id');
        if (hospitalEditSelect) {
            $(hospitalEditSelect).on('change', function () {
                console.log('Edit form hospital changed:', this.value); // Debug log
                updateBookingNumber('appointment_edit_form');
            });
        }

        // Trigger booking number update when specialization changes
        const specializationCreateSelect = document.querySelector('#add-new-record #specialization_id');
        if (specializationCreateSelect) {
            $(specializationCreateSelect).on('change', function () {
                console.log('Specialization changed:', this.value); // Debug log
                updateBookingNumber('add-new-record');
            });
        }

        const specializationEditSelect = document.querySelector('#appointment_edit_form #specialization_id');
        if (specializationEditSelect) {
            $(specializationEditSelect).on('change', function () {
                console.log('Edit form specialization changed:', this.value); // Debug log
                updateBookingNumber('appointment_edit_form');
            });
        }

        // Also add manual trigger for date field changes (backup in case flatpickr onChange doesn't work)
        $('#add-new-record #appointment_date').on('change', function () {
            console.log('Date changed manually:', this.value); // Debug log
            updateBookingNumber('add-new-record');
        });

        $('#appointment_edit_form #appointment_date').on('change', function () {
            console.log('Edit form date changed manually:', this.value); // Debug log
            updateBookingNumber('appointment_edit_form');
        });

        // Select2 initialization for create form
        const hospitalSelect = document.querySelector('#add-new-record #hospital_id');
        const specializationSelect = document.querySelector('#add-new-record #specialization_id');
        const userSelect = document.querySelector('#add-new-record #user_id');
        const statusSelect = document.querySelector('#add-new-record #status');

        if (hospitalSelect) {
            $(hospitalSelect).select2({
                dropdownParent: $('#add-new-record'),
                placeholder: __('appointments.select.hospital'),
                allowClear: true
            });
        }

        if (specializationSelect) {
            $(specializationSelect).select2({
                dropdownParent: $('#add-new-record'),
                placeholder: __('appointments.select.specialization'),
                allowClear: true
            });
        }

        if (userSelect) {
            $(userSelect).select2({
                dropdownParent: $('#add-new-record'),
                placeholder: __('appointments.select.patient'),
                allowClear: true
            });
        }

        if (statusSelect) {
            $(statusSelect).select2({
                dropdownParent: $('#add-new-record'),
                placeholder: __('appointments.select.status'),
                allowClear: true
            });
        }

        // Select2 initialization for edit form
        $('.select2').not('#add-new-record .select2').select2({
            placeholder: function () {
                // Get the appropriate placeholder based on the select element's ID
                const id = $(this).attr('id');
                if (id === 'hospital_id') {
                    return __('appointments.select.hospital');
                } else if (id === 'specialization_id') {
                    return __('appointments.select.specialization');
                } else if (id === 'user_id') {
                    return __('appointments.select.patient');
                } else if (id === 'status') {
                    return __('appointments.select.status');
                }
                return __('messages.select.select');
            },
            allowClear: true
        });

        // Form validation for appointment creation form
        const appointmentCreateForm = document.querySelector('.add-new-record');
        if (appointmentCreateForm) {
            const fv = FormValidation.formValidation(appointmentCreateForm, {
                fields: {
                    hospital_id: {
                        validators: {
                            notEmpty: {
                                message: __('appointments.validation.hospital_empty')
                            }
                        }
                    },
                    specialization_id: {
                        validators: {
                            notEmpty: {
                                message: __('appointments.validation.specialization_empty')
                            }
                        }
                    },
                    user_id: {
                        validators: {
                            notEmpty: {
                                message: __('appointments.validation.patient_empty')
                            }
                        }
                    },
                    appointment_date: {
                        validators: {
                            notEmpty: {
                                message: __('appointments.validation.date_empty')
                            }
                        }
                    },
                    appointment_number: {
                        validators: {
                            notEmpty: {
                                message: __('appointments.validation.number_empty')
                            },
                            integer: {
                                message: __('appointments.validation.number_integer')
                            },
                            greaterThan: {
                                min: 1,
                                message: __('appointments.validation.number_min')
                            }
                        }
                    },
                    status: {
                        validators: {
                            notEmpty: {
                                message: __('appointments.validation.status_empty')
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap5: new FormValidation.plugins.Bootstrap5({
                        eleValidClass: '',
                        rowSelector: '.col-sm-12, .col-sm-6'
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
                                appointmentCreateForm.submit();
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

            // Update select2 validation when value changes
            $(appointmentCreateForm.querySelector('[name="hospital_id"]')).on('change', function () {
                fv.revalidateField('hospital_id');
            });

            $(appointmentCreateForm.querySelector('[name="specialization_id"]')).on('change', function () {
                fv.revalidateField('specialization_id');
            });

            $(appointmentCreateForm.querySelector('[name="user_id"]')).on('change', function () {
                fv.revalidateField('user_id');
            });

            $(appointmentCreateForm.querySelector('[name="status"]')).on('change', function () {
                fv.revalidateField('status');
            });
        }

        // Form validation for appointment edit form
        const appointmentEditForm = document.getElementById('appointment_edit_form');
        if (appointmentEditForm) {
            const fvEdit = FormValidation.formValidation(appointmentEditForm, {
                fields: {
                    hospital_id: {
                        validators: {
                            notEmpty: {
                                message: __('appointments.validation.hospital_empty')
                            }
                        }
                    },
                    specialization_id: {
                        validators: {
                            notEmpty: {
                                message: __('appointments.validation.specialization_empty')
                            }
                        }
                    },
                    user_id: {
                        validators: {
                            notEmpty: {
                                message: __('appointments.validation.patient_empty')
                            }
                        }
                    },
                    appointment_date: {
                        validators: {
                            notEmpty: {
                                message: __('appointments.validation.date_empty')
                            }
                        }
                    },
                    appointment_number: {
                        validators: {
                            notEmpty: {
                                message: __('appointments.validation.number_empty')
                            },
                            integer: {
                                message: __('appointments.validation.number_integer')
                            },
                            greaterThan: {
                                min: 1,
                                message: __('appointments.validation.number_min')
                            }
                        }
                    },
                    status: {
                        validators: {
                            notEmpty: {
                                message: __('appointments.validation.status_empty')
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap5: new FormValidation.plugins.Bootstrap5({
                        eleValidClass: '',
                        rowSelector: '.col-md-6, .col-md-12'
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
                                appointmentEditForm.submit();
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

            // Update select2 validation when value changes
            $(appointmentEditForm.querySelector('[name="hospital_id"]')).on('change', function () {
                fvEdit.revalidateField('hospital_id');
            });

            $(appointmentEditForm.querySelector('[name="specialization_id"]')).on('change', function () {
                fvEdit.revalidateField('specialization_id');
            });

            $(appointmentEditForm.querySelector('[name="user_id"]')).on('change', function () {
                fvEdit.revalidateField('user_id');
            });

            $(appointmentEditForm.querySelector('[name="status"]')).on('change', function () {
                fvEdit.revalidateField('status');
            });
        }

        // Test function to diagnose parameter passing issues
        function testParameterPassing() {
            console.log('Running test parameter passing function');

            // Use the same CSRF token mechanism
            const csrfToken = document.querySelector('meta[name="csrf-token"]')
                ? document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                : '';

            // Test with different methods and formats

            // 1. Test with JSON POST
            console.log('Test 1: JSON POST');
            fetch('/api/test-params', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    hospital_id: '1',
                    date: '2025-05-15',
                    specialization_id: '1'
                })
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Test 1 Result:', data);
                })
                .catch(error => {
                    console.error('Test 1 Error:', error);
                });

            // 2. Test with FormData POST
            console.log('Test 2: FormData POST');
            const formData = new FormData();
            formData.append('hospital_id', '1');
            formData.append('date', '2025-05-15');
            formData.append('specialization_id', '1');

            fetch('/api/test-params', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Test 2 Result:', data);
                })
                .catch(error => {
                    console.error('Test 2 Error:', error);
                });

            // 3. Test with GET query parameters
            console.log('Test 3: GET with query params');
            fetch('/api/test-params?hospital_id=1&date=2025-05-15&specialization_id=1', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Test 3 Result:', data);
                })
                .catch(error => {
                    console.error('Test 3 Error:', error);
                });

            // 4. Test with our actual endpoint (check-appointment-availability)
            console.log('Test 4: Actual endpoint with JSON');
            fetch('/api/check-appointment-availability', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    hospital_id: '1',
                    date: '2025-05-15',
                    specialization_id: '1'
                })
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Test 4 Result:', data);
                })
                .catch(error => {
                    console.error('Test 4 Error:', error);
                });
        }

        // Uncomment to run the test function
        // testParameterPassing();
    })();
});
