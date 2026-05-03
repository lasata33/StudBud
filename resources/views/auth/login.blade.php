<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — StudBud</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DM Sans', sans-serif; background: #FBF7F4; color: #232323; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .container { width: 100%; max-width: 420px; padding: 24px; }
        .logo { font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 700; color: #232323; text-align: center; margin-bottom: 8px; }
        .subtitle { font-size: 14px; color: #A39382; text-align: center; margin-bottom: 32px; }
        .card { background: #FFFFFF; border-radius: 20px; padding: 32px; border: 1px solid #E5DED2; box-shadow: 0 4px 24px rgba(168,147,130,0.1); }
        label { font-size: 12px; color: #A39382; display: block; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px; }
        input { background: #FBF7F4; border: 1.5px solid #E5DED2; border-radius: 10px; padding: 12px 14px; color: #232323; width: 100%; margin-bottom: 16px; font-size: 14px; font-family: 'DM Sans', sans-serif; transition: border 0.2s; }
        input:focus { outline: none; border-color: #A39382; }
        .btn { width: 100%; padding: 12px; border-radius: 10px; border: none; background: #685D54; color: #FBF7F4; font-size: 15px; font-weight: 600; cursor: pointer; font-family: 'DM Sans', sans-serif; transition: all 0.2s; margin-top: 8px; }
        .btn:hover { background: #574d45; transform: translateY(-1px); }
        .link { color: #685D54; text-decoration: none; font-size: 13px; }
        .link:hover { text-decoration: underline; }
        .error { background: #f5d8d0; color: #a05040; border: 1px solid #e8c0b0; border-radius: 10px; padding: 10px 14px; font-size: 13px; margin-bottom: 16px; }
        .checkbox-wrap { display: flex; align-items: center; gap: 8px; margin-bottom: 16px; }
        .checkbox-wrap input { width: auto; margin-bottom: 0; }
        .bottom { display: flex; justify-content: space-between; align-items: center; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">StudBud ☕</div>
        <div class="subtitle">Welcome back! Ready to study?</div>

        <div class="card">
            @if($errors->any())
                <div class="error">{{ $errors->first() }}</div>
            @endif

            @if(session('status'))
                <div style="background: #d8ecd0; color: #4a7a40; border-radius: 10px; padding: 10px 14px; font-size: 13px; margin-bottom: 16px;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="your@email.com">

                <label>Password</label>
                <input type="password" name="password" required placeholder="••••••••">

                <div class="checkbox-wrap">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember" style="margin-bottom: 0; text-transform: none; font-size: 13px; color: #685D54;">Remember me</label>
                </div>

                <button type="submit" class="btn">Log in →</button>
            </form>

            <div class="bottom">
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="link">Forgot password?</a>
                @endif
                <a href="{{ route('register') }}" class="link">Create account →</a>
            </div>
        </div>
    </div>
</body>
</html>