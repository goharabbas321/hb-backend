@extends('layouts/layoutMaster')

@section('title', __($page_title))

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{ __($page_title) }}</h4>
                    @can('update_users')
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">
                            <i class="ti ti-edit me-1"></i>{{ __('messages.button.edit') }}
                        </a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <!-- User Image -->
                        <div class="col-md-4 text-center mb-3 mb-md-0">
                            @if ($user->profile_photo_url)
                                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="rounded mb-3"
                                    style="max-width: 200px;">
                            @else
                                <img src="{{ asset('assets/img/avatars/1.png') }}" alt="{{ $user->name }}"
                                    class="rounded mb-3" style="max-width: 200px;">
                            @endif
                            <div class="mt-3">
                                <h5>{{ $user->name }}</h5>
                                <span class="badge bg-primary">{{ optional($user->roles->first())->name }}</span>
                            </div>
                        </div>
                        <!-- User Basic Info -->
                        <div class="col-md-8">
                            <h4>{{ __('user::messages.users.section.account_details') }}</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>{{ __('user::messages.users.field.username') }}:</strong>
                                    <p>{{ $user->username }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>{{ __('user::messages.users.field.email') }}:</strong>
                                    <p>{{ $user->email }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>{{ __('user::messages.users.field.language') }}:</strong>
                                    <p>{{ $user->language }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <p>
                                        @if ($user->status)
                                            <span class="badge bg-success">{{ __('Active') }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ __('Inactive') }}</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h4>{{ __('user::messages.users.section.personal_info') }}</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>{{ __('user::messages.users.field.full_name') }}:</strong>
                                    <p>{{ $user->name }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>{{ __('user::messages.users.field.phone_number') }}:</strong>
                                    <p>{{ $user->phone }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>{{ __('user::messages.users.field.country') }}:</strong>
                                    <p>{{ getUserInformation($user, 'country') ?? __('Not available') }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>{{ __('user::messages.users.field.address') }}:</strong>
                                    <p>{{ getUserInformation($user, 'address') ?? __('Not available') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($user->hasRole('patient'))
                        <!-- Patient Specific Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h4>{{ __('Patient Information') }}</h4>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <strong>{{ __('City') }}:</strong>
                                        <p>{{ getUserInformation($user, 'city') ?? __('Not available') }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong>{{ __('Age') }}:</strong>
                                        <p>{{ getUserInformation($user, 'age') ?? __('Not available') }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong>{{ __('Gender') }}:</strong>
                                        <p>{{ getUserInformation($user, 'gender') ?? __('Not available') }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong>{{ __('Emergency Contact') }}:</strong>
                                        <p>{{ getUserInformation($user, 'emergency_contact') ?? __('Not available') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- System Information -->
                    <div class="row">
                        <div class="col-12">
                            <h4>{{ __('System Information') }}</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <strong>{{ __('messages.table.created_date') }}:</strong>
                                    <p>{{ $user->created_at->format('Y-m-d H:i:s') }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <strong>{{ __('messages.table.updated_date') }}:</strong>
                                    <p>{{ $user->updated_at->format('Y-m-d H:i:s') }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <strong>{{ __('messages.table.id') }}:</strong>
                                    <p>{{ $user->id }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left me-1"></i>{{ __('messages.button.back') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
