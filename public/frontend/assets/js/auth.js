
// Authentication Scripts - Shared for User and Hairdresser Auth

document.addEventListener('DOMContentLoaded', function() {

    // Initialize authentication functionality
    initAuthTabs();
    initPasswordToggles();
    initFormValidation();
    initHairdresserRegistration();

    // Initialize form submissions
    initFormSubmissions();

    console.log('Authentication system initialized');
});

// Initialize authentication tabs
function initAuthTabs() {
    const authTabs = document.querySelectorAll('.auth-tab');
    const authForms = document.querySelectorAll('.auth-form');

    authTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const targetTab = this.dataset.tab;

            // Remove active class from all tabs and forms
            authTabs.forEach(t => t.classList.remove('active'));
            authForms.forEach(f => f.classList.remove('active'));

            // Add active class to clicked tab
            this.classList.add('active');

            // Show corresponding form
            const targetForm = document.getElementById(targetTab === 'login' ? 'loginForm' :
                                                   targetTab === 'register' ? 'registerForm' :
                                                   targetTab === 'hairdresser-login' ? 'hairdresserLoginForm' :
                                                   'hairdresserRegisterForm');

            if (targetForm) {
                targetForm.classList.add('active');
            }
        });
    });
}

// Initialize password toggle functionality
function initPasswordToggles() {
    const toggleButtons = [
        'toggleLoginPassword',
        'toggleRegisterPassword',
        'toggleHairdresserLoginPassword',
        'toggleHairdresserPassword'
    ];

    toggleButtons.forEach(buttonId => {
        const button = document.getElementById(buttonId);
        if (button) {
            button.addEventListener('click', function() {
                const passwordInput = this.parentElement.querySelector('input[type="password"], input[type="text"]');
                const icon = this.querySelector('i');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        }
    });
}

// Initialize form validation
function initFormValidation() {
    // Password confirmation validation
    const confirmPasswordInputs = document.querySelectorAll('#confirmPassword, #hairdresserConfirmPassword');

    confirmPasswordInputs.forEach(input => {
        input.addEventListener('input', function() {
            const passwordInput = this.form.querySelector('#registerPassword, #hairdresserPassword');
            const password = passwordInput ? passwordInput.value : '';
            const confirmPassword = this.value;

            if (confirmPassword && password !== confirmPassword) {
                this.setCustomValidity('كلمات المرور غير متطابقة');
                this.classList.add('is-invalid');
            } else {
                this.setCustomValidity('');
                this.classList.remove('is-invalid');
            }
        });
    });

    // Email validation
    const emailInputs = document.querySelectorAll('input[type="email"]');
    emailInputs.forEach(input => {
        input.addEventListener('input', function() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (this.value && !emailRegex.test(this.value)) {
                this.setCustomValidity('يرجى إدخال بريد إلكتروني صحيح');
                this.classList.add('is-invalid');
            } else {
                this.setCustomValidity('');
                this.classList.remove('is-invalid');
            }
        });
    });

    // Phone validation
    const phoneInputs = document.querySelectorAll('input[type="tel"]');
    phoneInputs.forEach(input => {
        input.addEventListener('input', function() {
            const phoneRegex = /^[+]?[0-9]{10,15}$/;
            if (this.value && !phoneRegex.test(this.value.replace(/\s/g, ''))) {
                this.setCustomValidity('يرجى إدخال رقم هاتف صحيح');
                this.classList.add('is-invalid');
            } else {
                this.setCustomValidity('');
                this.classList.remove('is-invalid');
            }
        });
    });
}

// Initialize hairdresser registration specific functionality
function initHairdresserRegistration() {
    // Add service functionality
    const addServiceBtn = document.getElementById('addService');
    if (addServiceBtn) {
        addServiceBtn.addEventListener('click', addNewService);
    }

    // Remove service functionality
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-service') || e.target.closest('.remove-service')) {
            removeService(e.target.closest('.remove-service'));
        }
    });

    // Image upload preview
    const imageInputs = document.querySelectorAll('input[type="file"]');
    imageInputs.forEach(input => {
        input.addEventListener('change', handleImagePreview);
    });

    // Features selection
    const featureCheckboxes = document.querySelectorAll('.feature-checkbox');
    featureCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const item = this.closest('.feature-item');
            if (this.checked) {
                item.style.borderColor = 'var(--primary-border)';
                item.style.backgroundColor = 'rgba(245, 100, 118, 0.05)';
            } else {
                item.style.borderColor = '#e9ecef';
                item.style.backgroundColor = 'var(--white)';
            }
        });
    });
}

