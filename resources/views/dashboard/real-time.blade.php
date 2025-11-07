@extends('layouts.app')

@section('title', 'لوحة التحكم المباشرة')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-speedometer2 text-primary"></i>
        لوحة التحكم المباشرة
    </h1>
    <div>
        <button class="btn btn-outline-primary" onclick="updateAllPricing()">
            <i class="bi bi-arrow-clockwise"></i> تحديث جميع الأسعار
        </button>
        <button class="btn btn-outline-success" onclick="toggleAutoUpdate()" id="autoUpdateBtn">
            <i class="bi bi-play-circle"></i> التحديث التلقائي
        </button>
    </div>
</div>

<!-- إحصائيات سريعة -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0" id="active-sessions-count">0</h4>
                        <small>الجلسات النشطة</small>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-play-circle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0" id="total-revenue">₪0.00</h4>
                        <small>إجمالي الإيرادات المتوقعة</small>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-cash-stack fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0" id="internet-revenue">₪0.00</h4>
                        <small>إيرادات الإنترنت</small>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-wifi fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0" id="drinks-revenue">₪0.00</h4>
                        <small>إيرادات المشروبات</small>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-cup-hot fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- الأسعار الحالية -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-currency-dollar"></i>
                    الأسعار الحالية
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="text-center p-3 border rounded">
                            <h5 class="text-primary" id="hourly-rate">₪5.00</h5>
                            <small class="text-muted">سعر الساعة</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center p-3 border rounded">
                            <h5 class="text-success" id="overtime-morning">₪5.00</h5>
                            <small class="text-muted">إضافي صباحي</small>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <div class="text-center p-3 border rounded">
                            <h5 class="text-warning" id="overtime-night">₪7.00</h5>
                            <small class="text-muted">إضافي ليلي</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center p-3 border rounded">
                            <h5 class="text-info" id="avg-duration">0 دقيقة</h5>
                            <small class="text-muted">متوسط مدة الجلسة</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-clock"></i>
                    معلومات التحديث
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <p><strong>آخر تحديث:</strong> <span id="last-update-time">{{ now()->format('H:i:s') }}</span></p>
                        <p><strong>حالة التحديث التلقائي:</strong> 
                            <span id="auto-update-status" class="badge bg-secondary">متوقف</span>
                        </p>
                        <p><strong>فترة التحديث:</strong> كل 30 ثانية</p>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" 
                             id="update-progress" role="progressbar" style="width: 0%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- الجلسات النشطة -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-list-ul"></i>
                    الجلسات النشطة
                </h5>
            </div>
            <div class="card-body">
                <div id="active-sessions-list">
                    <div class="text-center py-4">
                        <i class="bi bi-hourglass-split text-muted fs-1"></i>
                        <p class="text-muted mt-2">جاري تحميل الجلسات النشطة...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let autoUpdateInterval;
let updateProgressInterval;
let isAutoUpdateActive = false;

document.addEventListener('DOMContentLoaded', function() {
    // تحميل البيانات الأولية
    loadRealTimeStats();
    loadActiveSessions();
    
    // بدء التحديث التلقائي
    startAutoUpdate();
});

// تحميل الإحصائيات في الوقت الفعلي
function loadRealTimeStats() {
    fetch('/sessions/real-time-stats')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateStatsDisplay(data.stats);
                updateLastUpdateTime(data.last_updated);
            }
        })
        .catch(error => {
            console.error('خطأ في تحميل الإحصائيات:', error);
        });
}

// تحديث عرض الإحصائيات
function updateStatsDisplay(stats) {
    document.getElementById('active-sessions-count').textContent = stats.active_sessions;
    document.getElementById('total-revenue').textContent = '₪' + stats.total_revenue;
    document.getElementById('internet-revenue').textContent = '₪' + stats.total_internet_revenue;
    document.getElementById('drinks-revenue').textContent = '₪' + stats.total_drinks_revenue;
    
    document.getElementById('hourly-rate').textContent = '₪' + stats.current_rates.hourly.toFixed(2);
    document.getElementById('overtime-morning').textContent = '₪' + stats.current_rates.overtime_morning.toFixed(2);
    document.getElementById('overtime-night').textContent = '₪' + stats.current_rates.overtime_night.toFixed(2);
    document.getElementById('avg-duration').textContent = Math.round(stats.average_session_duration) + ' دقيقة';
}

