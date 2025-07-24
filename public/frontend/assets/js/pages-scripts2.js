
// Pages Scripts 2 - Custom JavaScript for Bookings and Favorites Pages

document.addEventListener('DOMContentLoaded', function() {
    // Initialize page-specific functionality
    initBookingsPage();
    initFavoritesPage();
    initUserInteractions();
});

// User Interactions
function initUserInteractions() {
    // User dropdown functionality
    const userBtn = document.querySelector('.user-btn');
    const userMenu = document.querySelector('.dropdown-menu');

    if (userBtn && userMenu) {
        userBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleUserMenu();
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function() {
            userMenu.classList.remove('show');
        });
    }
}

function toggleUserMenu() {
    const userMenu = document.querySelector('.dropdown-menu');
    if (userMenu) {
        userMenu.classList.toggle('show');
    }
}

function toggleMobileMenu() {
    // Mobile menu functionality can be implemented here
    console.log('Mobile menu toggled');
}

// Bookings Page Functionality
function initBookingsPage() {
    if (!document.querySelector('.booking-tabs')) return;

    // Handle tab switching
    const tabButtons = document.querySelectorAll('.booking-tab');
    const tabPanes = document.querySelectorAll('.tab-pane');

    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetTab = this.dataset.tab;

            // Remove active class from all tabs and panes
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabPanes.forEach(pane => pane.classList.remove('active'));

            // Add active class to clicked tab and corresponding pane
            this.classList.add('active');
            const targetPane = document.getElementById(targetTab);
            if (targetPane) {
                targetPane.classList.add('active');
            }

            updateBookingStats(targetTab);
        });
    });

    // Handle booking actions
    // const actionButtons = document.querySelectorAll('.btn-action');
    // actionButtons.forEach(button => {
    //     button.addEventListener('click', function(e) {
    //         e.preventDefault();
    //         handleBookingAction(this);
    //     });
    // });
}

// Handle booking action clicks
function handleBookingAction(button) {
    const action = getActionType(button);
    const bookingCard = button.closest('.booking-card');
    const salonName = bookingCard.querySelector('.salon-name').textContent;

    switch(action) {
        case 'cancel':
            handleCancelBooking(salonName, bookingCard);
            break;
        case 'modify':
            handleModifyBooking(salonName);
            break;
        case 'rate':
            handleRateBooking(salonName);
            break;
        // case 'rebook':
        //     handleRebookService(salonName);
        //     break;
    }
}

function getActionType(button) {
    if (button.classList.contains('cancel')) return 'cancel';
    if (button.classList.contains('modify')) return 'modify';
    if (button.classList.contains('rate')) return 'rate';
    // if (button.classList.contains('rebook')) return 'rebook';
    return '';
}

// Cancel booking
function handleCancelBooking(salonName, card) {
    if (confirm(`هل أنت متأكدة من إلغاء حجزك في ${salonName}؟`)) {
        // Animate card removal
        card.style.transform = 'translateX(-100%)';
        card.style.opacity = '0';

        setTimeout(() => {
            card.remove();
            showNotification('تم إلغاء الحجز بنجاح', 'success');
            checkEmptyState();
        }, 300);
    }
}

// Modify booking
function handleModifyBooking(salonName) {
    showNotification(`سيتم توجيهك لتعديل حجزك في ${salonName}`, 'info');
    // Here you would typically redirect to a booking modification page
}

// Rate booking
function handleRateBooking(salonName) {
    const rating = prompt(`قيمي تجربتك في ${salonName} من 1 إلى 5:`);
    if (rating && rating >= 1 && rating <= 5) {
        showNotification('شكراً لك على التقييم!', 'success');
    }
}

// Rebook service
// function handleRebookService(salonName) {
//     showNotification(`سيتم توجيهك لحجز موعد جديد في ${salonName}`, 'info');
//     // Here you would typically redirect to the booking page
// }

