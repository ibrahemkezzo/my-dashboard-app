
// Pages Scripts - Separate JS file for new pages

document.addEventListener('DOMContentLoaded', function() {
    // Salon Profile Page Scripts
    if (document.getElementById('favoriteBtn')) {
        initSalonProfile();
    }
    
    // My Account Page Scripts
    if (document.getElementById('accountForm')) {
        initMyAccount();
    }
    
    // Ratings Page Scripts
    if (document.querySelector('.star-rating')) {
        initRatings();
    }
    
    // FAQ Page Scripts
    if (document.querySelector('.faq-question')) {
        initFAQ();
    }
    
    // Auth Page Scripts
    if (document.querySelector('.auth-tab')) {
        initAuth();
    }
    
    // Notifications Page Scripts
    if (document.querySelector('.notification-item')) {
        initNotifications();
    }
});

// Salon Profile Page Functions
function initSalonProfile() {
    const favoriteBtn = document.getElementById('favoriteBtn');
    const shareBtn = document.getElementById('shareBtn');
    const bookNowBtn = document.getElementById('bookNowBtn');
    const confirmBookingBtn = document.getElementById('confirmBooking');
    
    // Favorite button functionality
    favoriteBtn.addEventListener('click', function() {
        const icon = this.querySelector('i');
        if (icon.classList.contains('fas')) {
            icon.classList.remove('fas');
            icon.classList.add('far');
            showToast('تم إزالة الصالون من المفضلة', 'info');
        } else {
            icon.classList.remove('far');
            icon.classList.add('fas');
            showToast('تم إضافة الصالون للمفضلة', 'success');
        }
    });
    
    // Share button functionality
    shareBtn.addEventListener('click', function() {
        if (navigator.share) {
            navigator.share({
                title: 'صالون الجمال الراقي',
                text: 'اكتشف هذا الصالون الرائع على كوافيري',
                url: window.location.href
            });
        } else {
            // Fallback for browsers that don't support Web Share API
            navigator.clipboard.writeText(window.location.href).then(function() {
                showToast('تم نسخ رابط الصالون', 'success');
            });
        }
    });
    
    // Book now button functionality
    bookNowBtn.addEventListener('click', function() {
        const modal = new bootstrap.Modal(document.getElementById('bookingModal'));
        modal.show();
        
        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('bookingDate').min = today;
    });
    
    // Confirm booking functionality
    confirmBookingBtn.addEventListener('click', function() {
        const date = document.getElementById('bookingDate').value;
        const time = document.getElementById('bookingTime').value;
        
        if (date && time) {
            const selectedDate = new Date(date);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            if (selectedDate >= today) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('bookingModal'));
                modal.hide();
                showToast('تم تأكيد حجزك بنجاح! ستصلك رسالة تأكيد قريباً', 'success');
                
                // Reset form
                document.getElementById('bookingForm').reset();
            } else {
                showToast('يرجى اختيار تاريخ في المستقبل', 'error');
            }
        } else {
            showToast('يرجى اختيار التاريخ والوقت', 'error');
        }
    });
}

// My Account Page Functions
function initMyAccount() {
    const accountForm = document.getElementById('accountForm');
    
    accountForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        
        // Check if passwords match (only if they're filled)
        if (newPassword && newPassword !== confirmPassword) {
            showToast('كلمتا المرور غير متطابقتين', 'error');
            return;
        }
        
        // Simulate saving
        showToast('تم حفظ التغييرات بنجاح', 'success');
        
        // Clear password fields
        document.getElementById('currentPassword').value = '';
        document.getElementById('newPassword').value = '';
        document.getElementById('confirmPassword').value = '';
    });
}

// Ratings Page Functions
function initRatings() {
    const starRatings = document.querySelectorAll('.star-rating');
    
    starRatings.forEach(function(rating) {
        const stars = rating.querySelectorAll('i');
        
        stars.forEach(function(star, index) {
            star.addEventListener('click', function() {
                const ratingValue = index + 1;
                rating.setAttribute('data-rating', ratingValue);
                
                // Update star display
                stars.forEach(function(s, i) {
                    if (i < ratingValue) {
                        s.classList.add('active');
                    } else {
                        s.classList.remove('active');
                    }
                });
            });
            
            star.addEventListener('mouseenter', function() {
                const hoverValue = index + 1;
                
                stars.forEach(function(s, i) {
                    if (i < hoverValue) {
                        s.style.color = '#ffc107';
                    } else {
                        s.style.color = '#ddd';
                    }
                });
            });
        });
        
        rating.addEventListener('mouseleave', function() {
            const currentRating = parseInt(rating.getAttribute('data-rating')) || 0;
            
            stars.forEach(function(s, i) {
                if (i < currentRating) {
                    s.style.color = '#ffc107';
                } else {
                    s.style.color = '#ddd';
                }
            });
        });
    });
    
    // Handle rating submission
    const ratingCards = document.querySelectorAll('.rating-card');
    ratingCards.forEach(function(card) {
        const submitBtn = card.querySelector('.btn-primary');
        if (submitBtn) {
            submitBtn.addEventListener('click', function() {
                const rating = card.querySelector('.star-rating').getAttribute('data-rating');
                const comment = card.querySelector('textarea').value;
                
                if (rating && rating > 0) {
                    showToast('تم إرسال التقييم بنجاح', 'success');
                    card.style.display = 'none';
                    
                    // Check if no more ratings
                    const remainingCards = document.querySelectorAll('.rating-card[style="display: none;"]');
                    if (remainingCards.length === ratingCards.length) {
                        document.getElementById('noRatingsState').classList.remove('d-none');
                    }
                } else {
                    showToast('يرجى اختيار تقييم أولاً', 'error');
                }
            });
        }
    });
}

