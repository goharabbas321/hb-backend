<script>
    document.addEventListener('DOMContentLoaded', function(e) {
        $(document).ready(function() {
            let dateRange = $('#date-filter').val();
            let startDate = '';
            let endDate = '';

            var dataTable = $('.gms-table').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                scrollY: '600px',
                scrollX: true,
                orderCellsTop: true,
                select: {
                    // Select style
                    style: 'multi'
                },
                order: [{{ $order['column'] }}, '{{ $order['direction'] }}'],
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, 100, 200, 500, 1000],
                    [10, 25, 50, 100, 200, 500, "1K"]
                ],
                ajax: {
                    url: "{{ $table_data['url'] }}",
                    dataType: "json",
                    type: "POST",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}",
                            {{ $nav_filter }} = $('#navFilter .nav-link.active').data(
                                'nav'),
                            {{ $nav_filter2 }} = $('#navFilter2 .nav-link.active').data(
                                'nav'),
                            d.startDate = startDate,
                            d.endDate = endDate,
                            d.deleted_at = $('#navFilter .nav-link.active').data('delete')
                        @foreach ($filters as $key => $filter)
                            , {{ $key }} = $('{{ $filter }}').val()
                        @endforeach
                    }
                },
                columns: [{
                        data: "id"
                    },
                    @foreach ($columns as $column)
                        {
                            data: "{{ $column }}"
                        },
                    @endforeach
                ],
                columnDefs: [{
                        // For Checkboxes
                        targets: 0,
                        searchable: false,
                        orderable: false,
                        render: function() {
                            return '<input type="checkbox" class="dt-checkboxes form-check-input">';
                        },
                        checkboxes: {
                            selectRow: true,
                            selectAllRender: '<input type="checkbox" class="form-check-input">'
                        }
                    },
                    @foreach ($columnDefs as $key => $defs)
                        {
                            @foreach ($defs as $key1 => $def)
                                {{ $key1 }}: {!! $def !!},
                            @endforeach
                        },
                    @endforeach
                ],
                dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-6 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end mt-n6 mt-md-0"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                @if (app()->getLocale() != 'en')
                    language: {
                        url: window.APP_URL + '/assets/json/i18n/' + window.APP_LOCALE + '.json'
                    },
                @endif
                buttons: [
                    @if ($bulk_action_active)
                        @can($delete_permission)
                            {
                                extend: 'collection',
                                className: 'btn btn-label-secondary dropdown-toggle me-4 waves-effect waves-light border-none mb-4',
                                text: '<i class="ti ti-clipboard ti-xs me-sm-1"></i> <span class="d-none d-sm-inline-block">{{ __('messages.datatable.bulk.heading') }}</span>',
                                attr: {
                                    "id": "btn-bulk",
                                },
                                buttons: [{
                                        text: '<i class="ti ti-trash me-1"></i>{{ __('messages.datatable.bulk.delete') }}',
                                        className: 'dropdown-item',
                                        attr: {
                                            "id": "btn-delete-selected",
                                        },
                                    },
                                    @can($restore_permission)
                                        {
                                            text: '<i class="ti ti-restore me-1"></i>{{ __('messages.datatable.bulk.restore') }}',
                                            className: 'dropdown-item',
                                            attr: {
                                                "id": "btn-restore-selected",
                                            },
                                        },
                                    @endcan
                                    @foreach ($bulk_actions as $key => $bulk_action)
                                        {
                                            text: '{!! $key !!}',
                                            className: 'dropdown-item',
                                            attr: {
                                                "id": "{{ $bulk_action }}",
                                            },
                                        },
                                    @endforeach
                                ],
                            },
                        @endcan
                    @endif {
                        text: '<i class="ti ti-list"></i>',
                        className: "btn btn-label-warning me-3 mb-4",
                        attr: {
                            "id": "column-btn",
                        },
                    },
                    @if ($filter_active)
                        {
                            text: '<i class="ti ti-filter me-1"></i><span class="d-none d-sm-inline-block">{{ __('messages.datatable.filters.heading') }}</span>',
                            className: "btn btn-label-info me-3 mb-4",
                            attr: {
                                "id": "filter-btn",
                            },
                        },
                    @endif {
                        extend: 'collection',
                        className: 'btn btn-label-primary dropdown-toggle me-4 waves-effect waves-light border-none mb-4',
                        text: '<i class="ti ti-file-export ti-xs me-sm-1"></i> <span class="d-none d-sm-inline-block">{{ __('messages.datatable.export.heading') }}</span>',
                        buttons: [{
                                extend: 'print',
                                text: '<i class="ti ti-printer me-1" ></i>{{ __('messages.datatable.export.print') }}',
                                className: 'dropdown-item',
                                charset: 'utf-8',
                                exportOptions: {
                                    columns: function(idx, data, node) {
                                        // Exclude the last column (actions) and export only visible columns
                                        return idx < dataTable.columns().nodes()
                                            .length - 1 && $(node).is(
                                                ':visible');
                                    },
                                    // custom format
                                    format: {

                                    }
                                },
                                customize: function(win) {
                                    //customize print view for dark
                                    $(win.document.body)
                                        .css('color', config.colors
                                            .headingColor)
                                        .css('border-color', config.colors
                                            .borderColor)
                                        .css('background-color', config.colors
                                            .bodyBg);
                                    $(win.document.body)
                                        .find('table')
                                        .addClass('compact')
                                        .css('color', 'inherit')
                                        .css('border-color', 'inherit')
                                        .css('background-color', 'inherit');
                                    if (window.APP_LOCALE == 'ar') {
                                        // Apply RTL style to the print window
                                        $(win.document.body).css('direction',
                                            'rtl');
                                        // Optionally, add any additional styling for better readability in RTL
                                        $(win.document.body).find('th').css(
                                            'text-align', 'center');
                                        $(win.document.body).find('td').css(
                                            'text-align', 'center');
                                    }
                                }
                            },
                            {
                                extend: 'excel',
                                text: '<i class="ti ti-file-spreadsheet me-1"></i>{{ __('messages.datatable.export.excel') }}',
                                className: 'dropdown-item',
                                charset: 'utf-8',
                                extension: '.xlsx',
                                filename: '{{ $exports['file'] }}',
                                bom: true,
                                exportOptions: {
                                    columns: function(idx, data, node) {
                                        // Exclude the last column (actions) and export only visible columns
                                        return idx < dataTable.columns().nodes()
                                            .length - 1 && $(node).is(
                                                ':visible');
                                    },
                                    // custom format
                                    format: {

                                    }
                                },
                            },
                            /*{
                                extend: 'pdf',
                                text: '<i class="ti ti-file-description me-1"></i>{{ __('messages.datatable.export.pdf') }}',
                                className: 'dropdown-item',
                                charset: 'utf-8',
                                extension: '.pdf',
                                filename: '{{ $exports['file'] }}',
                                bom: true,
                                exportOptions: {
                                    columns: {{ json_encode($exports['columns']) }},
                                    // custom format
                                    format: {

                                    }
                                }
                            },*/
                        ],
                    },
                    @can($button['permission'])
                        {
                            text: '<i class="ti {{ $button['icon'] }} me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">{{ __($button['name']) }}</span>',
                            className: "add-new btn btn-primary mb-4 {{ $button['class'] }}",
                            attr: {
                                @foreach ($button['attr'] as $key => $attr)
                                    "{{ $key }}": "{{ $attr }}",
                                @endforeach
                            },
                        },
                    @endcan
                ],
                initComplete: function(settings, json) {
                    $('div.head-label').html(
                        '<h5 class="mb-0 card-title">{{ __($title) }}</h5>');
                    $('.card-header').after('<hr class="my-0">');
                    $('.gms-datatable').find('tbody tr:first').addClass('border-top-0');
                    loadColumnSettings(dataTable);
                    // Hide the bulk button initially
                    $('#btn-bulk').css('visibility', 'hidden');
                }
            });

            window.dataTable = dataTable;

            // Set up column selector modal with checkboxes for each column
            dataTable.columns().every(function(index) {
                $('#columnCheckboxes').append(
                    `<div class="form-check">
                <input class="form-check-input" type="checkbox" id="col${index}" data-column="${index}" checked>
                <label class="form-check-label" for="col${index}">
                    ${dataTable.column(index).header().textContent}
                </label>
            </div>`
                );
            });

            // Apply column visibility based on checkbox state
            $('#applyColumns').on('click', function() {
                $('#columnCheckboxes input[type="checkbox"]').each(function() {
                    var column = dataTable.column($(this).data('column'));
                    column.visible($(this).is(':checked'));
                });
                $('#columnSelectorModal').modal('hide');
            });

            // Persist column visibility settings using localStorage

            $('#applyColumns').on('click', function() {
                saveColumnSettings(dataTable);
            });

            $(document).on('click', '.btn-add', function() {
                window.location = "{{ $button['url'] }}";
            });

            $(document).on('click', '.btn-refresh', function() {
                // Trigger the function to fetch data
                fetchStudentsDataWithProgress();
            });

            @foreach ($filters as $key => $filter)
                $('{{ $filter }}').keyup(function() {
                    dataTable.draw();
                });
            @endforeach

            $('select').on('change', function(e) {
                var name = $('option:selected', this).attr("name");
                var value = $(this).val();
                $(name).val(value);
                $(name).keyup();
            });

            function clearFields() {
                $('#filter-card input[type="text"]').val('');
                $('#filter-card input[type="number"]').val('');
                $('#filter-card input[type="email"]').val('');
                $('#filter-card input[type="hidden"]').val('');
                $('#filter-card select').each(function() {
                    $(this).find('option[disabled]').prop('selected', true);
                    $(this).val("").trigger('change');
                });
                startDate = '';
                endDate = '';
                dataTable.draw();
            }

            $('.btn-clear').click(function() {
                clearFields();
            });

            // Load settings from localStorage
            function loadColumnSettings(table) {
                var savedSettings = JSON.parse(localStorage.getItem('columnSettings') || '{}');
                table.columns().every(function(index) {
                    var isVisible = savedSettings[index] ?? true;
                    this.visible(isVisible);
                    $(`#col${index}`).prop('checked', isVisible);
                });
            }

            // Save settings to localStorage
            function saveColumnSettings(table) {
                var settings = {};
                $('#columnCheckboxes input[type="checkbox"]').each(function() {
                    settings[$(this).data('column')] = $(this).is(':checked');
                });
                localStorage.setItem('columnSettings', JSON.stringify(settings));
            }

            // Filter form control to default size
            // ? setTimeout used for multilingual table initialization
            setTimeout(() => {
                $('.dataTables_filter .form-control').removeClass('form-control-sm');
                $('.dataTables_length .form-select').removeClass('form-select-sm');
            }, 300);

            // Hide the card initially
            /*$('#filter-card').hide();

            // Toggle card visibility on button click
            $(document).on('click', '#filter-btn', function() {
                if ($('#filter-card').is(':visible')) {
                    // Slide up to hide the card
                    clearFields();
                    $('#filter-card').slideUp(400); // 400ms duration
                } else {
                    // Slide down to show the card
                    $('#filter-card').slideDown(400); // 400ms duration
                }
            });*/

            $(document).on('click', '#filter-btn', function() {
                const filterCard = $('#filter-card');
                const datatableCard = $('#datatable-card');

                if (filterCard.hasClass('hidden')) {
                    // Show filter card
                    filterCard.removeClass('hidden').addClass('col-3');
                    datatableCard.removeClass('col-12').addClass('col-9');
                } else {
                    // Hide filter card
                    clearFields();
                    filterCard.addClass('hidden').removeClass('col-3');
                    datatableCard.removeClass('col-9').addClass('col-12');
                }
                setTimeout(
                    function() {
                        dataTable.draw();
                    }, 500);
            });

            $(document).on('click', '#column-btn', function() {
                $('#columnSelectorModal').modal('show');
            });

            // Function to handle row selection
            dataTable.on('select', function(e, dt, type, indexes) {
                if (type === 'row') {
                    const selectedRows = dataTable.rows({
                        selected: true
                    }).count();
                    if (selectedRows > 0) {
                        $('#btn-bulk').css('visibility', 'visible');
                        checkButton(); // Start the check
                    }
                }
            });

            // Function to handle row deselection
            dataTable.on('deselect', function(e, dt, type, indexes) {
                if (type === 'row') {
                    const selectedRows = dataTable.rows({
                        selected: true
                    }).count();
                    if (selectedRows == 0) {
                        $('#btn-bulk').css('visibility', 'hidden');
                    }
                }
            });

            function checkButton() {
                if ($('#btn-delete-selected').length) {
                    if ($('#navFilter .nav-link.active').data('delete') == 'deleted') {
                        $('#btn-delete-selected').hide(); // Hide the button
                        $('#btn-restore-selected').show(); // Show the button
                    } else {
                        $('#btn-delete-selected').show(); // Show the button
                        $('#btn-restore-selected').hide(); // Hide the button
                    }
                } else {
                    setTimeout(checkButton, 100); // Retry after 100ms
                }
            }

            $(document).on('click', '#btn-delete-selected', function() {

                Swal.fire({
                        title: "{{ __('messages.validation.confirm_delete.title') }}",
                        text: "{{ __('messages.validation.confirm_delete.text') }}",
                        icon: "warning",
                        showCancelButton: true,
                        cancelButtonText: "{{ __('messages.validation.confirm_delete.btn_cancel') }}",
                        confirmButtonText: "{{ __('messages.validation.confirm_delete.btn_confirm') }}",
                        customClass: {
                            confirmButton: "btn btn-primary me-3 waves-effect waves-light",
                            cancelButton: "btn btn-outline-secondary waves-effect",
                        },
                        buttonsStyling: !1,
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            // If confirmed, submit the request
                            deleteSelected('delete');
                        }
                    });
            });

            $(document).on('click', '#btn-restore-selected', function() {

                Swal.fire({
                        title: "{{ __('messages.validation.confirm_restore.title') }}",
                        text: "{{ __('messages.validation.confirm_restore.text') }}",
                        icon: "warning",
                        showCancelButton: true,
                        cancelButtonText: "{{ __('messages.validation.confirm_restore.btn_cancel') }}",
                        confirmButtonText: "{{ __('messages.validation.confirm_restore.btn_confirm') }}",
                        customClass: {
                            confirmButton: "btn btn-primary me-3 waves-effect waves-light",
                            cancelButton: "btn btn-outline-secondary waves-effect",
                        },
                        buttonsStyling: !1,
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            // If confirmed, submit the request
                            deleteSelected('restore');
                        }
                    });
            });

            function deleteSelected(action) {
                var selectedRows = dataTable.rows({
                    selected: true
                }).data();

                if (selectedRows.length > 0) {
                    var ids = [];
                    selectedRows.each(function(data) {
                        ids.push(data[
                            'id'
                        ]); // Assuming first column contains row ID (adjust if needed)
                    });

                    // Send selected IDs to Laravel controller in a single request
                    $.ajax({
                        url: window.BulkURL, // Adjust the route to your delete handler
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}", // CSRF token
                            action: action,
                            ids: ids
                        },
                        success: function(response) {
                            // Handle success (e.g., reload table or notify user)
                            if (response.success) {
                                toastr.success(response.message, "", {
                                    "closeButton": true,
                                    "progressBar": true,
                                    "positionClass": "toast-top-right",
                                    "timeOut": 15000 // Time in ms
                                });

                                dataTable.rows({
                                    selected: true
                                }).remove().draw();
                            } else {
                                toastr.error(response.message, "", {
                                    "closeButton": true,
                                    "progressBar": true,
                                    "positionClass": "toast-top-right",
                                    "timeOut": 15000 // Time in ms
                                });
                            }
                        },
                        error: function(xhr) {
                            // Handle error response
                            if (xhr.responseJSON) {
                                // Extract and display the message from the JSON response
                                var message = xhr.responseJSON.message;
                                toastr.error(message, "", {
                                    "closeButton": true,
                                    "progressBar": true,
                                    "positionClass": "toast-top-right",
                                    "timeOut": 15000 // Time in ms
                                });
                            } else {
                                toastr.error(
                                    "{{ __('messages.datatable.bulk.error') }}",
                                    "", {
                                        "closeButton": true,
                                        "progressBar": true,
                                        "positionClass": "toast-top-right",
                                        "timeOut": 15000 // Time in ms
                                    });
                            }
                        }
                    });
                } else {
                    alert('No rows selected');
                }
            }

            // Handle nav link click for role filtering
            $('#navFilter .nav-link').click(function(e) {
                e.preventDefault();

                $('#navFilter .nav-link').removeClass('active'); // Remove active class
                $(this).addClass('active'); // Add active class to clicked link

                // Deselect all rows
                dataTable.rows().deselect();

                dataTable.draw(); // Redraw the DataTable with new filter
            });

            // Handle nav link click for role filtering
            $('#navFilter2 .nav-link').click(function(e) {
                e.preventDefault();

                $('#navFilter2 .nav-link').removeClass('active'); // Remove active class
                $(this).addClass('active'); // Add active class to clicked link

                // Deselect all rows
                dataTable.rows().deselect();

                dataTable.draw(); // Redraw the DataTable with new filter
            });

            // Initialize DateRange Picker
            $('#date-filter').daterangepicker({
                opens: "center",
                drops: "auto",
                autoUpdateInput: false,
                @if (app()->getLocale() == 'ar')
                    locale: {
                        format: 'YYYY-MM-DD',
                        separator: ' - ',
                        applyLabel: 'تطبيق',
                        cancelLabel: 'إلغاء',
                        fromLabel: 'من',
                        toLabel: 'إلى',
                        customRangeLabel: 'اختيار نطاق',
                        weekLabel: 'أسبوع',
                        daysOfWeek: ['أحد', 'إثن', 'ثلاث', 'أربع', 'خميس', 'جمعة', 'سبت'],
                        monthNames: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو',
                            'يوليو',
                            'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'
                        ],
                        firstDay: 6 // Saturday as the first day of the week
                    },
                @else
                    locale: {
                        cancelLabel: 'Clear',
                        format: 'YYYY-MM-DD',
                    }
                @endif

            });

            // Apply date range and trigger DataTable redraw
            $('#date-filter').on('apply.daterangepicker', function(ev, picker) {
                startDate = picker.startDate.format('YYYY-MM-DD');
                endDate = picker.endDate.format('YYYY-MM-DD');
                if (startDate === endDate) {
                    $(this).val(startDate); // Show only the date in the input
                } else {
                    @if (app()->getLocale() == 'ar')
                        $(this).val(startDate + ' إلى ' +
                            endDate); // Show the range in the input
                    @else
                        $(this).val(startDate + ' to ' +
                            endDate); // Show the range in the input
                    @endif
                }
                dataTable.draw();
            });

            // Clear date filter
            $('#date-filter').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                startDate = '';
                endDate = '';
                dataTable.draw();
            });

            function fetchStudentsDataWithProgress() {
                Swal.fire({
                        title: "{{ __('messages.validation.confirm_alert.title') }}",
                        text: "{{ __('messages.validation.confirm_alert.text') }}",
                        icon: "warning",
                        showCancelButton: true,
                        cancelButtonText: "{{ __('messages.validation.confirm_alert.btn_cancel') }}",
                        confirmButtonText: "{{ __('messages.validation.confirm_alert.btn_confirm') }}",
                        customClass: {
                            confirmButton: "btn btn-primary me-3 waves-effect waves-light",
                            cancelButton: "btn btn-outline-secondary waves-effect",
                        },
                        buttonsStyling: !1,
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            // If confirmed, submit the request
                            const swalInstance = Swal.fire({
                                title: "{{ __('messages.validation.confirm_refresh.title') }}",
                                text: "{{ __('messages.validation.confirm_refresh.text') }}",
                                icon: "info",
                                showConfirmButton: false, // Disable OK button
                                showCancelButton: false, // Disable Cancel button
                                allowOutsideClick: false, // Prevent closing by clicking outside
                                cancelButtonText: "{{ __('messages.validation.confirm_refresh.btn_cancel') }}",
                                confirmButtonText: "{{ __('messages.validation.confirm_refresh.btn_confirm') }}",
                                customClass: {
                                    confirmButton: "btn btn-primary me-3 waves-effect waves-light d-none",
                                    cancelButton: "btn btn-outline-secondary waves-effect d-none",
                                },
                                buttonsStyling: !1,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            $.ajax({
                                url: window.refreshURL, // Replace with your actual route
                                method: 'GET',
                                xhr: function() {
                                    var xhr = new window.XMLHttpRequest();
                                    xhr.addEventListener('progress', function(e) {
                                        if (e.lengthComputable) {
                                            var percent = (e.loaded / e.total) *
                                                100;
                                            // Step 2: Update the progress bar and text dynamically
                                            swalInstance.$content.find(
                                                '#progressBar').val(
                                                percent);
                                            swalInstance.$content.find(
                                                '#progressText').text(
                                                Math.round(percent) + '%');
                                        }
                                    });
                                    return xhr;
                                },
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: "{{ __('messages.validation.confirm_refresh.success') }}",
                                        text: response.message,
                                        showConfirmButton: true, // Disable OK button
                                        showCancelButton: false, // Disable Cancel button
                                        allowOutsideClick: false, // Prevent closing by clicking outside
                                        cancelButtonText: "{{ __('messages.validation.confirm_refresh.btn_cancel') }}",
                                        confirmButtonText: "{{ __('messages.validation.confirm_refresh.btn_confirm') }}",
                                        customClass: {
                                            confirmButton: "btn btn-primary me-3 waves-effect waves-light",
                                            cancelButton: "btn btn-outline-secondary waves-effect d-none",
                                        },
                                        buttonsStyling: !1,
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // Refresh the window after the user clicks OK
                                            window.location.reload();
                                        }
                                    });
                                },
                                error: function(error) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: "{{ __('messages.validation.confirm_refresh.error') }}",
                                        text: error.responseJSON.message,
                                        showConfirmButton: true, // Disable OK button
                                        showCancelButton: false, // Disable Cancel button
                                        allowOutsideClick: false, // Prevent closing by clicking outside
                                        cancelButtonText: "{{ __('messages.validation.confirm_refresh.btn_cancel') }}",
                                        confirmButtonText: "{{ __('messages.validation.confirm_refresh.btn_confirm') }}",
                                        customClass: {
                                            confirmButton: "btn btn-primary me-3 waves-effect waves-light",
                                            cancelButton: "btn btn-outline-secondary waves-effect d-none",
                                        },
                                        buttonsStyling: !1,
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // Refresh the window after the user clicks OK
                                            window.location.reload();
                                        }
                                    });
                                }
                            });
                        }
                    });
            }

        });
    });
</script>
