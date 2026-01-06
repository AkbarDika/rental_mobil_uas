<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f6fa;
        }
        .auth-card {
            min-height: 90vh;
        }
        .auth-left {
            background: linear-gradient(135deg, #111827, #1f2937);
            color: #fff;
            border-radius: 20px 0 0 20px;
        }
        .auth-right {
            border-radius: 0 20px 20px 0;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px;
        }
        .btn-primary {
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
        }
    </style>

     @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<div class="container d-flex align-items-center justify-content-center auth-card">
    <div class="row shadow-lg w-100" style="max-width: 1000px; border-radius: 20px;">

        <!-- LEFT SIDE -->
        <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center auth-left p-5">
            <div>
                <h2 class="fw-bold mb-3">Welcome!</h2>
                <p class="opacity-75">
                    Daftarkan akun Anda dan mulai menggunakan sistem rental mobil dengan mudah.
                </p>
                <img src="https://cdn-icons-png.flaticon.com/512/942/942748.png"
                     class="img-fluid mt-4"
                     style="max-width: 260px;">
            </div>
        </div>

        <!-- RIGHT SIDE -->
        <div class="col-md-6 bg-white p-5 auth-right">
            <h4 class="fw-bold mb-1">Create an Account</h4>
            <p class="text-muted mb-4">Isi data di bawah untuk mendaftar</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nama -->
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <!-- Username -->
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <!-- Button -->
                <button type="submit" class="btn btn-primary w-100">
                    Register
                </button>

                <p class="text-center mt-4 mb-0">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="fw-semibold text-decoration-none">
                        Login
                    </a>
                </p>
            </form>
        </div>

    </div>
</div>

</body>
</html>