// // Add new service
// function addNewService() {
//     const servicesContainer = document.getElementById('servicesContainer');
//     const serviceCount = servicesContainer.children.length;

//     if (serviceCount >= 10) {
//         showMessage('لا يمكن إضافة أكثر من 10 خدمات', 'warning');
//         return;
//     }

//     const newService = document.createElement('div');
//     newService.className = 'service-item';
//     newService.innerHTML = `
//         <div class="row">
//             <div class="col-md-4 mb-3">
//                 <label class="form-label fw-semibold">اسم الخدمة</label>
//                 <input type="text" class="form-control service-name" placeholder="مثال: صبغ الشعر" required>
//             </div>
//             <div class="col-md-3 mb-3">
//                 <label class="form-label fw-semibold">السعر (ريال)</label>
//                 <input type="number" class="form-control service-price" placeholder="200" required>
//             </div>
//             <div class="col-md-3 mb-3">
//                 <label class="form-label fw-semibold">المدة (دقيقة)</label>
//                 <input type="number" class="form-control service-duration" placeholder="90" required>
//             </div>
//             <div class="col-md-2 mb-3 d-flex align-items-end">
//                 <button type="button" class="btn btn-outline-danger remove-service">
//                     <i class="fas fa-trash"></i>
//                 </button>
//             </div>
//         </div>
//         <div class="mb-3">
//             <label class="form-label fw-semibold">وصف الخدمة</label>
//             <textarea class="form-control service-description" rows="2" placeholder="اكتبي وصفاً مختصراً للخدمة..." required></textarea>
//         </div>
//     `;

//     servicesContainer.appendChild(newService);

//     // Show remove button for all services when there's more than one
//     updateRemoveButtons();

//     // Animate the new service
//     newService.style.opacity = '0';
//     newService.style.transform = 'translateY(20px)';
//     setTimeout(() => {
//         newService.style.transition = 'all 0.3s ease';
//         newService.style.opacity = '1';
//         newService.style.transform = 'translateY(0)';
//     }, 10);
// }

// // Remove service
// function removeService(button) {
//     const serviceItem = button.closest('.service-item');
//     const servicesContainer = document.getElementById('servicesContainer');

//     if (servicesContainer.children.length <= 1) {
//         showMessage('يجب أن يكون لديك خدمة واحدة على الأقل', 'warning');
//         return;
//     }

//     serviceItem.style.transition = 'all 0.3s ease';
//     serviceItem.style.opacity = '0';
//     serviceItem.style.transform = 'translateX(-100%)';

//     setTimeout(() => {
//         serviceItem.remove();
//         updateRemoveButtons();
//     }, 300);
// }

// // Update remove button visibility
// function updateRemoveButtons() {
//     const servicesContainer = document.getElementById('servicesContainer');
//     const removeButtons = servicesContainer.querySelectorAll('.remove-service');

//     if (servicesContainer.children.length > 1) {
//         removeButtons.forEach(button => {
//             button.style.display = 'block';
//         });
//     } else {
//         removeButtons.forEach(button => {
//             button.style.display = 'none';
//         });
//     }
// }


// Handle image preview
function handleImagePreview(event) {
    const file = event.target.files[0];
    const label = event.target.nextElementSibling;

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            label.style.backgroundImage = `url(${e.target.result})`;
            label.style.backgroundSize = 'cover';
            label.style.backgroundPosition = 'center';
            label.innerHTML = '<span style="background: rgba(0,0,0,0.7); color: white; padding: 5px 10px; border-radius: 4px;">تم اختيار الصورة</span>';
        };
        reader.readAsDataURL(file);
    }
}

