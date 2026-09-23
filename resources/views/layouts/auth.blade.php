<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login') | Junior Gurukul School Portal</title>
    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #0A192F 0%, #172A45 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }
        .auth-card {
            background: #FFFFFF;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 440px;
            overflow: hidden;
        }
        .auth-header {
            background: #0B192C;
            color: #FFFFFF;
            padding: 30px 20px;
            text-align: center;
        }
        .btn-navy {
            background-color: #0B192C;
            color: #FFFFFF;
        }
        .btn-navy:hover {
            background-color: #122442;
            color: #FFFFFF;
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-header">
            <div class="rounded-circle text-navy d-inline-flex align-items-center justify-content-center mb-2 fw-bold" style="width: 48px; height: 48px; font-size: 1.2rem; background: linear-gradient(145deg, #E4C185, #C5A059); color: #0B192C;">
                JG
            </div>
            <h5 class="fw-bold mb-0">Junior Gurukul School</h5>
            <span class="small text-white-50">Enterprise School ERP Portal</span>
        </div>
        <div class="p-4">
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