// Update booking statistics
function updateBookingStats(tabType) {
    const currentTab = tabType === 'current';
    const stats = currentTab ? 'الحجوزات الحالية' : 'الحجوزات السابقة';
    console.log(`عرض: ${stats}`);
}

// Check if bookings section is empty
function checkEmptyState() {
    const currentBookings = document.querySelectorAll('#current .booking-card');
    const pastBookings = document.querySelectorAll('#past .booking-card');
    const emptyState = document.getElementById('emptyState');

    if (currentBookings.length === 0 && pastBookings.length === 0 && emptyState) {
        emptyState.classList.remove('hidden');
    }
}

// Favorites Page Functionality
function initFavoritesPage() {
    if (!document.getElementById('favoritesGrid')) return;

    // Handle favorite heart buttons
    // const heartButtons = document.querySelectorAll('.favorite-btn');
    // heartButtons.forEach(button => {
    //     button.addEventListener('click', function(e) {
    //         e.preventDefault();
    //         e.stopPropagation();
    //         handleFavoriteToggle(this);
    //     });
    // });

    // Handle sorting
    const sortSelect = document.getElementById('sortFavorites');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            handleFavoriteSort(this.value);
        });
    }

    // Handle city filtering
    const cityFilter = document.getElementById('cityFilter');
    if (cityFilter) {
        cityFilter.addEventListener('change', function() {
            handleCityFilter(this.value, this.selectedOptions[0].text);
        });
    }

    // Handle favorite actions
    const viewButtons = document.querySelectorAll('.btn-availability');
    const bookButtons = document.querySelectorAll('.btn-book-now');

    viewButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!this.getAttribute('onclick')) {
                e.preventDefault();
                showNotification('سيتم توجيهك لصفحة تفاصيل الصالون', 'info');
            }
        });
    });

    bookButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const salonName = this.closest('.salon-card').querySelector('.salon-name').textContent;
            showNotification(`سيتم توجيهك لحجز موعد في ${salonName}`, 'info');
        });
    });
}

// Handle favorite toggle
// function handleFavoriteToggle(button) {
//     const card = button.closest('.salon-card');
//     const salonName = card.querySelector('.salon-name').textContent;

//     if (button.classList.contains('active')) {
//         // Remove from favorites
//         if (confirm(`هل تريدين إزالة ${salonName} من المفضلة؟`)) {
//             card.style.transform = 'scale(0.8)';
//             card.style.opacity = '0';

//             setTimeout(() => {
//                 card.remove();
//                 updateFavoritesCount();
//                 showNotification('تم إزالة الصالون من المفضلة', 'info');
//                 checkEmptyFavorites();
//             }, 300);
//         }
//     }
// }

// Handle favorite sorting
function handleFavoriteSort(sortBy) {
    const grid = document.getElementById('favoritesGrid');
    if (!grid) return;

    const cards = Array.from(grid.children);

    cards.sort((a, b) => {
        const aCard = a.querySelector('.salon-card');
        const bCard = b.querySelector('.salon-card');

        switch(sortBy) {
            case 'name':
                const aName = aCard.querySelector('.salon-name').textContent;
                const bName = bCard.querySelector('.salon-name').textContent;
                return aName.localeCompare(bName, 'ar');

            case 'rating':
                const aRating = aCard.querySelector('.rating-text').textContent;
                const bRating = bCard.querySelector('.rating-text').textContent;
                return parseFloat(bRating.replace(/[()]/g, '')) - parseFloat(aRating.replace(/[()]/g, ''));

            case 'location':
                const aLocation = aCard.querySelector('.detail-item span').textContent;
                const bLocation = bCard.querySelector('.detail-item span').textContent;
                return aLocation.localeCompare(bLocation, 'ar');

            default: // recent
                return 0;
        }
    });

    // Re-append sorted cards
    cards.forEach(card => grid.appendChild(card));

    showNotification(`تم ترتيب النتائج حسب: ${getSortLabel(sortBy)}`, 'info');
}

