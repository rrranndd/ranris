<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
    <style>
        body {
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
            background:#f5f6fa;
            font-family:sans-serif;
        }

        .login-box {
            background:white;
            padding:30px;
            border-radius:12px;
            box-shadow:0 10px 20px rgba(0,0,0,0.1);
            width:300px;
        }

        input {
            width:100%;
            padding:10px;
            margin:10px 0;
            border:1px solid #ccc;
            border-radius:6px;
        }

        button {
            width:100%;
            padding:10px;
            background:#c89b3c;
            color:white;
            border:none;
            border-radius:6px;
            cursor:pointer;
        }

        .error {
            color:red;
            font-size:13px;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Login Admin</h2>

    @if(session('error'))
        <p class="error">{{ session('error') }}</p>
    @endif

    <form method="POST" action="/login">
        @csrf

        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">

        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>