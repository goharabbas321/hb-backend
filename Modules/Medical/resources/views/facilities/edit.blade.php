@extends('layouts/layoutMaster')

@section('title', __($page_title))

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

@section('page-script')
    @vite(['Modules/Medical/resources/assets/js/facilities.js'])
    <script>
        window.translations = @json(__('medical::messages'));
    </script>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __($page_title) }}</h4>
                </div>
                <div class="card-body">
                    <form id="facility_form" class="row g-3" method="POST"
                        action="{{ route('facilities.update', $facility->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="col-md-6">
                            <label class="form-label"
                                for="name_en">{{ __('medical::messages.facilities.field.label_name_en') }}</label>
                            <input type="text" id="name_en" class="form-control" name="name_en"
                                value="{{ $facility->name_en }}"
                                placeholder="{{ __('medical::messages.facilities.field.placeholder_name_en') }}" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"
                                for="name_ar">{{ __('medical::messages.facilities.field.label_name_ar') }}</label>
                            <input type="text" id="name_ar" class="form-control" name="name_ar"
                                value="{{ $facility->name_ar }}"
                                placeholder="{{ __('medical::messages.facilities.field.placeholder_name_ar') }}" />
                        </div>

                        <div class="col-12 d-flex justify-content-between">
                            <button type="button" class="btn btn-label-secondary" onclick="window.history.back()">
                                {{ __('messages.button.back') }}
                            </button>
                            <button type="submit" class="btn btn-primary">{{ __('messages.button.update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