// Get sort label in Arabic
function getSortLabel(sortBy) {
    const labels = {
        'recent': 'الأحدث إضافة',
        'rating': 'التقييم الأعلى',
        'name': 'الاسم',
        'location': 'الموقع'
    };
    return labels[sortBy] || sortBy;
}

// Handle city filtering
function handleCityFilter(selectedCity, cityName) {
    const cards = document.querySelectorAll('#favoritesGrid > *');
    let visibleCount = 0;

    cards.forEach(card => {
        const cardCity = card.dataset.city;

        if (!selectedCity || cardCity === selectedCity) {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    if (visibleCount === 0) {
        showNotification('لا توجد صالونات في المدينة المختارة', 'warning');
    } else {
        const message = selectedCity ? `عرض الصالونات في ${cityName}` : 'عرض جميع الصالونات';
        showNotification(message, 'info');
    }
}

// Update favorites count
// function updateFavoritesCount() {
//     const count = document.querySelectorAll('.salon-card').length;
//     const statItem = document.querySelector('.stat-item');
//     if (statItem) {
//         statItem.innerHTML = `<i class="fas fa-heart"></i>${count} صالونات مفضلة`;
//     }
// }

// Check if favorites is empty
// function checkEmptyFavorites() {
//     const favorites = document.querySelectorAll('.salon-card');
//     const emptyState = document.getElementById('emptyFavorites');

//     if (favorites.length === 0 && emptyState) {
//         emptyState.classList.remove('hidden');
//     }
// }

// Show notification
function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(notification => notification.remove());

    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        max-width: 400px;
        padding: 1rem 1.5rem;
        background: white;
        border: 1px solid #e0e0e0;
        border-left: 4px solid ${getNotificationColor(type)};
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        font-family: 'IBM Plex Sans Arabic', sans-serif;
        font-size: 0.9rem;
        line-height: 1.4;
        transform: translateX(100%);
        transition: transform 0.3s ease;
    `;

    notification.innerHTML = `
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <i class="fas fa-${getNotificationIcon(type)}" style="color: ${getNotificationColor(type)};"></i>
            <span style="flex: 1;">${message}</span>
            <button onclick="this.parentNode.parentNode.remove()" style="
                background: none;
                border: none;
                font-size: 1.2rem;
                color: #999;
                cursor: pointer;
                padding: 0;
                width: 20px;
                height: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
            ">×</button>
        </div>
    `;

    document.body.appendChild(notification);

    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 10);

    // Auto remove after 4 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 300);
        }
    }, 4000);
}

// Get notification color
function getNotificationColor(type) {
    const colors = {
        'success': '#28a745',
        'error': '#dc3545',
        'warning': '#ffc107',
        'info': '#F56476'
    };
    return colors[type] || '#F56476';
}

// Get notification icon
function getNotificationIcon(type) {
    const icons = {
        'success': 'check-circle',
        'error': 'exclamation-circle',
        'warning': 'exclamation-triangle',
        'info': 'info-circle'
    };
    return icons[type] || 'info-circle';
}

// Utility functions
function formatArabicDate(date) {
    const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        weekday: 'long'
    };

    return new Intl.DateTimeFormat('ar-SA', options).format(date);
}

function smoothScrollTo(element) {
    if (element) {
        element.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
}

// Loading state management
function showLoading(element) {
    if (!element) return () => {};

    const originalContent = element.innerHTML;
    element.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-left: 0.5rem;"></i>جاري التحميل...';
    element.disabled = true;

    return () => {
        element.innerHTML = originalContent;
        element.disabled = false;
    };
}

// Animation utility
function animateElement(element, animationClass) {
    if (!element) return;

    element.classList.add(animationClass);
    element.addEventListener('animationend', function() {
        element.classList.remove(animationClass);
    }, { once: true });
}