// تحميل الجلسات النشطة
function loadActiveSessions() {
    fetch('/sessions?session_status=active')
        .then(response => response.text())
        .then(html => {
            // استخراج جدول الجلسات من HTML
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const sessionsTable = doc.querySelector('table tbody');
            
            if (sessionsTable && sessionsTable.children.length > 0) {
                const sessionsList = document.getElementById('active-sessions-list');
                sessionsList.innerHTML = `
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>المستخدم</th>
                                    <th>نوع الجلسة</th>
                                    <th>المدة</th>
                                    <th>التكلفة الحالية</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${sessionsTable.innerHTML}
                            </tbody>
                        </table>
                    </div>
                `;
            } else {
                document.getElementById('active-sessions-list').innerHTML = `
                    <div class="text-center py-4">
                        <i class="bi bi-check-circle text-success fs-1"></i>
                        <p class="text-muted mt-2">لا توجد جلسات نشطة حالياً</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('خطأ في تحميل الجلسات النشطة:', error);
        });
}

// تحديث جميع الأسعار
function updateAllPricing() {
    fetch('/sessions/update-all-pricing', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(`تم تحديث ${data.updated_sessions} جلسة نشطة`, 'success');
            loadRealTimeStats();
            loadActiveSessions();
        } else {
            showNotification('حدث خطأ أثناء تحديث الأسعار', 'error');
        }
    })
    .catch(error => {
        console.error('خطأ في تحديث الأسعار:', error);
        showNotification('حدث خطأ في الاتصال', 'error');
    });
}

// تبديل التحديث التلقائي
function toggleAutoUpdate() {
    if (isAutoUpdateActive) {
        stopAutoUpdate();
    } else {
        startAutoUpdate();
    }
}

// بدء التحديث التلقائي
function startAutoUpdate() {
    isAutoUpdateActive = true;
    autoUpdateInterval = setInterval(() => {
        loadRealTimeStats();
        loadActiveSessions();
    }, 30000); // كل 30 ثانية
    
    // تحديث شريط التقدم
    updateProgressInterval = setInterval(updateProgressBar, 1000);
    
    // تحديث واجهة المستخدم
    document.getElementById('autoUpdateBtn').innerHTML = '<i class="bi bi-pause-circle"></i> إيقاف التحديث';
    document.getElementById('autoUpdateBtn').classList.remove('btn-outline-success');
    document.getElementById('autoUpdateBtn').classList.add('btn-outline-warning');
    document.getElementById('auto-update-status').textContent = 'نشط';
    document.getElementById('auto-update-status').className = 'badge bg-success';
    
    showNotification('تم تفعيل التحديث التلقائي', 'success');
}

// إيقاف التحديث التلقائي
function stopAutoUpdate() {
    isAutoUpdateActive = false;
    if (autoUpdateInterval) {
        clearInterval(autoUpdateInterval);
    }
    if (updateProgressInterval) {
        clearInterval(updateProgressInterval);
    }
    
    // إعادة تعيين شريط التقدم
    document.getElementById('update-progress').style.width = '0%';
    
    // تحديث واجهة المستخدم
    document.getElementById('autoUpdateBtn').innerHTML = '<i class="bi bi-play-circle"></i> التحديث التلقائي';
    document.getElementById('autoUpdateBtn').classList.remove('btn-outline-warning');
    document.getElementById('autoUpdateBtn').classList.add('btn-outline-success');
    document.getElementById('auto-update-status').textContent = 'متوقف';
    document.getElementById('auto-update-status').className = 'badge bg-secondary';
    
    showNotification('تم إيقاف التحديث التلقائي', 'info');
}

// تحديث شريط التقدم
function updateProgressBar() {
    const progressBar = document.getElementById('update-progress');
    const currentWidth = parseInt(progressBar.style.width) || 0;
    const newWidth = (currentWidth + 3.33) % 100; // 30 ثانية = 100%
    progressBar.style.width = newWidth + '%';
}

// تحديث وقت آخر تحديث
function updateLastUpdateTime(time) {
    document.getElementById('last-update-time').textContent = new Date(time).toLocaleTimeString('ar-SA');
}

// إظهار إشعار
function showNotification(message, type) {
    const alertClass = type === 'success' ? 'alert-success' : 
                      type === 'error' ? 'alert-danger' : 'alert-info';
    const icon = type === 'success' ? 'check-circle' : 
                 type === 'error' ? 'exclamation-triangle' : 'info-circle';
    
    const notification = document.createElement('div');
    notification.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        <i class="bi bi-${icon}"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    // إزالة الإشعار بعد 3 ثوان
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 3000);
}
</script>
@endsection 