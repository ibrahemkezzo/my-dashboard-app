@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('Web Site Setting'), 'url' => route('dashboard.settings.index')],
    ]" :pageName="__('Web Site Setting')" />
@endsection

@section('content')
    <x-alert-message />
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header card-details-title">
                        <h3><span class="font-primary"><i class="icofont icofont-gear"></i></span> {{ __('Website Settings') }}</h3>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs mb-4" id="settingsTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="general-tab" data-bs-toggle="tab" href="#general" role="tab">{{ __('General') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="aboutus-tab" data-bs-toggle="tab" href="#aboutus" role="tab">{{ __('About Us') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="contactus-tab" data-bs-toggle="tab" href="#contactus" role="tab">{{ __('Contact Us') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="services-tab" data-bs-toggle="tab" href="#services" role="tab">{{ __('Services') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="terms-tab" data-bs-toggle="tab" href="#terms" role="tab">{{ __('Terms & Conditions') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="privacy-tab" data-bs-toggle="tab" href="#privacy" role="tab">{{ __('Privacy Policy') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="faq-tab" data-bs-toggle="tab" href="#faq" role="tab">{{ __('FAQ') }}</a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link" id="legal-tab" data-bs-toggle="tab" href="#legal" role="tab">{{ __('Legal & Info') }}</a>
                            </li> --}}
                        </ul>
                        <div class="tab-content" id="settingsTabContent">
                            {{-- General Settings --}}
                            <div class="tab-pane fade show active" id="general" role="tabpanel">
                                <form action="{{ route('dashboard.settings.updateGeneral') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                                    @csrf
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('Site Name') }}</label>
                                        <input type="text" name="site_name" value="{{ old('site_name', $generalSettings['site_name']) }}" class="form-control" required>
                                        @error('site_name')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('Site Title') }}</label>
                                        <input type="text" name="site_title" value="{{ old('site_title', $generalSettings['site_title']) }}" class="form-control" required>
                                        @error('site_title')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">{{ __('Meta Description (SEO)') }}</label>
                                        <textarea name="meta_description" class="form-control">{{ old('meta_description', $generalSettings['meta_description']) }}</textarea>
                                        @error('meta_description')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">{{ __('Meta Keywords (SEO)') }}</label>
                                        <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $generalSettings['meta_keywords']) }}" class="form-control">
                                        @error('meta_keywords')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('Default Language') }}</label>
                                        <select name="default_language" class="form-select">
                                            <option value="ar" {{ old('default_language', $generalSettings['default_language']) === 'ar' ? 'selected' : '' }}>العربية</option>
                                            <option value="en" {{ old('default_language', $generalSettings['default_language']) === 'en' ? 'selected' : '' }}>English</option>
                                        </select>
                                        @error('default_language')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('Site Status') }}</label>
                                        <select name="site_status" class="form-select">
                                            <option value="active" {{ old('site_status', $generalSettings['site_status']) === 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                            <option value="maintenance" {{ old('site_status', $generalSettings['site_status']) === 'maintenance' ? 'selected' : '' }}>{{ __('Maintenance') }}</option>
                                        </select>
                                        @error('site_status')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">{{ __('Maintenance Message') }}</label>
                                        <textarea name="maintenance_message" class="form-control">{{ old('maintenance_message', $generalSettings['maintenance_message']) }}</textarea>
                                        @error('maintenance_message')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('Email') }}</label>
                                        <input type="email" name="email_settings" value="{{ old('email_settings', $generalSettings['email_settings']) }}" class="form-control">
                                        @error('email_settings')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('Analytics Code') }}</label>
                                        <textarea name="analytics_code" class="form-control">{{ old('analytics_code', $generalSettings['analytics_code']) }}</textarea>
                                        @error('analytics_code')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">{{ __('Social Links') }}</label>
                                        <div class="row g-2">
                                            <div class="col">
                                                <input type="url" name="social_links[facebook]" value="{{ old('social_links.facebook', $generalSettings['social_links']['facebook'] ?? '') }}" class="form-control" placeholder="Facebook">
                                            </div>
                                            <div class="col">
                                                <input type="url" name="social_links[twitter]" value="{{ old('social_links.twitter', $generalSettings['social_links']['twitter'] ?? '') }}" class="form-control" placeholder="Twitter">
                                            </div>
                                            <div class="col">
                                                <input type="url" name="social_links[instagram]" value="{{ old('social_links.instagram', $generalSettings['social_links']['instagram'] ?? '') }}" class="form-control" placeholder="Instagram">
                                            </div>
                                        </div>
                                        @error('social_links.facebook')<div class="text-danger small">{{ $message }}</div>@enderror
                                        @error('social_links.twitter')<div class="text-danger small">{{ $message }}</div>@enderror
                                        @error('social_links.instagram')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">{{ __('Footer Text') }}</label>
                                        <textarea name="footer_text" class="form-control">{{ old('footer_text', $generalSettings['footer_text']) }}</textarea>
                                        @error('footer_text')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">{{ __('Site Logo') }}</label>
                                        <div class="d-flex justify-content-center align-items-center mb-2" style="height:120px;">
                                            @if($generalSettings['site_logo'])
                                                <img src="{{ asset('storage/'.$generalSettings['site_logo']) }}" class="img-thumbnail shadow-sm" style="max-width:100px; max-height:100px; object-fit:contain;" alt="Site Logo" />
                                            @endif
                                        </div>
                                        <input type="file" name="site_logo" accept="image/*" class="form-control">
                                        @error('site_logo')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">{{ __('Cover Image') }}</label>
                                        <div class="d-flex justify-content-center align-items-center mb-2" style="height:120px;">
                                            @if($generalSettings['cover_image'])
                                                <img src="{{ asset('storage/'.$generalSettings['cover_image']) }}" class="img-thumbnail shadow-sm" style="max-width:100px; max-height:100px; object-fit:contain;" alt="Cover Image" />
                                            @endif
                                        </div>
                                        <input type="file" name="cover_image" accept="image/*" class="form-control">
                                        @error('cover_image')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">{{ __('Favicon') }}</label>
                                        <div class="d-flex justify-content-center align-items-center mb-2" style="height:120px;">
                                            @if($generalSettings['favicon'])
                                                <img src="{{ asset('storage/'.$generalSettings['favicon']) }}" class="img-thumbnail shadow-sm" style="max-width:48px; max-height:48px; object-fit:contain;" alt="Favicon" />
                                            @endif
                                        </div>
                                        <input type="file" name="favicon" accept="image/ico,image/png" class="form-control">
                                        @error('favicon')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-12 mt-3">
                                        <button type="submit" class="btn btn-primary btn-air-primary px-5">{{ __('Save Settings') }}</button>
                                    </div>
                                </form>
                            </div>
                            {{-- About Us Settings --}}
                            <div class="tab-pane fade" id="aboutus" role="tabpanel">
                                <form action="{{ route('dashboard.settings.updateAboutUs') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                                    @csrf
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('Title') }}</label>
                                        <input type="text" name="title" value="{{ old('title', $aboutUsSettings['about_us_title']) }}" class="form-control" required>
                                        @error('title')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('Description') }}</label>
                                        <textarea name="description" class="form-control" required>{{ old('description', $aboutUsSettings['about_us_description']) }}</textarea>
                                        @error('description')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('Vision') }}</label>
                                        <textarea name="vision" class="form-control">{{ old('vision', $aboutUsSettings['about_us_vision']) }}</textarea>
                                        @error('vision')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('Mission') }}</label>
                                        <textarea name="mission" class="form-control">{{ old('mission', $aboutUsSettings['about_us_mission']) }}</textarea>
                                        @error('mission')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">{{ __('Values') }}</label>
                                        <div id="values-container">
                                            @foreach (old('values', $aboutUsSettings['about_us_values']) as $value)
                                                <div class="input-group mb-2">
                                                    <input type="text" name="values[]" value="{{ $value }}" class="form-control">
                                                    <button type="button" class="btn btn-outline-danger" onclick="removeField(this)"><i class="fa fa-trash"></i></button>
                                                </div>
                                            @endforeach
                                            <div class="input-group mb-2">
                                                <input type="text" name="values[]" class="form-control" placeholder="{{ __('New Value') }}">
                                                <button type="button" class="btn btn-outline-danger" onclick="removeField(this)"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addField('values-container', 'values[]', '{{ __('New Value') }}')"><i class="fa fa-plus"></i> {{ __('Add Value') }}</button>
                                        @error('values.*')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('Video URL') }}</label>
                                        <input type="url" name="video_url" value="{{ old('video_url', $aboutUsSettings['about_us_video_url']) }}" class="form-control">
                                        @error('video_url')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('Founded At') }}</label>
                                        <input type="date" name="founded_at" value="{{ old('founded_at', $aboutUsSettings['about_us_founded_at']) }}" class="form-control">
                                        @error('founded_at')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('Employees Count') }}</label>
                                        <input type="number" name="employees_count" value="{{ old('employees_count', $aboutUsSettings['about_us_employees_count']) }}" class="form-control" min="0">
                                        @error('employees_count')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">{{ __('Statistics') }}</label>
                                        <div id="statistics-container">
                                            @foreach (old('statistics', $aboutUsSettings['about_us_statistics']) as $statistic)
                                                <div class="input-group mb-2">
                                                    <input type="text" name="statistics[]" value="{{ $statistic }}" class="form-control">
                                                    <button type="button" class="btn btn-outline-danger" onclick="removeField(this)"><i class="fa fa-trash"></i></button>
                                                </div>
                                            @endforeach
                                            <div class="input-group mb-2">
                                                <input type="text" name="statistics[]" class="form-control" placeholder="{{ __('New Statistic') }}">
                                                <button type="button" class="btn btn-outline-danger" onclick="removeField(this)"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addField('statistics-container', 'statistics[]', '{{ __('New Statistic') }}')"><i class="fa fa-plus"></i> {{ __('Add Statistic') }}</button>
                                        @error('statistics.*')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('About Us Image') }}</label>
                                        <div class="d-flex justify-content-center align-items-center mb-2" style="height:120px;">
                                            @if($aboutUsSettings['about_us_image'])
                                                <img src="{{ asset('storage/'.$aboutUsSettings['about_us_image']) }}" class="img-thumbnail shadow-sm" style="max-width:100px; max-height:100px; object-fit:contain;" alt="About Us Image" />
                                            @endif
                                        </div>
                                        <input type="file" name="image" accept="image/*" class="form-control">
                                        @error('image')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-12 mt-3">
                                        <button type="submit" class="btn btn-primary btn-air-primary px-5">{{ __('Save Settings') }}</button>
                                    </div>
                                </form>
                            </div>
                            {{-- Contact Us Settings --}}
                            <div class="tab-pane fade" id="contactus" role="tabpanel">
                                <form action="{{ route('dashboard.settings.updateContactUs') }}" method="POST" class="row g-3">
                                    @csrf
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('Title') }}</label>
                                        <input type="text" name="title" value="{{ old('title', $contactUsSettings['contact_us_title']) }}" class="form-control" required>
                                        @error('title')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('Description') }}</label>
                                        <textarea name="description" class="form-control" required>{{ old('description', $contactUsSettings['contact_us_description']) }}</textarea>
                                        @error('description')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('Email') }}</label>
                                        <input type="email" name="email" value="{{ old('email', $contactUsSettings['contact_us_email']) }}" class="form-control" required>
                                        @error('email')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">{{ __('Phone Numbers') }}</label>
                                        <div id="phone-numbers-container">
                                            @foreach (old('phone_numbers', $contactUsSettings['contact_us_phone_numbers']) as $phone)
                                                <div class="input-group mb-2">
                                                    <input type="text" name="phone_numbers[]" value="{{ $phone }}" class="form-control">
                                                    <button type="button" class="btn btn-outline-danger" onclick="removeField(this)"><i class="fa fa-trash"></i></button>
                                                </div>
                                            @endforeach
                                            <div class="input-group mb-2">
                                                <input type="text" name="phone_numbers[]" class="form-control" placeholder="{{ __('New Number') }}">
                                                <button type="button" class="btn btn-outline-danger" onclick="removeField(this)"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addField('phone-numbers-container', 'phone_numbers[]', '{{ __('New Number') }}')"><i class="fa fa-plus"></i> {{ __('Add Number') }}</button>
                                        @error('phone_numbers.*')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">{{ __('Address') }}</label>
                                        <textarea name="address" class="form-control" required>{{ old('address', $contactUsSettings['contact_us_address']) }}</textarea>
                                        @error('address')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('Map URL') }}</label>
                                        <input type="url" name="map_url" value="{{ old('map_url', $contactUsSettings['contact_us_map_url']) }}" class="form-control">
                                        @error('map_url')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">{{ __('Social Links') }}</label>
                                        <div class="row g-2">
                                            <div class="col">
                                                <input type="url" name="social_links[facebook]" value="{{ old('social_links.facebook', $contactUsSettings['contact_us_social_links']['facebook'] ?? '') }}" class="form-control" placeholder="Facebook">
                                            </div>
                                            <div class="col">
                                                <input type="url" name="social_links[twitter]" value="{{ old('social_links.twitter', $contactUsSettings['contact_us_social_links']['twitter'] ?? '') }}" class="form-control" placeholder="Twitter">
                                            </div>
                                            <div class="col">
                                                <input type="url" name="social_links[instagram]" value="{{ old('social_links.instagram', $contactUsSettings['contact_us_social_links']['instagram'] ?? '') }}" class="form-control" placeholder="Instagram">
                                            </div>
                                        </div>
                                        @error('social_links.facebook')<div class="text-danger small">{{ $message }}</div>@enderror
                                        @error('social_links.twitter')<div class="text-danger small">{{ $message }}</div>@enderror
                                        @error('social_links.instagram')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">{{ __('Form Settings') }}</label>
                                        <div class="form-check mb-2">
                                            <input type="checkbox" name="form_settings[enabled]" class="form-check-input" id="formEnabled" {{ old('form_settings.enabled', $contactUsSettings['contact_us_form_settings']['enabled'] ?? false) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="formEnabled">{{ __('Enable Contact Form') }}</label>
                                        </div>
                                        <input type="url" name="form_settings[redirect_url]" value="{{ old('form_settings.redirect_url', $contactUsSettings['contact_us_form_settings']['redirect_url'] ?? '') }}" class="form-control mb-2" placeholder="Redirect URL">
                                        @error('form_settings.enabled')<div class="text-danger small">{{ $message }}</div>@enderror
                                        @error('form_settings.redirect_url')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">{{ __('Working Hours') }}</label>
                                        <textarea name="working_hours" class="form-control">{{ old('working_hours', $contactUsSettings['contact_us_working_hours']) }}</textarea>
                                        @error('working_hours')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">{{ __('Success Message') }}</label>
                                        <textarea name="success_message" class="form-control">{{ old('success_message', $contactUsSettings['contact_us_success_message']) }}</textarea>
                                        @error('success_message')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-12 mt-3">
                                        <button type="submit" class="btn btn-primary btn-air-primary px-5">{{ __('Save Settings') }}</button>
                                    </div>
                                </form>
                            </div>
                            {{-- Services Settings --}}
                            <div class="tab-pane fade" id="services" role="tabpanel">
                                @foreach ($services as $service)
                                    <div style="margin-left: 80%">
                                        <form action="{{ route('dashboard.settings.destroyService', $service) }}" method="POST" >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-air-danger px-4" onclick="return confirm('{{ __('Are you sure?') }}')">{{ __('Delete') }}</button>
                                        </form>
                                    </div>

                                    <form action="{{ route('dashboard.settings.updateService', $service) }}" method="POST" enctype="multipart/form-data" class="row g-3 mb-4 border-bottom pb-4">
                                        @csrf
                                        @method('PUT')
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('Service Name') }}</label>
                                            <input type="text" name="name" value="{{ old('name', $service->name) }}" class="form-control" required>
                                            @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('Short Description') }}</label>
                                            <textarea name="short_description" class="form-control">{{ old('short_description', $service->short_description) }}</textarea>
                                            @error('short_description')<div class="text-danger small">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('Long Description') }}</label>
                                            <textarea name="long_description" class="form-control">{{ old('long_description', $service->long_description) }}</textarea>
                                            @error('long_description')<div class="text-danger small">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('Custom URL') }}</label>
                                            <input type="url" name="custom_url" value="{{ old('custom_url', $service->custom_url) }}" class="form-control">
                                            @error('custom_url')<div class="text-danger small">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">{{ __('Order') }}</label>
                                            <input type="number" name="order" value="{{ old('order', $service->order) }}" class="form-control" min="0">
                                            @error('order')<div class="text-danger small">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">{{ __('Status') }}</label>
                                            <div class="form-check">
                                                <input type="checkbox" name="status" class="form-check-input" id="status-{{ $service->id }}" {{ old('status', $service->status) ? 'checked' : '' }} value="1">
                                                <label class="form-check-label" for="status-{{ $service->id }}">{{ __('Active') }}</label>
                                            </div>
                                            @error('status')<div class="text-danger small">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('SEO Meta') }}</label>
                                            <input type="text" name="seo_meta[title]" value="{{ old('seo_meta.title', $service->seo_meta['title'] ?? '') }}" class="form-control mb-2" placeholder="SEO Title">
                                            <textarea name="seo_meta[description]" class="form-control" placeholder="SEO Description">{{ old('seo_meta.description', $service->seo_meta['description'] ?? '') }}</textarea>
                                            @error('seo_meta.title')<div class="text-danger small">{{ $message }}</div>@enderror
                                            @error('seo_meta.description')<div class="text-danger small">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">{{ __('Service Image') }}</label>
                                            <div class="d-flex justify-content-center align-items-center mb-2" style="height:120px;">
                                                @foreach ($service->media as $image)
                                                    <img src="{{ asset($image->url) }}" class="img-thumbnail shadow-sm me-2" style="max-width:100px; max-height:100px; object-fit:contain;" alt="Service Image" />
                                                @endforeach
                                            </div>
                                            <input type="file" name="image" accept="image/*" class="form-control">
                                            @error('image')<div class="text-danger small">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-9 d-flex gap-2 align-items-center mt-2">
                                            <button type="submit" class="btn btn-primary btn-air-primary px-4">{{ __('Update Service') }}</button>
                                        </div>
                                    </form>

                                @endforeach
                                <h4 class="mt-4 mb-3">{{ __('Add New Service') }}</h4>
                                <form action="{{ route('dashboard.settings.storeService') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                                    @csrf
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('Service Name') }}</label>
                                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                                        @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('Short Description') }}</label>
                                        <textarea name="short_description" class="form-control">{{ old('short_description') }}</textarea>
                                        @error('short_description')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('Long Description') }}</label>
                                        <textarea name="long_description" class="form-control">{{ old('long_description') }}</textarea>
                                        @error('long_description')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('Custom URL') }}</label>
                                        <input type="url" name="custom_url" value="{{ old('custom_url') }}" class="form-control">
                                        @error('custom_url')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">{{ __('Order') }}</label>
                                        <input type="number" name="order" value="{{ old('order', 0) }}" class="form-control" min="0">
                                        @error('order')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">{{ __('Status') }}</label>
                                        <div class="form-check">
                                            <input type="checkbox" name="status" class="form-check-input" id="status-new" {{ old('status', true) ? 'checked' : '' }} value="1">
                                            <label class="form-check-label" for="status-new">{{ __('Active') }}</label>
                                        </div>
                                        @error('status')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('SEO Meta') }}</label>
                                        <input type="text" name="seo_meta[title]" value="{{ old('seo_meta.title') }}" class="form-control mb-2" placeholder="SEO Title">
                                        <textarea name="seo_meta[description]" class="form-control" placeholder="SEO Description">{{ old('seo_meta.description') }}</textarea>
                                        @error('seo_meta.title')<div class="text-danger small">{{ $message }}</div>@enderror
                                        @error('seo_meta.description')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('Service Image') }}</label>
                                        <div class="d-flex justify-content-center align-items-center mb-2" style="height:120px;">
                                            <!-- No preview for new service -->
                                        </div>
                                        <input type="file" name="image" accept="image/*" class="form-control">
                                        @error('image')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-12 mt-3">
                                        <button type="submit" class="btn btn-primary btn-air-primary px-5">{{ __('Add Service') }}</button>
                                    </div>
                                </form>
                            </div>
                            {{-- Terms & Conditions Settings --}}
                            <div class="tab-pane fade" id="terms" role="tabpanel">
                                <form action="{{ route('dashboard.settings.updateTerms') }}" method="POST" class="row g-3">
                                    @csrf
                                    <div class="col-md-12">
                                        <label class="form-label">{{ __('Description') }}</label>
                                        <textarea name="terms_description" class="form-control" rows="3">{{ old('terms_description', $legalSettings['terms_description'] ?? '') }}</textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">{{ __('Terms Content') }}</label>
                                        <textarea name="terms_content" class="form-control" rows="10">{{ old('terms_content', $legalSettings['terms_content'] ?? '') }}</textarea>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <button type="submit" class="btn btn-primary btn-air-primary px-5">{{ __('Save Terms & Conditions') }}</button>
                                    </div>
                                </form>
                            </div>
                            {{-- Privacy Policy Settings --}}
                            <div class="tab-pane fade" id="privacy" role="tabpanel">
                                <form action="{{ route('dashboard.settings.updatePrivacy') }}" method="POST" class="row g-3">
                                    @csrf
                                    <div class="col-md-12">
                                        <label class="form-label">{{ __('Description') }}</label>
                                        <textarea name="privacy_description" class="form-control" rows="3">{{ old('privacy_description', $legalSettings['privacy_description'] ?? '') }}</textarea>
                                    </div>
                                    <div class="col-4 mt-3">
                                        <button type="submit" class="btn btn-primary btn-air-primary px-5">{{ __('Save Privacy Policy') }}</button>
                                    </div>
                                </form>

                                <div class="col-md-12">
                                    <label class="form-label">{{ __('Sections') }}</label>
                                    <div id="privacy-sections-container">
                                        @php
                                            $privacySections = old('privacy_sections', $legalSettings['privacy_sections'] ?? []);
                                        @endphp
                                        @foreach ($privacySections as $i => $section)
                                        <div class="row">
                                            <form action="{{ route('dashboard.settings.updatePrivacy') }}" method="POST" class="row g-3 col-md-11">
                                                @csrf
                                                <div class="input-group mb-2">
                                                    <input type="text" name="privacy_sections[{{ $i }}][title]" value="{{ $section['title'] ?? '' }}" class="form-control col-md-5 me-2" placeholder="{{ __('Section Title') }}">
                                                    <textarea name="privacy_sections[{{ $i }}][content]" class="form-control col-md-5" placeholder="{{ __('Section Content') }}">{{ $section['content'] ?? '' }}</textarea>
                                                    <button type="submit" style="margin-left: 2%" class="btn btn-primary btn-air-primary col-md-1"><i class="fa fa-check"></i></button>

                                                </div>
                                            </form>
                                            <form action="{{ route('dashboard.settings.updatePrivacy') }}" method="POST" class="row g-3 col-md-1">
                                                @csrf
                                                <input type="hidden" name="privacy_sections[{{ $i }}][title]" value="{{null}}" >
                                                <button type="submit" class="btn btn-outline-danger mb-2">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        @endforeach
                                        <div class="row">
                                            <form action="{{ route('dashboard.settings.updatePrivacy') }}" method="POST" class="row g-3">
                                                @csrf
                                                <div class="input-group mb-2">
                                                    <input type="text" name="privacy_sections[0][title]" class="col-md-5 form-control me-2" placeholder="{{ __('Section Title') }}">
                                                    <textarea name="privacy_sections[0][content]" class="col-md-5 form-control" style="margin-right: 1%" placeholder="{{ __('Section Content') }}"></textarea>
                                                    <button type="submit" class="col-md-2 btn btn-outline-primary btn-sm" style="margin-left: 1%; margin-right: 0.5%"><i class="fa fa-plus"></i> {{ __('Add Section') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- FAQ Settings --}}
                            <div class="tab-pane fade" id="faq" role="tabpanel">
                                <form action="{{ route('dashboard.settings.updateFaq') }}" method="POST" class="row g-3">

                                    @csrf
                                    <div class="col-md-12">
                                        <label class="form-label">{{ __('Description') }}</label>
                                        <textarea name="faq_description" class="form-control" rows="3">{{ old('faq_description', $legalSettings['faq_description'] ?? '') }}</textarea>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <button type="submit" class="btn btn-primary btn-air-primary px-5">{{ __('Save FAQ') }}</button>
                                    </div>
                                </form>
                                <div class="col-md-12">
                                    <label class="col-md-3 ms-3 form-label">{{ __('Questions') }}</label>
                                    <label class="col-md-3 ms-3 form-label">{{ __('Answer') }}</label>
                                    <label class="col-md-3 ms-3 form-label">{{ __('Category') }}</label>
                                    <div id="faq-questions-container">
                                        @php
                                            $faqQuestions =  $legalSettings['faq_questions'] ;
                                        @endphp
                                        @foreach ($faqQuestions as $i => $q)
                                        <div class="row">
                                            <form action="{{ route('dashboard.settings.updateFaq') }}" method="POST" class="row g-3 col-md-11 ">
                                                @csrf
                                                <div class="input-group">
                                                    <input type="text" name="faq_questions[{{ $i }}][question]" value="{{ $q['question'] ?? '' }}" class="col-md-3 form-control me-2" placeholder="{{ __('Question') }}">
                                                    <textarea name="faq_questions[{{ $i }}][answer]" class="col-md-5 form-control" placeholder="{{ __('Answer') }}">{{ $q['answer'] ?? '' }}</textarea>
                                                    <input type="text" name="faq_questions[{{ $i }}][category]" value="{{ $q['category'] ?? '' }}" class="col-md-2 form-control ms-2" placeholder="{{ __('Category (optional)') }}">
                                                    <button type="submit" class="col-md-1 btn btn-primary update-btn " style="margin-left: 2%">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                </div>
                                            </form>

                                            <form action="{{ route('dashboard.settings.updateFaq') }}" method="POST" class="row g-3 col-md-1" >
                                                @csrf
                                                <input type="hidden" name="faq_questions[{{ $i }}][question]" value="{{null}}">
                                                <button type="submit" class="btn btn-outline-danger">
                                                <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        @endforeach
                                        <form action="{{ route('dashboard.settings.updateFaq') }}" method="POST" class="row g-3 mt-5">
                                            @csrf
                                            <div class="input-group">
                                                    <input type="text" name="faq_questions[0][question]" class="form-control" placeholder="{{ __('Question') }}">


                                                    <textarea name="faq_questions[0][answer]" class="form-control ms-2" placeholder="{{ __('Answer') }}"></textarea>


                                                    <input type="text" name="faq_questions[0][category]" class="col-md-5 form-control ms-2" placeholder="{{ __('Category (optional)') }}">


                                                    {{-- <button type="submit" class="btn btn-outline-danger" onclick="removeField(this)"><i class="fa fa-trash"></i></button> --}}
                                                    <button type="submit" class="col-md-2 btn btn-outline-primary btn-sm me-3 ms-2" >
                                                        <i class="fa fa-plus"></i> {{ __('Add Question') }}
                                                    </button>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Bootstrap 5 tab activation (if not already handled globally)
        var triggerTabList = [].slice.call(document.querySelectorAll('#settingsTab a'))
        triggerTabList.forEach(function (triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl)
            triggerEl.addEventListener('click', function (event) {
                event.preventDefault()
                tabTrigger.show()
            })
        })
        function addField(containerId, name, placeholder) {
            const container = document.getElementById(containerId);
            const div = document.createElement('div');
            div.className = 'input-group mb-2';
            div.innerHTML = `
                <input type="text" name="${name}" class="form-control" placeholder="${placeholder}">
                <button type="button" class="btn btn-outline-danger" onclick="removeField(this)"><i class="fa fa-trash"></i></button>
            `;
            container.appendChild(div);
        }
        function removeField(button) {
            button.parentElement.remove();
        }
        function addPrivacySection() {
            const container = document.getElementById('privacy-sections-container');
            const div = document.createElement('div');
            div.className = 'input-group mb-2';
            div.innerHTML = `
                <input type="text" name="privacy_sections[][title]" class="form-control me-2" placeholder="{{ __('Section Title') }}">
                <textarea name="privacy_sections[][content]" class="form-control" placeholder="{{ __('Section Content') }}"></textarea>
                <button type="button" class="btn btn-outline-danger" onclick="removeField(this)"><i class="fa fa-trash"></i></button>
            `;
            container.appendChild(div);
        }
        function addFaqQuestion() {
            const container = document.getElementById('faq-questions-container');
            const row = document.createElement('div');
            row.className = 'row mb-2 align-items-end faq-question-row';
            row.innerHTML = `
                <div class="col-md-4">
                    <input type="text" name="faq_questions[][question]" class="form-control" placeholder="{{ __('Question') }}">
                </div>
                <div class="col-md-4">
                    <textarea name="faq_questions[][answer]" class="form-control" placeholder="{{ __('Answer') }}"></textarea>
                </div>
                <div class="col-md-3">
                    <input type="text" name="faq_questions[][category]" class="form-control" placeholder="{{ __('Category (optional)') }}">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-outline-danger" onclick="removeField(this)"><i class="fa fa-trash"></i></button>
                </div>
            `;
            container.appendChild(row);
        }
    </script>
    @endpush
@endsection