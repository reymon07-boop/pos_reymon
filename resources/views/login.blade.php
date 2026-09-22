<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remon Thrift House - Login</title>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
    :root {
        --primary: #00ffaa;
        --secondary: #00d9ff;
        --bg: #020617;
        --card: rgba(15, 23, 42, 0.94);
        --border: rgba(255, 255, 255, 0.1);
        --text: #f8fafc;
        --muted: #94a3b8;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    body {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--bg);
        color: var(--text);
        padding: 20px;
        position: relative;
        overflow: hidden;
    }


    body::before {
        content: "";
        position: fixed;
        inset: -50%;
        z-index: -1;
        pointer-events: none;
        background-image:
            radial-gradient(circle at 20% 30%, rgba(0, 255, 170, 0.25), transparent 40%),
            radial-gradient(circle at 80% 70%, rgba(0, 217, 255, 0.2), transparent 40%),
            radial-gradient(circle at 50% 50%, rgba(124, 58, 237, 0.18), transparent 50%);
        background-size: 100% 100%;
    }


    .login-container {
        width: 100%;
        max-width: 420px;
    }

    .login-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 35px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }


    .status {
        width: fit-content;
        margin: 0 auto 20px;
        padding: 8px 16px;
        border: 1px solid rgba(0, 255, 170, 0.5);
        border-radius: 30px;
        color: var(--primary);
        background: rgba(0, 255, 170, 0.07);
        font-size: 13px;
    }


    .logo {
        width: 70px;
        height: 70px;
        margin: 0 auto 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        border: 1px solid rgba(0, 255, 170, 0.6);
        color: var(--primary);
        font-size: 28px;
        background: rgba(0, 255, 170, 0.06);
        box-shadow: 0 0 15px rgba(0, 255, 170, 0.2);
    }

    .title {
        text-align: center;
        font-size: 25px;
        margin-bottom: 7px;
        font-weight: 700;
    }

    .title span {
        color: var(--primary);
        text-shadow: 0 0 10px rgba(0, 255, 170, 0.3);
    }

    .subtitle {
        text-align: center;
        color: var(--muted);
        font-size: 13px;
        margin-bottom: 28px;
    }


    .alert {
        padding: 11px 14px;
        margin-bottom: 20px;
        border-radius: 10px;
        font-size: 13px;
    }

    .alert-success {
        color: var(--primary);
        background: rgba(0, 255, 170, 0.08);
        border: 1px solid rgba(0, 255, 170, 0.3);
    }

    .form-group {
        margin-bottom: 18px;
    }

    .input-label {
        display: block;
        margin-bottom: 7px;
        color: #cbd5e1;
        font-size: 12px;
        font-weight: bold;
    }

    .input-wrapper {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
        pointer-events: none;
    }

    .form-input {
        width: 100%;
        height: 50px;
        padding: 0 45px;
        border: 1px solid var(--border);
        border-radius: 12px;
        outline: none;
        background: rgba(255, 255, 255, 0.04);
        color: white;
        font-size: 14px;
    }

    .form-input:focus {
        border-color: var(--primary);
        background: rgba(255, 255, 255, 0.06);
        box-shadow: 0 0 15px rgba(0, 255, 170, 0.15);
    }

    .form-input::placeholder {
        color: #64748b;
    }


    .toggle-password {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: transparent;
        color: #64748b;
        cursor: pointer;
        font-size: 17px;
    }

    .toggle-password:hover {
        color: var(--primary);
    }


    .error {
        display: block;
        margin-top: 6px;
        color: #f87171;
        font-size: 12px;
    }


    .btn-login {
        width: 100%;
        height: 52px;
        margin-top: 5px;
        border: none;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: #020617;
        font-size: 15px;
        font-weight: bold;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-login:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }


    @media (max-width: 480px) {
        body {
            padding: 15px;
        }

        .login-card {
            padding: 28px 20px;
        }

        .title {
            font-size: 22px;
        }

        .logo {
            width: 62px;
            height: 62px;
            font-size: 25px;
        }
    }
    </style>
</head>

<body>

    <div class="login-container">


        <div class="status">
            <i class="bi bi-shield-check"></i>
            Sistem Login
        </div>


        <div class="login-card">


            <div class="logo">
                <i class="bi bi-bag-heart-fill"></i>
            </div>


            <h1 class="title">
                Remon <span>Thrift</span> House
            </h1>

            <p class="subtitle">
                Akses Portal Kasir & Manajemen Inventaris
            </p>


            @if (session('status'))
            <div class="alert alert-success">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('status') }}
            </div>
            @endif

            <form method="POST" action="{{ route('login.process') }}" id="loginForm">
                @csrf


                <div class="form-group">
                    <label class="input-label" for="email">ALAMAT EMAIL</label>

                    <div class="input-wrapper">
                        <i class="bi bi-envelope input-icon"></i>
                        <input type="email" name="email" id="email" class="form-input" value="{{ old('email') }}"
                            placeholder="admin@remonthrift.com" required autofocus>
                    </div>

                    @error('email')
                    <small class="error">
                        <i class="bi bi-exclamation-circle"></i>
                        {{ $message }}
                    </small>
                    @enderror
                </div>


                <div class="form-group">
                    <label class="input-label" for="password">KATA SANDI</label>

                    <div class="input-wrapper">
                        <i class="bi bi-lock input-icon"></i>
                        <input type="password" name="password" id="password" class="form-input"
                            placeholder="Masukkan kata sandi" required>

                        <button type="button" class="toggle-password" id="togglePassword">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>

                    @error('password')
                    <small class="error">
                        <i class="bi bi-exclamation-circle"></i>
                        {{ $message }}
                    </small>
                    @enderror
                </div>


                <button type="submit" class="btn-login" id="submitBtn">
                    <span>Masuk</span>
                    <i class="bi bi-arrow-right-circle"></i>
                </button>
            </form>

        </div>

    </div>

    <script>
    const password = document.getElementById('password');
    const toggle = document.getElementById('togglePassword');

    toggle.addEventListener('click', function() {
        const isPassword = password.type === 'password';

        password.type = isPassword ? 'text' : 'password';

        this.innerHTML = isPassword ?
            '<i class="bi bi-eye-slash"></i>' :
            '<i class="bi bi-eye"></i>';
    });


    const form = document.getElementById('loginForm');
    const button = document.getElementById('submitBtn');

    form.addEventListener('submit', function() {
        button.disabled = true;
        button.innerHTML = `
                <span>Memproses...</span>
            `;
    });
    </script>

</body>

</html>