<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Rental Mobil</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f6fa;
            min-height: 100vh;
        }

        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding-right: 150px;
            padding-left: 150px;
            padding-top: 0px;
        }

        .auth-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,.1);
        }

        .auth-left {
            background: linear-gradient(135deg, #000, #111);
            color: #fff;
            padding: 40px;
            position: relative;
        }

        .auth-left h4 {
            font-weight: bold;
        }

        .promo-card {
            background: linear-gradient(135deg, #ffb6c1, #c084fc);
            border-radius: 20px;
            padding: 20px;
            color: #000;
            margin-top: 40px;
        }

        .auth-right {
            padding: 50px 40px;
        }

        .auth-right h3 {
            font-weight: bold;
        }

        .btn-primary {
            background: #3b5bfd;
            border: none;
            border-radius: 10px;
            padding: 12px;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
        }

        @media (max-width: 768px) {
            .auth-left {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="auth-wrapper container-fluid">
    <div class="row w-100 auth-card">

        <!-- LEFT -->
        <div class="col-md-6 auth-left d-flex flex-column justify-content-between">
            <div>
                <h4>RENTAL MOBIL</h4>
                <p class="text-muted">Kelola penyewaan mobil dengan mudah</p>
            </div>

        </div>

        <!-- RIGHT -->
        <div class="col-md-6 auth-right">
            <small class="text-primary fw-semibold">LOGIN</small>
            <h3 class="mt-2">Welcome Back</h3>
            <p class="text-muted mb-4">Silakan login untuk melanjutkan</p>

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ url('/login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="example@email.com" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="********" required>
                </div>

                <button class="btn btn-primary w-100">Login</button>
            </form>

            <p class="text-center mt-4 small">
                Belum punya akun?
                <a href="/register" class="fw-semibold text-decoration-none">Register</a>
            </p>
        </div>

    </div>
</div>

</body>
</html>
