<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - ZenithTix</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #0b0b0c;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-box {
            width: 380px;
            background: rgba(255,255,255,0.06);
            padding: 30px;
            border-radius: 18px;
            border: 1px solid rgba(255,255,255,0.12);
            backdrop-filter: blur(16px);
            text-align: center;
        }

        h2 {
            color: #ffdd00;
            font-weight: 800;
            margin-bottom: 18px;
        }

        .input-field {
            width: 100%;
            padding: 12px;
            margin: 10px 0 18px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.12);
            background: rgba(255,255,255,0.05);
            color: white;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(90deg, #ffdd00, #ff0033);
            color: #000;
            font-weight: 800;
            cursor: pointer;
            transition: 0.25s;
        }

        .login-btn:hover {
            transform: scale(1.05);
        }

        .error-msg {
            color: #ff3b3b;
            margin-bottom: 14px;
            font-size: 0.9rem;
        }
    </style>

</head>
<body>

<div class="login-box">
    <h2>Admin Login</h2>

    @if ($errors->any())
        <div class="error-msg">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('admin.login.submit') }}" method="POST">
    @csrf
        <input type="email" name="email" placeholder="Admin Email">
        <input type="password" name="password" placeholder="Password">
        <button type="submit">Login Admin</button>
    </form>

</div>

</body>
</html>
