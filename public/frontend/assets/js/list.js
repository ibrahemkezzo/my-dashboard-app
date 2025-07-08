// Hairdressers Page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Sample salon data with real beauty center images
    const salonsData = [
        {
            id: 1,
            name: 'صالون النخبة للسيدات',
            image: 'https://images.unsplash.com/photo-1560066984-138dadb4c035?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
            description: 'صالون متخصص في قص وتصفيف الشعر مع خدمات العناية بالبشرة والمكياج',
            priceCategory: 'expensive',
            rating: 4.8,
            reviewCount: 127,
            workingHours: '9:00 ص - 10:00 م',
            hasOffer: true,
            offerText: 'خصم 20%',
            city: 'riyadh',
            serviceTypes: ['hair', 'skincare', 'makeup'],
            price: 450,
            certified: true,
            homeBased: false,
            isFavorite: false
        },
        {
            id: 2,
            name: 'بيوتي لاونج',
            image: 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
            description: 'مركز شامل للعناية بالجمال يقدم جميع خدمات التجميل والعناية',
            priceCategory: 'moderate',
            rating: 4.6,
            reviewCount: 89,
            workingHours: '10:00 ص - 9:00 م',
            hasOffer: false,
            city: 'jeddah',
            serviceTypes: ['hair', 'nails', 'makeup'],
            price: 280,
            certified: true,
            homeBased: false,
            isFavorite: false
        },
        {
            id: 3,
            name: 'خبيرة التجميل - سارة',
            image: 'https://images.unsplash.com/photo-1516975080664-ed2fc6a32937?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
            description: 'خدمات تجميل منزلية متخصصة في المكياج والعناية بالبشرة',
            priceCategory: 'cheap',
            rating: 4.9,
            reviewCount: 156,
            workingHours: '8:00 ص - 8:00 م',
            hasOffer: true,
            offerText: 'باقة العروس',
            city: 'riyadh',
            serviceTypes: ['makeup', 'bridal', 'skincare'],
            price: 180,
            certified: false,
            homeBased: true,
            isFavorite: false
        },
        {
            id: 4,
            name: 'مركز الليزر المتقدم',
            image: 'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
            description: 'مركز متخصص في إزالة الشعر بالليزر والعلاجات التجميلية المتقدمة',
            priceCategory: 'expensive',
            rating: 4.7,
            reviewCount: 93,
            workingHours: '9:00 ص - 7:00 م',
            hasOffer: false,
            city: 'dammam',
            serviceTypes: ['laser'],
            price: 600,
            certified: true,
            homeBased: false,
            isFavorite: false
        },
        {
            id: 5,
            name: 'استوديو الأظافر الفني',
            image: 'https://images.unsplash.com/photo-1604654894610-df63bc536371?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
            description: 'استوديو متخصص في تصميم وتجميل الأظافر بأحدث التقنيات',
            priceCategory: 'moderate',
            rating: 4.5,
            reviewCount: 74,
            workingHours: '11:00 ص - 9:00 م',
            hasOffer: true,
            offerText: 'مانيكير + باديكير',
            city: 'riyadh',
            serviceTypes: ['nails'],
            price: 220,
            certified: false,
            homeBased: false,
            isFavorite: false
        },
        {
            id: 6,
            name: 'صالون الملكة',
            image: 'https://images.unsplash.com/photo-1562322140-8baeececf3df?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
            description: 'صالون فاخر يقدم خدمات الشعر والتجميل على أعلى مستوى',
            priceCategory: 'expensive',
            rating: 4.9,
            reviewCount: 201,
            workingHours: '10:00 ص - 11:00 م',
            hasOffer: false,
            city: 'jeddah',
            serviceTypes: ['hair', 'makeup', 'bridal'],
            price: 750,
            certified: true,
            homeBased: false,
            isFavorite: false
        }
    ];

    let filteredSalons = [...salonsData];
    let currentSort = 'lowest-price';

    // Initialize page
    function initializePage() {
        renderSalons();
        setupEventListeners();
    }

    // Setup event listeners
    function setupEventListeners() {
        // Search event listeners
        document.getElementById('searchInput').addEventListener('input', applyFilters);
        document.getElementById('searchButton').addEventListener('click', applyFilters);

        // Filter event listeners
        document.getElementById('serviceType').addEventListener('change', applyFilters);
        document.getElementById('city').addEventListener('change', applyFilters);
        document.getElementById('priceRange').addEventListener('change', applyFilters);
        document.getElementById('date').addEventListener('change', applyFilters);
        document.getElementById('hasOffers').addEventListener('change', applyFilters);
        document.getElementById('newClient').addEventListener('change', applyFilters);
        document.getElementById('packages').addEventListener('change', applyFilters);

        // Sort and price filter event listeners
        document.getElementById('sortBy').addEventListener('change', function() {
            currentSort = this.value;
            applySorting();
        });
        
        document.getElementById('priceFilter').addEventListener('change', applyFilters);
    }

    // Apply filters
    function applyFilters() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
        const serviceType = document.getElementById('serviceType').value;
        const city = document.getElementById('city').value;
        const priceRange = document.getElementById('priceRange').value;
        const priceFilter = document.getElementById('priceFilter').value;
        const hasOffers = document.getElementById('hasOffers').checked;

        filteredSalons = salonsData.filter(salon => {
            // Search filter
            if (searchTerm) {
                const searchMatch = salon.name.toLowerCase().includes(searchTerm) ||
                                    salon.description.toLowerCase().includes(searchTerm) ||
                                    salon.serviceTypes.some(type => {
                                        const serviceNames = {
                                            'hair': 'شعر صالون',
                                            'skincare': 'عناية بشرة',
                                            'makeup': 'مكياج',
                                            'nails': 'أظافر',
                                            'bridal': 'عروس',
                                            'laser': 'ليزر'
                                        };
                                        return serviceNames[type] && serviceNames[type].includes(searchTerm);
                                    });
                if (!searchMatch) return false;
            }

            // Service type filter
            if (serviceType && !salon.serviceTypes.includes(serviceType)) {
                return false;
            }

            // City filter
            if (city && salon.city !== city) {
                return false;
            }

            // Price range filter
            if (priceRange) {
                if (priceRange === 'cheap' && salon.priceCategory !== 'cheap') return false;
                if (priceRange === 'moderate' && salon.priceCategory !== 'moderate') return false;
                if (priceRange === 'expensive' && salon.priceCategory !== 'expensive') return false;
            }

            // Price filter
            if (priceFilter) {
                const price = salon.price;
                if (priceFilter === '50-200' && (price < 50 || price > 200)) return false;
                if (priceFilter === '200-500' && (price < 200 || price > 500)) return false;
                if (priceFilter === '500-1000' && (price < 500 || price > 1000)) return false;
                if (priceFilter === '1000+' && price < 1000) return false;
            }

            // Offers filter
            if (hasOffers && !salon.hasOffer) {
                return false;
            }

            return true;
        });

        applySorting();
    }

    // Apply sorting
    function applySorting() {
        switch (currentSort) {
            case 'lowest-price':
                filteredSalons.sort((a, b) => a.price - b.price);
                break;
            case 'highest-price':
                filteredSalons.sort((a, b) => b.price - a.price);
                break;
            case 'highest-rating':
                filteredSalons.sort((a, b) => b.rating - a.rating);
                break;
            case 'lowest-rating':
                filteredSalons.sort((a, b) => a.rating - b.rating);
                break;
            case 'certified':
                filteredSalons.sort((a, b) => b.certified - a.certified);
                break;
            case 'home-based':
                filteredSalons.sort((a, b) => b.homeBased - a.homeBased);
                break;
        }
        renderSalons();
    }

    // Toggle favorite
    function toggleFavorite(salonId) {
        const salon = salonsData.find(s => s.id === salonId);
        if (salon) {
            salon.isFavorite = !salon.isFavorite;
            renderSalons();
        }
    }

    // Render salons
    function renderSalons() {
        const salonsGrid = document.getElementById('salonsGrid');
        const resultsCount = document.getElementById('resultsCount');
        
        resultsCount.textContent = filteredSalons.length;

        if (filteredSalons.length === 0) {
            salonsGrid.innerHTML = `
                <div class="no-results">
                    <p>لا توجد نتائج مطابقة لبحثك</p>
                    <p>جربي تعديل معايير البحث</p>
                </div>
            `;
            return;
        }

        salonsGrid.innerHTML = filteredSalons.map(salon => `
            <div class="salon-card" data-salon-id="${salon.id}">
                <div class="salon-image">
                    <img src="${salon.image}" alt="${salon.name}" onerror="this.src='https://images.unsplash.com/photo-1560066984-138dadb4c035?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80'">
                    <button class="favorite-btn ${salon.isFavorite ? 'active' : ''}" onclick="toggleFavorite(${salon.id})">
                        <i class="bi bi-heart${salon.isFavorite ? '-fill' : ''}"></i>
                    </button>
                    ${salon.certified ? `
                    <div class="salon-badge featured">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="award" class="lucide lucide-award">
                            <path d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526"></path>
                            <circle cx="12" cy="8" r="6"></circle>
                        </svg>
                        مركز معتمد
                    </div>
                    ` : ''}
                </div>
                <div class="salon-card-content">
                    <div class="salon-header">
                        <div>
                            <h3 class="salon-name">${salon.name}</h3>
                        </div>
                        ${salon.hasOffer ? `<span class="offer-badge">${salon.offerText}</span>` : ''}
                    </div>
                    
                    <p class="salon-description">${salon.description}</p>
                    
                    <div class="salon-details">
                        <div class="detail-item">
                            <span class="detail-icon">💰</span>
                            <span class="price-category ${salon.priceCategory}">
                                ${getPriceCategoryText(salon.priceCategory)}
                            </span>
                        </div>
                        
                        <div class="detail-item">
                            <div class="rating">
                                <span class="stars">⭐</span>
                                <span>${salon.rating}</span>
                                <span class="rating-text">(${salon.reviewCount} تقييم)</span>
                            </div>
                        </div>
                        
                        <div class="detail-item">
                            <span class="detail-icon">🕒</span>
                            <span class="salon-working-hours">${salon.workingHours}</span>
                        </div>
                        
                        <div class="detail-item">
                            <span class="detail-icon">📍</span>
                            <span>${getCityName(salon.city)}</span>
                        </div>
                    </div>
                    
                    <div class="salon-actions">
                        <button class="btn-availability" onclick="checkAvailability(${salon.id})">
                            عرض التوافر
                        </button>
                        <button class="btn-map" onclick="viewOnMap(${salon.id})">
                            عرض على الخريطة
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
    }

    // Helper functions
    function getPriceCategoryText(category) {
        switch (category) {
            case 'cheap': return 'اقتصادي';
            case 'moderate': return 'متوسط';
            case 'expensive': return 'مرتفع';
            default: return 'غير محدد';
        }
    }

    function getCityName(city) {
        const cities = {
            'riyadh': 'الرياض',
            'jeddah': 'جدة',
            'dammam': 'الدمام',
            'mecca': 'مكة المكرمة',
            'medina': 'المدينة المنورة',
            'taif': 'الطائف'
        };
        return cities[city] || city;
    }

    // Global functions for button clicks
    window.toggleFavorite = toggleFavorite;

    window.checkAvailability = function(salonId) {
        const salon = salonsData.find(s => s.id === salonId);
        alert(`عرض التوافر لـ ${salon.name}\nهذه الميزة قيد التطوير...`);
    };

    window.viewOnMap = function(salonId) {
        const salon = salonsData.find(s => s.id === salonId);
        alert(`عرض ${salon.name} على الخريطة\nهذه الميزة قيد التطوير...`);
    };

    // Initialize page when DOM is loaded
    initializePage();

    const offersCheckbox = document.getElementById('hasOffers');
    if (offersCheckbox && offersCheckbox.checked) {
        offersCheckbox.dispatchEvent(new Event('change'));
    }
});