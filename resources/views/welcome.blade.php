<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مرحباً بك - لوحة تحكم مساحة العمل</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Almarai', 'Segoe UI', 'Tahoma', 'Arial', sans-serif !important;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .welcome-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 600px;
            text-align: center;
        }
        
        .welcome-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 3rem 2rem;
        }
        
        .welcome-header h1 {
            margin: 0;
            font-size: 2.5rem;
            font-weight: 700;
        }
        
        .welcome-header p {
            margin: 1rem 0 0 0;
            opacity: 0.9;
            font-size: 1.1rem;
        }
        
        .welcome-body {
            padding: 3rem 2rem;
        }
        
        .feature-list {
            list-style: none;
            padding: 0;
            margin: 2rem 0;
        }
        
        .feature-list li {
            padding: 0.5rem 0;
            font-size: 1.1rem;
        }
        
        .feature-list i {
            color: #667eea;
            margin-left: 0.5rem;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 1rem 2rem;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            text-decoration: none;
            color: white;
            display: inline-block;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        .welcome-footer {
            text-align: center;
            padding: 1rem 2rem 2rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <div class="welcome-header">
            <i class="bi bi-building fs-1 mb-3"></i>
            <h1>مرحباً بك</h1>
            <p>في نظام إدارة مساحة العمل والمشروبات</p>
        </div>
        
        <div class="welcome-body">
            <h3 class="mb-4">مميزات النظام</h3>
            
            <ul class="feature-list">
                <li><i class="bi bi-clock"></i>إدارة الجلسات والوقت</li>
                <li><i class="bi bi-cup-hot"></i>إدارة المشروبات والطلبات</li>
                <li><i class="bi bi-credit-card"></i>إدارة المدفوعات والمحاسبة</li>
                <li><i class="bi bi-people"></i>إدارة المستخدمين والاشتراكات</li>
                <li><i class="bi bi-graph-up"></i>التقارير والإحصائيات</li>
                <li><i class="bi bi-shield-check"></i>نظام أمان متقدم</li>
            </ul>
            
            <a href="{{ route('login') }}" class="btn-login">
                <i class="bi bi-box-arrow-in-right me-2"></i>
                تسجيل الدخول للوحة التحكم
            </a>
        </div>
        
        <div class="welcome-footer">
            <small>
                نظام إدارة الجلسات والمشروبات<br>
                جميع الحقوق محفوظة &copy; {{ date('Y') }}
            </small>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