// Initialize form submissions
function initFormSubmissions() {
    // User login form
    // const userLoginForm = document.getElementById('userLoginForm');
    // if (userLoginForm) {
    //     userLoginForm.addEventListener('submit', handleUserLogin);
    // }

    // // User register form
    // const userRegisterForm = document.getElementById('userRegisterForm');
    // if (userRegisterForm) {
    //     userRegisterForm.addEventListener('submit', handleUserRegister);
    // }

    // Hairdresser login form
    // const hairdresserLoginForm = document.getElementById('hairdresserLogin');
    // if (hairdresserLoginForm) {
    //     hairdresserLoginForm.addEventListener('submit', handleHairdresserLogin);
    // }

    // Hairdresser register form
    // const hairdresserRegisterForm = document.getElementById('hairdresserRegister');
    // if (hairdresserRegisterForm) {
    //     hairdresserRegisterForm.addEventListener('submit', handleHairdresserRegister);
    // }

    // Google authentication buttons
    // const googleButtons = document.querySelectorAll('.btn-google');
    // googleButtons.forEach(button => {
    //     button.addEventListener('click', handleGoogleAuth);
    // });
}

// Handle user login
function handleUserLogin(event) {
    event.preventDefault();

    const formData = new FormData(event.target);
    const loginData = {
        email: document.getElementById('loginEmail').value,
        password: document.getElementById('loginPassword').value,
        remember: document.getElementById('rememberMe').checked
    };

    const submitButton = event.target.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;

    // Show loading state
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري تسجيل الدخول...';
    submitButton.disabled = true;

    // Simulate API call
    setTimeout(() => {
        console.log('User login data:', loginData);
        showMessage('تم تسجيل الدخول بنجاح! سيتم توجيهك للصفحة الرئيسية', 'success');

        // Reset button
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;

        // Redirect after success
        setTimeout(() => {
            window.location.href = 'index.html';
        }, 2000);

    }, 2000);
}

// Handle user registration
function handleUserRegister(event) {
    event.preventDefault();

    const registerData = {
        firstName: document.getElementById('firstName').value,
        lastName: document.getElementById('lastName').value,
        email: document.getElementById('registerEmail').value,
        phone: document.getElementById('phone').value,
        city: document.getElementById('city').value,
        password: document.getElementById('registerPassword').value,
        confirmPassword: document.getElementById('confirmPassword').value,
        agreeTerms: document.getElementById('agreeTerms').checked
    };

    // Validate password confirmation
    if (registerData.password !== registerData.confirmPassword) {
        showMessage('كلمات المرور غير متطابقة', 'error');
        return;
    }

    const submitButton = event.target.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;

    // Show loading state
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري إنشاء الحساب...';
    submitButton.disabled = true;

    // Simulate API call
    setTimeout(() => {
        console.log('User registration data:', registerData);
        showMessage('تم إنشاء حسابك بنجاح! مرحباً بك في كوافيري', 'success');

        // Reset button
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;

        // Redirect after success
        setTimeout(() => {
            window.location.href = 'index.html';
        }, 2000);

    }, 3000);
}

// Handle hairdresser login
// function handleHairdresserLogin(event) {
//     event.preventDefault();

//     const loginData = {
//         email: document.getElementById('hairdresserLoginEmail').value,
//         password: document.getElementById('hairdresserLoginPassword').value,
//         remember: document.getElementById('hairdresserRememberMe').checked
//     };

//     const submitButton = event.target.querySelector('button[type="submit"]');
//     const originalText = submitButton.innerHTML;

//     // Show loading state
//     submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري تسجيل الدخول...';
//     submitButton.disabled = true;

//     // Simulate API call
//     setTimeout(() => {
//         console.log('Hairdresser login data:', loginData);
//         showMessage('تم تسجيل الدخول بنجاح! مرحباً بك في لوحة التحكم', 'success');

//         // Reset button
//         submitButton.innerHTML = originalText;
//         submitButton.disabled = false;

//         // Redirect to hairdresser dashboard
//         setTimeout(() => {
//             showMessage('سيتم توجيهك للوحة التحكم الخاصة بك', 'info');
//         }, 2000);

//     }, 2000);
// }

// Handle hairdresser registration
// function handleHairdresserRegister(event) {
//     event.preventDefault();

//     // Collect salon data
//     const salonData = {
//         name: document.getElementById('salonName').value,
//         email: document.getElementById('salonEmail').value,
//         description: document.getElementById('salonDescription').value,
//         type: document.getElementById('salonType').value,
//         phone: document.getElementById('salonPhone').value,
//         address: document.getElementById('salonAddress').value,
//         password: document.getElementById('hairdresserPassword').value,
//         confirmPassword: document.getElementById('hairdresserConfirmPassword').value
//     };