// FAQ Page Functions
function initFAQ() {
    const faqQuestions = document.querySelectorAll('.faq-question');
    
    faqQuestions.forEach(function(question) {
        question.addEventListener('click', function() {
            const answer = this.nextElementSibling;
            const icon = this.querySelector('i');
            
            // Close all other answers
            faqQuestions.forEach(function(q) {
                if (q !== question) {
                    const otherAnswer = q.nextElementSibling;
                    const otherIcon = q.querySelector('i');
                    otherAnswer.classList.remove('show');
                    otherIcon.classList.remove('fa-minus');
                    otherIcon.classList.add('fa-plus');
                }
            });
            
            // Toggle current answer
            if (answer.classList.contains('show')) {
                answer.classList.remove('show');
                icon.classList.remove('fa-minus');
                icon.classList.add('fa-plus');
            } else {
                answer.classList.add('show');
                icon.classList.remove('fa-plus');
                icon.classList.add('fa-minus');
            }
        });
    });
}

// Auth Page Functions
function initAuth() {
    const authTabs = document.querySelectorAll('.auth-tab');
    const authForms = document.querySelectorAll('.auth-form');
    
    authTabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            const target = this.getAttribute('data-target');
            
            // Update active tab
            authTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            // Show target form
            authForms.forEach(f => f.classList.remove('active'));
            document.getElementById(target).classList.add('active');
        });
    });
    
    // Handle form submissions
    const loginForm = document.getElementById('loginForm');
    const signupForm = document.getElementById('signupForm');
    
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            showToast('تم تسجيل الدخول بنجاح', 'success');
            setTimeout(() => {
                window.location.href = 'index.html';
            }, 1500);
        });
    }
    
    if (signupForm) {
        signupForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const password = document.getElementById('signupPassword').value;
            const confirmPassword = document.getElementById('confirmSignupPassword').value;
            
            if (password !== confirmPassword) {
                showToast('كلمتا المرور غير متطابقتين', 'error');
                return;
            }
            
            showToast('تم إنشاء الحساب بنجاح', 'success');
            setTimeout(() => {
                window.location.href = 'index.html';
            }, 1500);
        });
    }
}

// Notifications Page Functions
function initNotifications() {
    const notificationItems = document.querySelectorAll('.notification-item');
    
    notificationItems.forEach(function(item) {
        item.addEventListener('click', function() {
            if (this.classList.contains('unread')) {
                this.classList.remove('unread');
                showToast('تم تمييز الإشعار كمقروء', 'info');
            }
        });
    });
    
    // Mark all as read functionality
    const markAllReadBtn = document.getElementById('markAllRead');
    if (markAllReadBtn) {
        markAllReadBtn.addEventListener('click', function() {
            notificationItems.forEach(function(item) {
                item.classList.remove('unread');
            });
            showToast('تم تمييز جميع الإشعارات كمقروءة', 'success');
        });
    }
}

// Utility Functions
function showToast(message, type = 'info') {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-white bg-${getBootstrapColor(type)} border-0`;
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white ms-2 m-auto no-hover-button" data-bs-dismiss="toast"></button>
        </div>
    `;
    
    // Add to toast container or create one
    let toastContainer = document.querySelector('.toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }
    
    toastContainer.appendChild(toast);
    
    // Show toast
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
    
    // Remove toast element after it's hidden
    toast.addEventListener('hidden.bs.toast', function() {
        toast.remove();
    });
}

function getBootstrapColor(type) {
    const colors = {
        'success': 'success',
        'error': 'danger',
        'info': 'info',
        'warning': 'warning'
    };
    return colors[type] || 'info';
}

// Initialize date inputs to prevent past dates
function initDateInputs() {
    const dateInputs = document.querySelectorAll('input[type="date"]');
    const today = new Date().toISOString().split('T')[0];
    
    dateInputs.forEach(function(input) {
        input.min = today;
    });
}

// Call initialization functions
initDateInputs();
