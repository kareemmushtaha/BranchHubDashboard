<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>حجز مقعد - Branch Hub</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Almarai', 'Segoe UI', 'Tahoma', 'Arial', sans-serif !important;
        }
        
        :root {
            --primary-color: #1a1a1a;
            --accent-red: #dc2626;
            --accent-white: #ffffff;
            --secondary-color: #f8f9fa;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --success-color: #10b981;
        }
        
        body {
            background: var(--secondary-color);
            margin: 0;
            padding: 0;
        }
        
        /* Header */
        .header {
            background: var(--primary-color);
            color: var(--accent-white);
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--accent-white);
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        
        .logo img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-left: 10px;
        }
        
        .back-btn {
            background: var(--accent-red);
            color: var(--accent-white);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .back-btn:hover {
            background: #b91c1c;
            color: var(--accent-white);
        }
        
        /* Main Content */
        .main-content {
            padding: 3rem 0;
            min-height: calc(100vh - 200px);
        }
        
        .booking-container {
            max-width: 600px;
            margin: 0 auto;
            background: var(--accent-white);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .booking-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #2d2d2d 100%);
            color: var(--accent-white);
            padding: 2rem;
            text-align: center;
        }
        
        .booking-header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .booking-header p {
            opacity: 0.9;
            margin-bottom: 0;
        }
        
        .booking-body {
            padding: 2.5rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .form-control, .form-select {
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--accent-red);
            box-shadow: 0 0 0 0.2rem rgba(220, 38, 38, 0.25);
        }
        
        .form-control.is-invalid, .form-select.is-invalid {
            border-color: #dc3545;
        }
        
        .invalid-feedback {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        
        .plan-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .plan-option {
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 1rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: var(--accent-white);
        }
        
        .plan-option:hover {
            border-color: var(--accent-red);
            background: #fef2f2;
        }
        
        .plan-option.selected {
            border-color: var(--accent-red);
            background: #fef2f2;
        }
        
        .plan-option input[type="radio"] {
            display: none;
        }
        
        .plan-option .plan-name {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
        }
        
        .plan-option .plan-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--accent-red);
        }
        
        .plan-option .plan-period {
            font-size: 0.875rem;
            color: var(--text-light);
        }
        
        .btn-submit {
            background: var(--accent-red);
            color: var(--accent-white);
            border: none;
            padding: 1rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1.1rem;
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .btn-submit:hover {
            background: #b91c1c;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 38, 38, 0.3);
        }
        
        .btn-submit:disabled {
            background: #9ca3af;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .required {
            color: var(--accent-red);
        }
        
        .form-note {
            background: #f0f9ff;
            border: 1px solid #0ea5e9;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .form-note h6 {
            color: #0369a1;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .form-note p {
            color: #0369a1;
            margin-bottom: 0;
            font-size: 0.9rem;
        }
        
        /* Footer */
        .footer {
            background: var(--primary-color);
            color: var(--accent-white);
            padding: 2rem 0;
            text-align: center;
        }
        
        .footer-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }
        
        .footer-logo {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--accent-red);
        }
        
        .footer-logo img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-left: 8px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .booking-container {
                margin: 1rem;
                border-radius: 15px;
            }
            
            .booking-header {
                padding: 1.5rem;
            }
            
            .booking-header h1 {
                font-size: 1.5rem;
            }
            
            .booking-body {
                padding: 1.5rem;
            }
            
            .plan-options {
                grid-template-columns: 1fr;
            }
            
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }
        }
        
        /* Toast Notification Styles */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 400px;
        }
        
        .toast {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 1.5rem 2rem;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(16, 185, 129, 0.3);
            margin-bottom: 1rem;
            transform: translateX(100%);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .toast.show {
            transform: translateX(0);
            opacity: 1;
        }
        
        .toast::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            animation: shimmer 2s infinite;
        }
        
        .toast-content {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .toast-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            animation: bounce 0.6s ease-in-out;
        }
        
        .toast-text {
            flex: 1;
        }
        
        .toast-title {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }
        
        .toast-message {
            font-size: 0.9rem;
            opacity: 0.9;
            line-height: 1.4;
        }
        
        .toast-close {
            position: absolute;
            top: 10px;
            right: 15px;
            background: none;
            border: none;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }
        
        .toast-close:hover {
            opacity: 1;
        }
        
        .toast.error {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            box-shadow: 0 20px 40px rgba(239, 68, 68, 0.3);
        }
        
        .toast.warning {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            box-shadow: 0 20px 40px rgba(245, 158, 11, 0.3);
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }
        
        @media (max-width: 768px) {
            .toast-container {
                top: 10px;
                right: 10px;
                left: 10px;
                max-width: none;
            }
            
            .toast {
                padding: 1.2rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>
    
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <a href="{{ route('branchhub.landing') }}" class="logo">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Branch Hub Logo">
                    Branch Hub
                </a>
                <a href="{{ route('branchhub.landing') }}" class="back-btn">
                    <i class="bi bi-arrow-right me-2"></i>
                    العودة للصفحة الرئيسية
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <div class="booking-container">
                <div class="booking-header">
                    <h1><i class="bi bi-calendar-check me-2"></i>حجز مقعد</h1>
                    <p>احجز مقعدك في Branch Hub واستمتع بتجربة عمل استثنائية</p>
                </div>
                
                <div class="booking-body">
                    <form id="bookingForm" method="POST" action="#">
                        @csrf
                        
                        <!-- Plan Selection -->
                        <div class="form-group">
                            <label class="form-label">
                                نوع الخطة <span class="required">*</span>
                            </label>
                            <div class="plan-options">
                                <label class="plan-option" for="plan_daily">
                                    <input type="radio" id="plan_daily" name="plan_type" value="daily" required>
                                    <div class="plan-name">حجز يومي</div>
                                    <div class="plan-price">30₪</div>
                                    <div class="plan-period">لليوم الواحد</div>
                                </label>
                                
                                <label class="plan-option" for="plan_weekly">
                                    <input type="radio" id="plan_weekly" name="plan_type" value="weekly" required>
                                    <div class="plan-name">حجز أسبوعي</div>
                                    <div class="plan-price">150₪</div>
                                    <div class="plan-period">للأسبوع (6 أيام)</div>
                                </label>
                                
                                <label class="plan-option" for="plan_monthly">
                                    <input type="radio" id="plan_monthly" name="plan_type" value="monthly" required>
                                    <div class="plan-name">حجز شهري</div>
                                    <div class="plan-price">550₪</div>
                                    <div class="plan-period">للشهر (30 يوم)</div>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Name -->
                        <div class="form-group">
                            <label for="name" class="form-label">
                                الاسم الكامل <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="name" 
                                   name="name" 
                                   placeholder="أدخل اسمك الكامل" 
                                   required
                                   maxlength="255">
                        </div>
                        
                        <!-- Phone Number -->
                        <div class="form-group">
                            <label for="phone" class="form-label">
                                رقم الجوال <span class="required">*</span>
                            </label>
                            <input type="tel" 
                                   class="form-control" 
                                   id="phone" 
                                   name="phone" 
                                   placeholder="05xxxxxxxx" 
                                   required
                                   pattern="05[0-9]{8}"
                                   maxlength="10">
                            <div class="invalid-feedback">
                                يرجى إدخال رقم جوال صحيح (05xxxxxxxx)
                            </div>
                        </div>
                        
                        <!-- Customer Notes -->
                        <div class="form-group">
                            <label for="notes" class="form-label">ملاحظات من العميل</label>
                            <textarea class="form-control" 
                                      id="notes" 
                                      name="notes" 
                                      rows="4" 
                                      placeholder="أي ملاحظات أو طلبات خاصة..."></textarea>
                        </div>
                        
                        <!-- Form Note -->
                        <div class="form-note">
                            <h6><i class="bi bi-info-circle me-2"></i>معلومات مهمة</h6>
                            <p>
                                بعد إرسال طلب الحجز، سنتواصل معك خلال 24 ساعة لتأكيد الحجز وتفاصيل الدفع. 
                                يرجى التأكد من صحة رقم الجوال.
                            </p>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" class="btn-submit">
                            <i class="bi bi-send me-2"></i>
                            إرسال طلب الحجز
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Branch Hub Logo">
                    Branch Hub
                </div>
                <div>
                    <small>فلسطين غزة الرمال عمارة مشتهى - عبد القادر الحسيني</small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Toast Notification System
        function showToast(title, message, type = 'success', duration = 5000) {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            
            const icon = type === 'success' ? 'bi-check-circle-fill' : 
                        type === 'error' ? 'bi-x-circle-fill' : 
                        type === 'warning' ? 'bi-exclamation-triangle-fill' : 'bi-info-circle-fill';
            
            toast.innerHTML = `
                <button class="toast-close" onclick="closeToast(this)">×</button>
                <div class="toast-content">
                    <div class="toast-icon">
                        <i class="bi ${icon}"></i>
                    </div>
                    <div class="toast-text">
                        <div class="toast-title">${title}</div>
                        <div class="toast-message">${message}</div>
                    </div>
                </div>
            `;
            
            container.appendChild(toast);
            
            // Trigger animation
            setTimeout(() => {
                toast.classList.add('show');
            }, 100);
            
            // Auto remove
            setTimeout(() => {
                closeToast(toast.querySelector('.toast-close'));
            }, duration);
        }
        
        function closeToast(closeBtn) {
            const toast = closeBtn.closest('.toast');
            toast.classList.remove('show');
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 400);
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('bookingForm');
            const planOptions = document.querySelectorAll('.plan-option');
            const nameInput = document.getElementById('name');
            const phoneInput = document.getElementById('phone');
            const submitBtn = document.querySelector('.btn-submit');
            
            // Plan selection handling
            planOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Remove selected class from all options
                    planOptions.forEach(opt => opt.classList.remove('selected'));
                    // Add selected class to clicked option
                    this.classList.add('selected');
                });
            });
            
            // Phone number formatting
            phoneInput.addEventListener('input', function() {
                let value = this.value.replace(/\D/g, ''); // Remove non-digits
                
                // Ensure it starts with 05
                if (value.length > 0 && !value.startsWith('05')) {
                    value = '05' + value.replace(/^05/, '');
                }
                
                // Limit to 10 digits
                if (value.length > 10) {
                    value = value.substring(0, 10);
                }
                
                this.value = value;
                
                // Validate phone number
                if (value.length === 10 && value.startsWith('05')) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else if (value.length > 0) {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-valid', 'is-invalid');
                }
            });
            
            // Form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Get form data
                const formData = new FormData(form);
                const name = formData.get('name');
                const planType = formData.get('plan_type');
                const phone = formData.get('phone');
                const notes = formData.get('notes');
                
                // Validate required fields
                if (!name || name.trim() === '') {
                    showToast(
                        'يرجى إدخال الاسم',
                        'الاسم الكامل مطلوب للمتابعة.',
                        'warning',
                        4000
                    );
                    nameInput.focus();
                    return;
                }
                
                if (!planType) {
                    showToast(
                        'يرجى اختيار نوع الخطة',
                        'اختر أحد خيارات الحجز المتاحة قبل المتابعة.',
                        'warning',
                        4000
                    );
                    return;
                }
                
                if (!phone || phone.length !== 10 || !phone.startsWith('05')) {
                    showToast(
                        'رقم جوال غير صحيح',
                        'يرجى إدخال رقم جوال صحيح (10 أرقام تبدأ بـ 05)',
                        'error',
                        4000
                    );
                    phoneInput.focus();
                    return;
                }
                
                // Disable submit button
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>جاري الإرسال...';
                
                // Submit form data to server
                fetch('{{ route("booking-requests.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        name: name,
                        phone: phone,
                        plan_type: planType,
                        notes: notes
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message with beautiful toast
                        showToast(
                            'تم إرسال طلب الحجز بنجاح! 🎉',
                            'شكراً لك! سنتواصل معك قريباً لتأكيد الحجز وتفاصيل الدفع.',
                            'success',
                            6000
                        );
                    
                    // Reset form
                    form.reset();
                    planOptions.forEach(opt => opt.classList.remove('selected'));
                    nameInput.classList.remove('is-valid', 'is-invalid');
                    phoneInput.classList.remove('is-valid', 'is-invalid');
                    
                    // Re-enable submit button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="bi bi-send me-2"></i>إرسال طلب الحجز';
                    
                    // Wait a bit before redirecting to let user see the success message
                    setTimeout(() => {
                        showToast(
                            'جاري التوجيه...',
                            'سيتم توجيهك للصفحة الرئيسية خلال لحظات',
                            'success',
                            2000
                        );
                        
                        // Redirect to landing page after showing redirect message
                        setTimeout(() => {
                            window.location.href = '{{ route("branchhub.landing") }}';
                        }, 2000);
                    }, 3000);
                    } else {
                        // Show error message
                        showToast(
                            'حدث خطأ!',
                            'لم يتم إرسال الطلب بنجاح. يرجى المحاولة مرة أخرى.',
                            'error',
                            5000
                        );
                        
                        // Re-enable submit button
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="bi bi-send me-2"></i>إرسال طلب الحجز';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Show error message
                    showToast(
                        'حدث خطأ!',
                        'لم يتم إرسال الطلب بنجاح. يرجى المحاولة مرة أخرى.',
                        'error',
                        5000
                    );
                    
                    // Re-enable submit button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="bi bi-send me-2"></i>إرسال طلب الحجز';
                });
            });
            
            // Real-time form validation
            form.addEventListener('input', function() {
                const name = nameInput.value.trim();
                const planType = document.querySelector('input[name="plan_type"]:checked');
                const phone = phoneInput.value;
                
                // Enable/disable submit button based on validation
                if (name && planType && phone.length === 10 && phone.startsWith('05')) {
                    submitBtn.disabled = false;
                } else {
                    submitBtn.disabled = true;
                }
            });
            
            // Initial state
            submitBtn.disabled = true;
        });
    </script>
</body>
</html>
