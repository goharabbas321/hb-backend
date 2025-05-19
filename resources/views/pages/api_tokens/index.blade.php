@extends('layouts.layoutMaster')

@section('title', app()->getLocale() == 'ar' ? 'رموز API' : 'API Tokens')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-select-bs5/select.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
    @vite(['resources/assets/js/api_token/index.js'])
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <!-- Create an API key -->
            <div class="mb-6 card">
                <h5 class="card-header">{{ __('messages.api_tokens.create.heading') }}</h5>
                <div class="row">
                    <div class="order-1 col-md-5 order-md-0">
                        <div class="card-body">
                            <form id="formAccountSettingsApiKey" method="POST" action="{{ route('api-tokens.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="mb-5 col-12">
                                        <label for="apiAccess"
                                            class="form-label">{{ __('messages.api_tokens.create.label_api_access') }}</label>
                                        <select id="permissions" class="select2 form-select" multiple="multiple"
                                            name="permissions[]">
                                            <option value="create">{{ __('messages.api_tokens.create.api_access_option1') }}
                                            </option>
                                            <option value="read">{{ __('messages.api_tokens.create.api_access_option2') }}
                                            </option>
                                            <option value="update">{{ __('messages.api_tokens.create.api_access_option3') }}
                                            </option>
                                            <option value="delete">{{ __('messages.api_tokens.create.api_access_option4') }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-5 col-12">
                                        <label for="name"
                                            class="form-label">{{ __('messages.api_tokens.create.label_name') }}</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="{{ __('messages.api_tokens.create.placeholder_name') }}" />
                                    </div>
                                    <div class="col-12">
                                        <button type="submit"
                                            class="btn btn-primary me-2 d-grid w-100">{{ __('messages.api_tokens.create.btn_submit') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-7 order-md-1 order-0">
                        <div class="mx-3 mt-4 text-center mx-md-0">
                            <img src="{{ asset('assets/img/illustrations/girl-with-laptop.png') }}" class="img-fluid"
                                alt="Api Key Image" width="202">
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Create an API key -->

            <!-- API Key List & Access -->
            <div class="mb-6 card">
                <div class="card-body">
                    <h5>{{ __('messages.api_tokens.show.heading') }}</h5>
                    <p class="mb-6">{{ __('messages.api_tokens.show.sub_heading') }}</p>
                    <div class="row">
                        <div class="col-md-12">
                            @foreach ($tokens as $key => $token)
                                <div class="p-4 mb-6 rounded bg-lighter position-relative">
                                    <div class="mb-2 d-flex align-items-center">
                                        <h5 class="mb-0 me-3">{{ $token->name }}</h5>
                                        <span
                                            class="badge bg-label-primary">{{ __(implode(', ', $token->abilities)) }}</span>
                                    </div>

                                    <div class="mb-2 token-container d-flex align-items-center">
                                        @if (count($tokens) == $key + 1 && isset($_GET['token']))
                                            <p class="mb-0 me-3 fw-medium my-token">{{ $_GET['token'] }}</p>
                                            <span class="cursor-pointer me-2 btn-copy"><i class="ti ti-copy"></i></span>
                                        @endif
                                        <form method="POST" action="{{ route('api-tokens.destroy', $token->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <span class="cursor-pointer delete-record"><i class="ti ti-trash"></i></span>
                                        </form>
                                    </div>
                                    @if ($token->last_used_at)
                                        <span
                                            class="text-muted">{{ __('messages.api_tokens.show.status', ['status' => $token->last_used_at]) }}</span>
                                    @else
                                        <span class="text-muted">{{ __('messages.api_tokens.show.status_empty') }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!--/ API Key List & Access -->
        </div>
    </div>
@endsection
