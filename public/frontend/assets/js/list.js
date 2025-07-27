// Hairdressers Page JavaScript

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
        })
        .catch(error => {
            console.error('Error fetching filter data:', error);
        });

    // Setup event listeners for all filters and sort controls (with null checks)
    const searchInput = document.getElementById('searchInput');
    if (searchInput) searchInput.addEventListener('input', fetchAndRenderSalons);
    const searchButton = document.getElementById('searchButton');
    if (searchButton) searchButton.addEventListener('click', fetchAndRenderSalons);
    const serviceType = document.getElementById('serviceType');
    if (serviceType) serviceType.addEventListener('change', fetchAndRenderSalons);
    const city = document.getElementById('city');
    if (city) city.addEventListener('change', fetchAndRenderSalons);
    const priceFilter = document.getElementById('priceFilter');
    if (priceFilter) priceFilter.addEventListener('change', fetchAndRenderSalons);
    const hasOffers = document.getElementById('hasOffers');
    if (hasOffers) hasOffers.addEventListener('change', fetchAndRenderSalons);
    const sortBy = document.getElementById('sortBy');
    if (sortBy) {
        sortBy.innerHTML = `
            <option value="">ترتيب حسب</option>
            <option value="lowest-price">الأسعار الأقل</option>
            <option value="highest-price">الأسعار الأعلى</option>
        `;
        sortBy.addEventListener('change', fetchAndRenderSalons);
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
                data.cities.map(c => `<option value="${c.id}">${c.name}</option>`).join('');
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

        // Set search input if parameter exists
        if (searchInput && urlParams.has('search')) {
            searchInput.value = urlParams.get('search');
        }

        // Set service type if parameter exists
        if (serviceType && urlParams.has('service_type')) {
            const serviceTypeValue = urlParams.get('service_type');
            // Ensure dropdown is populated before setting value
            const checkServiceType = () => {
                if (serviceType.options.length > 1) {
                    if (Array.from(serviceType.options).find(opt => opt.value === serviceTypeValue)) {
                        serviceType.value = serviceTypeValue;
                    }
                } else {
                    setTimeout(checkServiceType, 100); // Retry until dropdown is populated
                }
            };
            checkServiceType();
        }

        // Set city if parameter exists
        if (city && urlParams.has('city_id')) {
            const cityId = urlParams.get('city_id');
            // Ensure dropdown is populated before setting value
            const checkCity = () => {
                if (city.options.length > 1) {
                    if (Array.from(city.options).find(opt => opt.value === cityId)) {
                        city.value = cityId;
                    }
                } else {
                    setTimeout(checkCity, 100); // Retry until dropdown is populated
                }
            };
            checkCity();
        }

        // Set price filter if parameters exist
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
                    setTimeout(checkPriceFilter, 100); // Retry until dropdown is populated
                }
            };
            checkPriceFilter();
        }

        // Set has offer if parameter exists
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
        // Add existing URL params to the fetch request to persist them
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
        // Handle sub_services as array of strings or objects
        let subServices = Array.isArray(salon.sub_services) ? salon.sub_services : [];
        let subServiceTags = subServices.slice(0, 3).map(s =>
            typeof s === 'string' ? `<span class="service-tag">${s}</span>` : `<span class="service-tag">${s.name ?? s}</span>`
        ).join('');
        let moreTag = (subServices.length > 3) ? `<span class="service-more">+${subServices.length - 3} المزيد</span>` : '<br/>';
        // Fix: Use window.routes.salonShow and replace :id with salon.id
        let salonShowUrl = window.routes && window.routes.salonShow ? window.routes.salonShow.replace(':id', salon.id) : '#';
            // Generate badge content using JavaScript conditional
        let badgeContent = salon.type === 'beauty_center'
            ? `<i data-lucide="award"></i> مركز معتمد`
            : `<i style="width: 20px; height:20px;" data-lucide="home"></i> صالون منزلي`;
        // Generate favorite button with dynamic class based on favorite status
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
    // Initialize Lucide icons
lucide.createIcons();

function toggleFavorite(salonId) {
    // Prevent action if user is not authenticated
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
            // Only toggle the 'active' class on the button
            button.classList.toggle('active', data.is_favorited);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('حدث خطأ أثناء الاتصال بالخادم، حاول مرة أخرى.');
    });
}
});
