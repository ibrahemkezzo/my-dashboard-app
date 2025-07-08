
// Mobile Menu Toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
    const mobileMenuClose = document.getElementById('mobileMenuClose');
    const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');

    // Open mobile menu
    mobileMenuBtn.addEventListener('click', function() {
        mobileMenuOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    });

    // Close mobile menu
    function closeMobileMenu() {
        mobileMenuOverlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    mobileMenuClose.addEventListener('click', closeMobileMenu);

    // Close menu when clicking on overlay
    mobileMenuOverlay.addEventListener('click', function(e) {
        if (e.target === mobileMenuOverlay) {
            closeMobileMenu();
        }
    });

    // Close menu when clicking on nav links
    mobileNavLinks.forEach(link => {
        link.addEventListener('click', closeMobileMenu);
    });

    // Close menu on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileMenuOverlay.classList.contains('active')) {
            closeMobileMenu();
        }
    });

    // Search functionality
    const searchBtn = document.querySelector('.search-btn');
    const searchSelects = {
        service: document.getElementById('serviceSelect'),
        city: document.getElementById('citySelect'),
        price: document.getElementById('priceSelect'),
        rating: document.getElementById('ratingSelect')
    };

    searchBtn.addEventListener('click', function(e) {
        e.preventDefault();

        const searchData = {
            service: searchSelects.service.value,
            city: searchSelects.city.value,
            price: searchSelects.price.value,
            rating: searchSelects.rating.value
        };

        console.log('البحث عن:', searchData);

        // Show search results (placeholder functionality)
        let searchMessage = 'البحث عن: ';
        const searchTerms = [];

        if (searchData.service) searchTerms.push(`الخدمة: ${searchSelects.service.options[searchSelects.service.selectedIndex].text}`);
        if (searchData.city) searchTerms.push(`المدينة: ${searchSelects.city.options[searchSelects.city.selectedIndex].text}`);
        if (searchData.price) searchTerms.push(`السعر: ${searchSelects.price.options[searchSelects.price.selectedIndex].text}`);
        if (searchData.rating) searchTerms.push(`التقييم: ${searchSelects.rating.options[searchSelects.rating.selectedIndex].text}`);

        if (searchTerms.length > 0) {
            searchMessage += searchTerms.join(' | ');
        } else {
            searchMessage = 'يرجى اختيار معايير البحث';
        }

        alert(searchMessage);
    });

    // Salon booking functionality
    const bookingButtons = document.querySelectorAll('.salon-book-btn');
    bookingButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            if (!btn.disabled) {
                const salonCard = btn.closest('.salon-card');
                const salonName = salonCard.querySelector('.salon-name').textContent;
                alert(`تم النقر على حجز موعد في: ${salonName}`);
            }
        });
    });

    // Favorite functionality
    const favoriteButtons = document.querySelectorAll('.salon-favorite');
    favoriteButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const icon = btn.querySelector('i');
            const salonCard = btn.closest('.salon-card');
            const salonName = salonCard.querySelector('.salon-name').textContent;

            // Toggle favorite state
            if (btn.classList.contains('favorited')) {
                btn.classList.remove('favorited');
                btn.style.color = '';
                console.log(`تم إزالة ${salonName} من المفضلة`);
            } else {
                btn.classList.add('favorited');
                btn.style.color = '#F56476';
                console.log(`تم إضافة ${salonName} إلى المفضلة`);
            }
        });
    });

    // Newsletter subscription
    const newsletterBtn = document.querySelector('.newsletter-btn');
    const newsletterInput = document.querySelector('.newsletter-input');

    if (newsletterBtn && newsletterInput) {
        newsletterBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const email = newsletterInput.value.trim();

            if (email) {
                if (isValidEmail(email)) {
                    alert(`تم الاشتراك بنجاح! سيتم إرسال النشرة الإخبارية إلى: ${email}`);
                    newsletterInput.value = '';
                } else {
                    alert('يرجى إدخال عنوان بريد إلكتروني صحيح');
                }
            } else {
                alert('يرجى إدخال عنوان البريد الإلكتروني');
            }
        });

        // Allow submission with Enter key
        newsletterInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                newsletterBtn.click();
            }
        });
    }

    // Join beautician buttons
    // const joinButtons = document.querySelectorAll('.join-buttons .btn');
    // joinButtons.forEach(btn => {
    //     btn.addEventListener('click', function(e) {
    //         e.preventDefault();
    //         const buttonText = btn.textContent.trim();

    //         if (buttonText.includes('ابدئي الآن')) {
    //             alert('سيتم توجيهك إلى صفحة التسجيل كخبيرة تجميل');
    //         } else if (buttonText.includes('تعرفي على المزيد')) {
    //             alert('سيتم توجيهك إلى صفحة معلومات الانضمام كخبيرة تجميل');
    //         }
    //     });
    // });

    // Auth buttons functionality
    // const authButtons = document.querySelectorAll('.btn');
    // authButtons.forEach(btn => {
    //     const buttonText = btn.textContent.trim();

    //     if (buttonText.includes('تسجيل الدخول')) {
    //         btn.addEventListener('click', function(e) {
    //             e.preventDefault();
    //             alert('سيتم توجيهك إلى صفحة تسجيل الدخول');
    //         });
    //     } else if (buttonText.includes('انضم كخبيرة تجميل') && !btn.closest('.join-buttons')) {
    //         btn.addEventListener('click', function(e) {
    //             e.preventDefault();
    //             alert('سيتم توجيهك إلى صفحة التسجيل كخبيرة تجميل');
    //         });
    //     }
    // });

    // Smooth scrolling for anchor links
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = link.getAttribute('href');

            // Skip if it's just a hash without target
            if (href === '#' || href.length <= 1) {
                e.preventDefault();
                return;
            }

            const targetElement = document.querySelector(href);
            if (targetElement) {
                e.preventDefault();
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add animation classes when elements come into view
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
            }
        });
    }, observerOptions);

    // Observe elements for animation
    const animateElements = document.querySelectorAll('.category-card, .salon-card, .step-card, .review-card');
    animateElements.forEach(el => {
        observer.observe(el);
    });

    // Add hover effects for interactive elements
    const interactiveCards = document.querySelectorAll('.category-card, .salon-card');
    interactiveCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Console log for debugging
    console.log('Arabella Beauty - منصة حجز خدمات التجميل');
    console.log('الموقع جاهز وجميع المكونات التفاعلية تعمل بشكل صحيح');
});

