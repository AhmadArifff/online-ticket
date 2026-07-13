<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Tiket Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }
        .register-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .register-header h2 {
            margin-bottom: 10px;
        }
        .register-body {
            padding: 40px 30px;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #dee2e6;
            padding: 12px 15px;
            font-size: 14px;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            color: white;
            width: 100%;
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
            color: white;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }
        .text-center a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        .text-center a:hover {
            color: #764ba2;
        }
        .terms-text {
            font-size: 13px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="register-container" style="width: 100%; max-width: 450px;">
        <div class="register-header">
            <h2><i class="bi bi-ticket-perforated"></i> Tiket Online</h2>
            <p class="mb-0">Buat Akun Baru</p>
        </div>
        
        <div class="register-body">
            <form method="POST" action="/register">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="form-label" for="first_name">Nama Depan</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="first_name" 
                            name="first_name" 
                            placeholder="Nama depan"
                            required
                        >
                    </div>

                    <div class="col-md-6 form-group">
                        <label class="form-label" for="last_name">Nama Belakang</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="last_name" 
                            name="last_name" 
                            placeholder="Nama belakang"
                            required
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input 
                        type="email" 
                        class="form-control" 
                        id="email" 
                        name="email" 
                        placeholder="nama@example.com"
                        required
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="phone">Nomor Telepon</label>
                    <input 
                        type="tel" 
                        class="form-control" 
                        id="phone" 
                        name="phone" 
                        placeholder="08xxxxxxxxxx"
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input 
                        type="password" 
                        class="form-control" 
                        id="password" 
                        name="password" 
                        placeholder="Min. 8 karakter"
                        required
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirm">Konfirmasi Password</label>
                    <input 
                        type="password" 
                        class="form-control" 
                        id="password_confirm" 
                        name="password_confirmation" 
                        placeholder="Ulangi password"
                        required
                    >
                </div>

                <div class="form-group form-check">
                    <input 
                        type="checkbox" 
                        class="form-check-input" 
                        id="terms" 
                        name="terms"
                        required
                    >
                    <label class="form-check-label terms-text" for="terms">
                        Saya setuju dengan <a href="/terms">Syarat & Ketentuan</a> dan <a href="/privacy">Kebijakan Privasi</a>
                    </label>
                </div>

                <button type="submit" class="btn btn-register">
                    <i class="bi bi-person-plus"></i> Daftar Sekarang
                </button>

                <div class="text-center mt-4">
                    <p class="mb-0">Sudah punya akun? <a href="/login">Masuk di sini</a></p>
                </div>
            </form>
        </div>
    </div>

    @if ($errors->any())
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1200;">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Kesalahan saat mendaftar:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @include('components.toast')
    @if(session()->has('toast'))
        <script id="server-toast-data" type="application/json">{!! json_encode(session('toast')) !!}</script>
    @else
        <script id="server-toast-data" type="application/json">null</script>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
