<!-- Column Selector Modal -->
<div class="modal fade" id="columnSelectorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{{ __('messages.datatable.filters.select_columns') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4 row g-4">
                    <div class="col">
                        <div id="columnCheckboxes"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary"
                    data-bs-dismiss="modal">{{ __('messages.datatable.filters.btn_close') }}</button>
                <button type="button" class="btn btn-primary"
                    id="applyColumns">{{ __('messages.datatable.filters.btn_apply') }}</button>
            </div>
        </div>
    </div>
</div>
