<form action="{{ route('front.profile.salon.manager.updateInfo') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="name" class="form-label">اسم الصالون</label>
            <input type="text" class="form-control" id="name" name="name"
                value="{{ old('name', $salon->name) }}" required>
        </div>
        <div class="col-md-6">
            <label for="email" class="form-label">البريد الإلكتروني</label>
            <input type="email" class="form-control" id="email" name="email"
                value="{{ old('email', $salon->email) }}">
        </div>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">وصف الصالون</label>
        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $salon->description) }}</textarea>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="city_id" class="form-label">المدينة</label>
            <x-form.city-select name="city_id" :selected="$salon->city_id" class="form-control" />
        </div>
        <div class="col-md-6">
            <label for="address" class="form-label">العنوان</label>
            <input type="text" class="form-control" id="address" name="address"
                value="{{ old('address', $salon->address) }}" required>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="phone" class="form-label">رقم الهاتف</label>
            <input type="text" class="form-control" id="phone" name="phone"
                value="{{ old('phone', $salon->phone) }}" required>
        </div>
        <div class="col-md-3">
            <label for="logo" class="form-label">شعار الصالون</label>
            <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
            @if ($salon->logo_url)
                <img src="{{ $salon->logo_url }}" alt="logo"
                    style="width:40px;height:40px;object-fit:cover;border-radius:50%;" class="mt-2">
            @endif
        </div>
        <div class="col-md-3">
            <label for="cover_image" class="form-label">صورة الغلاف</label>
            <input type="file" class="form-control" id="cover_image" name="cover_image" accept="image/*">
            @if ($salon->cover_image_url)
                <img src="{{ $salon->cover_image_url }}" alt="cover" style="width:40px;height:40px;object-fit:cover;"
                    class="mt-2">
            @endif
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">ساعات العمل</label>
        @php
            $days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
            $workingHours = old('working_hours', $salon->working_hours ?? []);
        @endphp
        <div class="working-hours-container">
            @foreach ($days as $day)
                <div class="working-day mb-2 row align-items-center">
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">{{ __('dashboard.' . $day) }}</label>
                    </div>
                    <div class="col-md-4">
                        <input type="time" name="working_hours[{{ $day }}][open]" class="form-control"
                            value="{{ $workingHours[$day]['open'] ?? '' }}" placeholder="من">
                    </div>
                    <div class="col-md-4">
                        <input type="time" name="working_hours[{{ $day }}][close]" class="form-control"
                            value="{{ $workingHours[$day]['close'] ?? '' }}" placeholder="إلى">
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="working_hours[{{ $day }}][closed]"
                                {{ !empty($workingHours[$day]['closed']) ? 'checked' : '' }}>
                            <label class="form-check-label">مغلق</label>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">روابط التواصل الاجتماعي</label>
        <div class="row g-2">
            <div class="col-md-4">
                <input type="url" name="social_links[facebook]"
                    value="{{ old('social_links.facebook', $salon->social_links['facebook'] ?? '') }}"
                    class="form-control" placeholder="Facebook URL">
            </div>
            <div class="col-md-4">
                <input type="url" name="social_links[instagram]"
                    value="{{ old('social_links.instagram', $salon->social_links['instagram'] ?? '') }}"
                    class="form-control" placeholder="Instagram URL">
            </div>
            <div class="col-md-4">
                <input type="url" name="social_links[twitter]"
                    value="{{ old('social_links.twitter', $salon->social_links['twitter'] ?? '') }}"
                    class="form-control" placeholder="Twitter URL">
            </div>
            <div class="col-md-4">
                <input type="url" name="social_links[tiktok]"
                    value="{{ old('social_links.tiktok', $salon->social_links['tiktok'] ?? '') }}"
                    class="form-control" placeholder="tiktok URL">
            </div>
            <div class="col-md-4">
                <input type="url" name="social_links[snapchat]"
                    value="{{ old('social_links.snapchat', $salon->social_links['snapchat'] ?? '') }}"
                    class="form-control" placeholder="snapchat URL">
            </div>
            <div class="col-md-4">
                <input type="url" name="social_links[youtube]"
                    value="{{ old('social_links.youtube', $salon->social_links['youtube'] ?? '') }}"
                    class="form-control" placeholder="youtube URL">
            </div>
        </div>
    </div>
    <!-- Features -->
    <div class="mb-3">

        <label class="form-label">المميزات المتوفرة</label>

        <div class="row g-2">
            <div class="col-md-4">
                <label class="form-check-label">
                    <input name="features[parking]" type="checkbox" @checked(old('features.parking',isset($salon->features['parking']))) class="form-checkbox" value="on">
                    <i class="fas fa-car"></i>
                    <span>موقف سيارات</span>
                </label>
            </div>
            <div class="col-md-4">
                <label class="form-check-label">
                    <input name="features[wifi]" type="checkbox" @checked(old('features.wifi',isset($salon->features['wifi']))) class="form-checkbox" value="on">
                    <i class="fas fa-wifi"></i>
                    <span>واي فاي مجاني</span>
                </label>
            </div>
            <div class="col-md-4">
                <label class="form-check-label">
                    <input name="features[ac]" type="checkbox" @checked(old('features.ac',isset($salon->features['ac']))) class="form-checkbox" value="on">
                    <i class="fas fa-snowflake"></i>
                    <span>تكييف</span>
                </label>
            </div>
            <div class="col-md-4">
                <label class="form-check-label">
                    <input name="features[waiting-area]" type="checkbox" @checked(old('features.waiting-area',isset($salon->features['waiting-area']))) class="form-checkbox" value="on">
                    <i class="fas fa-couch"></i>
                    <span>منطقة انتظار</span>
                </label>
            </div>
            <div class="col-md-4">
                <label class="form-check-label">
                    <input name="features[refreshments]" type="checkbox"  @checked(old('features.refreshments',isset($salon->features['refreshments']))) class="form-checkbox" value="on">
                    <i class="fas fa-coffee"></i>
                    <span>مشروبات مجانية</span>
                </label>
            </div>
            <div class="col-md-4">
                <label class="form-check-label">
                    <input name="features[child-care]" type="checkbox" @checked(old('features.child-care',isset($salon->features['child-care']))) class="form-checkbox" value="on">
                    <i class="fas fa-baby"></i>
                    <span>رعاية أطفال</span>
                </label>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
</form>