//     // Collect services
//     const services = [];
//     const serviceItems = document.querySelectorAll('.service-item');
//     serviceItems.forEach(item => {
//         services.push({
//             name: item.querySelector('.service-name').value,
//             price: item.querySelector('.service-price').value,
//             duration: item.querySelector('.service-duration').value,
//             description: item.querySelector('.service-description').value
//         });
//     });

//     // Collect features
//     const features = [];
//     const selectedFeatures = document.querySelectorAll('.feature-checkbox:checked');
//     selectedFeatures.forEach(checkbox => {
//         features.push(checkbox.value);
//     });

//     // Collect images
//     const images = [];
//     const imageInputs = document.querySelectorAll('input[type="file"]');
//     imageInputs.forEach(input => {
//         if (input.files[0]) {
//             images.push(input.files[0].name);
//         }
//     });

//     const registrationData = {
//         salon: salonData,
//         services: services,
//         features: features,
//         images: images
//     };

//     // Validate password confirmation
//     if (salonData.password !== salonData.confirmPassword) {
//         showMessage('كلمات المرور غير متطابقة', 'error');
//         return;
//     }

//     // Validate minimum requirements
//     if (services.length === 0) {
//         showMessage('يجب إضافة خدمة واحدة على الأقل', 'error');
//         return;
//     }

//     if (images.length === 0) {
//         showMessage('يجب إضافة صورة واحدة على الأقل للصالون', 'error');
//         return;
//     }

//     const submitButton = event.target.querySelector('button[type="submit"]');
//     const originalText = submitButton.innerHTML;

//     // Show loading state
//     submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري تسجيل الصالون...';
//     submitButton.disabled = true;

//     // Simulate API call
//     setTimeout(() => {
//         console.log('Hairdresser registration data:', registrationData);
//         showMessage('تم تسجيل صالونك بنجاح! سيتم مراجعة طلبك خلال 24 ساعة', 'success');

//         // Reset button
//         submitButton.innerHTML = originalText;
//         submitButton.disabled = false;

//         // Show additional success message
//         setTimeout(() => {
//             showMessage('ستصلك رسالة تأكيد عبر البريد الإلكتروني قريباً', 'info');
//         }, 2000);

//     }, 4000);
// }

// Handle Google authentication
// function handleGoogleAuth(event) {
//     event.preventDefault();

//     const button = event.target;
//     const originalText = button.innerHTML;

//     button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري التوصيل مع Google...';
//     button.disabled = true;

//     // Simulate Google auth
//     setTimeout(() => {
//         showMessage('تم تسجيل الدخول باستخدام Google بنجاح!', 'success');

//         button.innerHTML = originalText;
//         button.disabled = false;

//         setTimeout(() => {
//             window.location.href = 'index.html';
//         }, 2000);

//     }, 2000);
// }

// Show message function
function showMessage(message, type = 'info') {
    // Remove existing messages
    const existingMessages = document.querySelectorAll('.auth-message');
    existingMessages.forEach(msg => msg.remove());

    // Create message element
    const messageElement = document.createElement('div');
    messageElement.className = `auth-message alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show`;
    messageElement.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="fas fa-${getMessageIcon(type)} me-2"></i>
            <span>${message}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    `;

    // Insert message at the top of the auth card
    const authCard = document.querySelector('.auth-card');
    authCard.insertBefore(messageElement, authCard.firstChild);

    // Auto remove after 5 seconds
    setTimeout(() => {
        if (messageElement.parentNode) {
            messageElement.remove();
        }
    }, 5000);
}

// Get message icon
function getMessageIcon(type) {
    const icons = {
        'success': 'check-circle',
        'error': 'exclamation-circle',
        'warning': 'exclamation-triangle',
        'info': 'info-circle'
    };
    return icons[type] || 'info-circle';
}

// Form validation utilities
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function validatePhone(phone) {
    const re = /^[+]?[0-9]{10,15}$/;
    return re.test(phone.replace(/\s/g, ''));
}

function validatePassword(password) {
    return password.length >= 8;
}

// Local storage utilities for form persistence
function saveFormData(formId, data) {
    localStorage.setItem(`arabella_${formId}`, JSON.stringify(data));
}

function loadFormData(formId) {
    const saved = localStorage.getItem(`arabella_${formId}`);
    return saved ? JSON.parse(saved) : null;
}

function clearFormData(formId) {
    localStorage.removeItem(`arabella_${formId}`);
}