// Helper function to validate email
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Add loading state management
function showLoading(element) {
    const originalText = element.textContent;
    element.textContent = 'جاري التحميل...';
    element.disabled = true;

    setTimeout(() => {
        element.textContent = originalText;
        element.disabled = false;
    }, 2000);
}

// Add keyboard navigation support
document.addEventListener('keydown', function(e) {
    // Close mobile menu with Escape key
    if (e.key === 'Escape') {
        const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
        if (mobileMenuOverlay && mobileMenuOverlay.classList.contains('active')) {
            mobileMenuOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    // Search with Ctrl/Cmd + K
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        const serviceSelect = document.getElementById('serviceSelect');
        if (serviceSelect) {
            serviceSelect.focus();
        }
    }
});

// Add performance monitoring
window.addEventListener('load', function() {
    console.log(`تم تحميل الصفحة في ${Date.now() - performance.timing.navigationStart} مللي ثانية`);
});

// Add error handling for images
document.addEventListener('DOMContentLoaded', function() {
    const images = document.querySelectorAll('img');
    images.forEach(img => {
        img.addEventListener('error', function() {
            console.warn(`فشل في تحميل الصورة: ${this.src}`);
            // You could set a fallback image here
            // this.src = 'path/to/fallback-image.jpg';
        });
    });
});
