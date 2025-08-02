document.addEventListener('DOMContentLoaded', function () {
    // Fetch filter data and populate dropdowns
    fetch('/salons/filters')
        .then(res => res.json())
        .then(data => {
            populateFilterDropdowns(data);
            // Set initial filter values from URL parameters
            setInitialFilterValues();
            // Fetch and render salons with initial filters
            fetchAndRenderSalons();
            // Initialize the map with filtered salons
            initMap();
        })
        .catch(error => {
            console.error('Error fetching filter data:', error);
        });

    // Setup event listeners for all filters and sort controls (with null checks)
    const searchInput = document.getElementById('searchInput');
    if (searchInput) searchInput.addEventListener('input', () => { fetchAndRenderSalons(); initMap(); });
    const searchButton = document.getElementById('searchButton');
    if (searchButton) searchButton.addEventListener('click', () => { fetchAndRenderSalons(); initMap(); });
    const serviceType = document.getElementById('serviceType');
    if (serviceType) serviceType.addEventListener('change', () => { fetchAndRenderSalons(); initMap(); });
    const city = document.getElementById('city');
    if (city) city.addEventListener('change', () => { fetchAndRenderSalons(); initMap(); });
    const priceFilter = document.getElementById('priceFilter');
    if (priceFilter) priceFilter.addEventListener('change', () => { fetchAndRenderSalons(); initMap(); });
    const hasOffers = document.getElementById('hasOffers');
    if (hasOffers) hasOffers.addEventListener('change', () => { fetchAndRenderSalons(); initMap(); });
    const sortBy = document.getElementById('sortBy');
    if (sortBy) {
        sortBy.innerHTML = `
            <option value="">ترتيب حسب</option>
            <option value="lowest-price">الأسعار الأقل</option>
            <option value="highest-price">الأسعار الأعلى</option>
        `;
        sortBy.addEventListener('change', () => { fetchAndRenderSalons(); initMap(); });
    }

    function populateFilterDropdowns(data) {
        // Subservices
        const serviceType = document.getElementById('serviceType');
        if (serviceType) {
            serviceType.innerHTML = '<option value="">جميع الخدمات</option>' +
                data.subservices.map(s => `<option value="${s.name}">${s.name}</option>`).join('');
        }
        // Cities
        const city = document.getElementById('city');
        if (city) {
            city.innerHTML = '<option value="">جميع المدن</option>' +
                data.cities.map(c => `<option value="${c.id}" data-lat="${c.latitude}" data-lng="${c.longitude}">${c.name}</option>`).join('');
        }
        // Price filter
        const priceFilter = document.getElementById('priceFilter');
        if (priceFilter) {
            let min = Math.floor(data.price_min);
            let max = Math.ceil(data.price_max);
            let step = Math.max(50, Math.round((max - min) / 4));
            let options = `<option value="">تصفية السعر</option>`;
            for (let i = min; i < max; i += step) {
                let to = Math.min(i + step - 1, max);
                options += `<option value="${i}-${to}">${i} - ${to} ريال</option>`;
            }
            priceFilter.innerHTML = options;
        }
    }

    function setInitialFilterValues() {
        const urlParams = new URLSearchParams(window.location.search);
        const searchInput = document.getElementById('searchInput');
        const serviceType = document.getElementById('serviceType');
        const city = document.getElementById('city');
        const priceFilter = document.getElementById('priceFilter');
        const hasOffers = document.getElementById('hasOffers');

        if (searchInput && urlParams.has('search')) {
            searchInput.value = urlParams.get('search');
        }

        if (serviceType && urlParams.has('service_type')) {
            const serviceTypeValue = urlParams.get('service_type');
            const checkServiceType = () => {
                if (serviceType.options.length > 1) {
                    if (Array.from(serviceType.options).find(opt => opt.value === serviceTypeValue)) {
                        serviceType.value = serviceTypeValue;
                    }
                } else {
                    setTimeout(checkServiceType, 100);
                }
            };
            checkServiceType();
        }

        if (city && urlParams.has('city_id')) {
            const cityId = urlParams.get('city_id');
            const checkCity = () => {
                if (city.options.length > 1) {
                    if (Array.from(city.options).find(opt => opt.value === cityId)) {
                        city.value = cityId;
                    }
                } else {
                    setTimeout(checkCity, 100);
                }
            };
            checkCity();
        }

        if (priceFilter && urlParams.has('price_min') && urlParams.has('price_max')) {
            const priceMin = urlParams.get('price_min');
            const priceMax = urlParams.get('price_max');
            const checkPriceFilter = () => {
                if (priceFilter.options.length > 1) {
                    const priceOption = Array.from(priceFilter.options).find(opt => opt.value === `${priceMin}-${priceMax}`);
                    if (priceOption) {
                        priceFilter.value = `${priceMin}-${priceMax}`;
                    }
                } else {
                    setTimeout(checkPriceFilter, 100);
                }
            };
            checkPriceFilter();
        }

        if (hasOffers && urlParams.has('has_offer')) {
            hasOffers.checked = parseInt(urlParams.get('has_offer')) === 1;
        }
    }

    function getFilters() {
        const priceVal = priceFilter ? priceFilter.value : '';
        let price_min = '', price_max = '';
        if (priceVal && priceVal.includes('-')) {
            [price_min, price_max] = priceVal.split('-');
        }
        return {
            search: searchInput ? searchInput.value : '',
            service_type: serviceType ? serviceType.value : '',
            city_id: city ? city.value : '',
            price_min,
            price_max,
            has_offer: hasOffers && hasOffers.checked ? 1 : 0,
            sort: sortBy ? sortBy.value : '',
        };
    }

    function fetchAndRenderSalons() {
        const filters = getFilters();
        const params = new URLSearchParams(filters);
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.forEach((value, key) => {
            if (!params.has(key)) {
                params.set(key, value);
            }
        });

        fetch('/salons/list?' + params.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(res => res.json())
            .then(data => {
                renderSalons(data.salons);
                const resultsCount = document.getElementById('resultsCount');
                if (resultsCount) resultsCount.textContent = data.salons.length;
            })
            .catch(error => {
                console.error('Error fetching salons:', error);
            });
    }

    function renderSalons(salons) {
        const grid = document.getElementById('salonsGrid');
        if (!grid) return;
        if (!salons.length) {
            grid.innerHTML = '<div class="text-center py-5">لا توجد نتائج</div>';
            return;
        }
        grid.innerHTML = salons.map(salon => salonCardTemplate(salon)).join('');
        if (window.lucide && typeof window.lucide.createIcons === 'function') window.lucide.createIcons();
    }

    function salonCardTemplate(salon) {
        let subServices = Array.isArray(salon.sub_services) ? salon.sub_services : [];
        let subServiceTags = subServices.slice(0, 3).map(s =>
            typeof s === 'string' ? `<span class="service-tag">${s}</span>` : `<span class="service-tag">${s.name ?? s}</span>`
        ).join('');
        let moreTag = (subServices.length > 3) ? `<span class="service-more">+${subServices.length - 3} المزيد</span>` : '<br/>';
        let salonShowUrl = window.routes && window.routes.salonShow ? window.routes.salonShow.replace(':id', salon.id) : '#';
        let badgeContent = salon.type === 'beauty_center'
            ? `<i data-lucide="award"></i> مركز معتمد`
            : `<i style="width: 20px; height:20px;" data-lucide="home"></i> صالون منزلي`;
        let isFavorited = salon.is_favorited ? 'active' : '';
        let favoriteButton = `
            <button class="salon-fa-vorite ${isFavorited}" data-salon-id="${salon.id}" onclick="toggleFavorite(${salon.id})">
                <i data-lucide="heart"></i>
            </button>
        `;
        return `
        <div class="salon-card">
            <div class="salon-image-container">
                <img src="${salon.cover_image_url ?? 'https://images.unsplash.com/photo-1560066984-138dadb4c035?w=400'}"
                    alt="${salon.name}" class="salon-image">
                 <div class="salon-badge featured">
                    ${badgeContent}
                </div>
                ${favoriteButton}
                <div class="salon-status ${salon.is_open ? 'open' : 'closed'}">
                    <div class="status-dot"></div>
                    ${salon.is_open ? 'مفتوح' : 'مغلق'}
                </div>
            </div>
            <div class="salon-content">
                <h3 class="salon-name">${salon.name}</h3>
                <div class="salon-rating">
                    <div class="rating-stars">
                        <i data-lucide="star" class="star filled"></i>
                        <span class="rating-number">${salon.rating ?? '4.9'}</span>
                    </div>
                    <span class="reviews-count">(${salon.review_count ?? '24'} تقييم)</span>
                </div>
                <div class="salon-location">
                    <i data-lucide="map-pin"></i>
                    <span>${salon.city_name ?? '-'}${salon.address ? ' - ' + salon.address : ''}</span>
                </div>
                <div class="salon-services">
                    ${subServiceTags}
                    ${moreTag}
                </div>
                <div class="salon-price">
                    ${salon.price_range
                ? (salon.price_range.min == salon.price_range.max
                    ? salon.price_range.min
                    : `${salon.price_range.min}-${salon.price_range.max} ريال`)
                : 'لا يوجد أسعار'}
                </div>
                <div class="salon-offer">${salon.offer_text ?? 'خصم 20% على الجلسة الأولى'}</div>
                <a href="${salonShowUrl}" class="btn btn-primary salon-book-btn">احجزي موعدك</a>
            </div>
        </div>
        `;
    }

    function toggleFavorite(salonId) {
        if (!window.isAuthenticated) {
            alert('يرجى تسجيل الدخول لإضافة الصالون إلى المفضلة.');
            return;
        }

        const button = document.querySelector(`button[data-salon-id="${salonId}"]`);

        fetch(window.routes.toggleFavorite, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.csrfToken,
            },
            body: JSON.stringify({ salon_id: salonId }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    button.classList.toggle('active', data.is_favorited);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('حدث خطأ أثناء الاتصال بالخادم، حاول مرة أخرى.');
            });
    }

    function initMap() {
        const filters = getFilters();
        const params = new URLSearchParams(filters);
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.forEach((value, key) => {
            if (!params.has(key)) {
                params.set(key, value);
            }
        });

        // Default coordinates (Saudi Arabia)
        let centerLat = 24.7135517;
        let centerLng = 46.6752957;

        // Get selected city coordinates
        const citySelect = document.getElementById('city');
        if (citySelect && citySelect.value) {
            const selectedOption = citySelect.options[citySelect.selectedIndex];
            centerLat = parseFloat(selectedOption.getAttribute('data-lat')) || centerLat;
            centerLng = parseFloat(selectedOption.getAttribute('data-lng')) || centerLng;
        }

        const locationIcon = window.routes.locationIcon;

        // Initialize the map
        const map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: centerLat, lng: centerLng },
            zoom: 12
        });

        // Fetch salons based on filters
        fetch('/salons/list?' + params.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(res => res.json())
            .then(data => {
                const salons = data.salons;
                // Clear existing markers
                const markers = [];

                // Create a marker for each salon
                salons.forEach(salon => {
                    if (salon.latitude && salon.longitude) {
                        const marker = new google.maps.Marker({
                            position: {
                                lat: parseFloat(salon.latitude),
                                lng: parseFloat(salon.longitude)
                            },
                            map: map,
                            icon: {
                                url: locationIcon,
                                scaledSize: new google.maps.Size(40, 40),
                                origin: new google.maps.Point(0, 0),
                                anchor: new google.maps.Point(15, 30)
                            },
                            title: salon.name
                        });

                        const statusText = salon.is_open
                            ? '<span style="color: green;">مفتوح</span>'
                            : '<span style="color: red;">مغلق</span>';

                        const infoWindow = new google.maps.InfoWindow({
                            minWidth: "400px",
                            content: `
                                <div class="row" dir="ltr">
                                    <div class="col-md-6 me-0 ms-0">
                                        <img src="${salon.cover_image_url ?? 'https://images.unsplash.com/photo-1560066984-138dadb4c035?w=400'}"
                                             alt="${salon.name}"
                                             style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px; margin-bottom: 5px;">
                                    </div>
                                    <div class="col-md-6 me-0 ms-0">
                                        <h5 class="me-0 ms-0" style="color: #f56476;">${salon.name}</h5>
                                        <p dir="rtl">الحالة: ${statusText}</p>
                                    </div>
                                </div>
                            `
                        });

                        // Open info window on click
                        marker.addListener('click', () => {
                            infoWindow.open(map, marker);
                        });

                        markers.push(marker);
                    }
                });

                // Adjust map bounds to fit all markers if there are any
                if (markers.length > 0) {
                    const bounds = new google.maps.LatLngBounds();
                    markers.forEach(marker => bounds.extend(marker.getPosition()));
                    map.fitBounds(bounds);
                }
            })
            .catch(error => {
                console.error('Error fetching salons for map:', error);
            });

        // Add Places Autocomplete
        const input = document.createElement('input');
        input.id = 'place-autocomplete-card';
        input.className = 'place-autocomplete-card';
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        const autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);

        autocomplete.addListener('place_changed', function () {
            const place = autocomplete.getPlace();
            if (place.geometry) {
                map.setCenter(place.geometry.location);
                const marker = new google.maps.Marker({
                    position: place.geometry.location,
                    map: map,
                    icon: {
                        url: locationIcon,
                        scaledSize: new google.maps.Size(40, 40),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(15, 30)
                    }
                });
                document.getElementById('latitude').value = place.geometry.location.lat();
                document.getElementById('longitude').value = place.geometry.location.lng();
            }
        });
    }

    // Initialize Lucide icons
    lucide.createIcons();
});
