<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>StudBud 📚</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DM Sans', sans-serif; background: #FBF7F4; color: #232323; }
        .sidebar {
            width: 260px; background: #232323; min-height: 100vh;
            padding: 32px 20px; position: fixed; top: 0; left: 0;
            display: flex; flex-direction: column;
        }
        .sidebar .logo { font-family: 'Playfair Display', serif; font-size: 24px; font-weight: 700; color: #E5DED2; margin-bottom: 8px; display: block; }
        .sidebar .logo-sub { font-size: 12px; color: #685D54; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 40px; display: block; }
        .nav-label { font-size: 10px; color: #685D54; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 8px; margin-top: 8px; padding: 0 12px; }
        .sidebar a { display: flex; align-items: center; gap: 12px; padding: 11px 14px; border-radius: 12px; color: #A39382; text-decoration: none; margin-bottom: 2px; font-size: 14px; font-weight: 500; transition: all 0.2s; }
        .sidebar a:hover { background: #2d2d2d; color: #E5DED2; }
        .sidebar a.active { background: #685D54; color: #FBF7F4; }
        .sidebar a .icon { font-size: 16px; width: 20px; text-align: center; }
        .sidebar-bottom { margin-top: auto; padding-top: 20px; border-top: 1px solid #2d2d2d; }
        .main { margin-left: 260px; padding: 40px 48px; min-height: 100vh; }
        .card { background: #FFFFFF; border-radius: 20px; padding: 28px; margin-bottom: 20px; border: 1px solid #E5DED2; box-shadow: 0 2px 12px rgba(168,147,130,0.08); }
        .card-oat { background: #E5DED2; border-radius: 20px; padding: 28px; margin-bottom: 20px; border: 1px solid #d4ccc0; }
        .stat-card { background: #FFFFFF; border-radius: 16px; padding: 20px 24px; border: 1px solid #E5DED2; text-align: center; box-shadow: 0 2px 8px rgba(168,147,130,0.08); }
        .stat-number { font-size: 32px; font-weight: 700; color: #685D54; font-family: 'Playfair Display', serif; }
        .stat-label { font-size: 12px; color: #A39382; margin-top: 4px; letter-spacing: 0.5px; text-transform: uppercase; }
        .btn { padding: 10px 20px; border-radius: 10px; border: none; cursor: pointer; font-size: 14px; font-weight: 500; transition: all 0.2s; font-family: 'DM Sans', sans-serif; }
        .btn-primary { background: #685D54; color: #FBF7F4; }
        .btn-primary:hover { background: #574d45; transform: translateY(-1px); }
        .btn-danger { background: #c9a99a; color: #FBF7F4; }
        .btn-danger:hover { background: #b8907f; }
        .btn-success { background: #a8b89a; color: #FBF7F4; }
        .btn-success:hover { background: #8fa37f; }
        .btn-outline { background: transparent; color: #685D54; border: 1.5px solid #685D54; }
        .btn-outline:hover { background: #685D54; color: #FBF7F4; }
        .badge { padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; letter-spacing: 0.5px; }
        .badge-warning { background: #f5e6d0; color: #a07040; }
        .badge-danger { background: #f5d8d0; color: #a05040; }
        .badge-success { background: #d8ecd0; color: #4a7a40; }
        .badge-mocha { background: #685D54; color: #FBF7F4; }
        input, select, textarea { background: #FBF7F4; border: 1.5px solid #E5DED2; border-radius: 10px; padding: 10px 14px; color: #232323; width: 100%; margin-bottom: 12px; font-size: 14px; font-family: 'DM Sans', sans-serif; transition: border 0.2s; }
        input:focus, select:focus { outline: none; border-color: #A39382; }
        .alert { padding: 14px 18px; border-radius: 12px; margin-bottom: 12px; font-size: 14px; }
        .alert-success { background: #d8ecd0; color: #4a7a40; border: 1px solid #c0dab0; }
        .alert-warning { background: #f5e6d0; color: #a07040; border: 1px solid #e8d0b0; }
        .alert-danger { background: #f5d8d0; color: #a05040; border: 1px solid #e8c0b0; }
        .page-title { font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 700; color: #232323; margin-bottom: 8px; }
        .page-subtitle { font-size: 14px; color: #A39382; margin-bottom: 28px; }
        .divider { border: none; border-top: 1px solid #E5DED2; margin: 16px 0; }
        .section-title { font-size: 15px; font-weight: 600; color: #685D54; margin-bottom: 16px; letter-spacing: 0.3px; }
   
        /* ── MOBILE RESPONSIVE ── */
@media (max-width: 768px) {
    .sidebar {
        width: 100%; min-height: auto; position: relative;
        flex-direction: row; flex-wrap: wrap;
        padding: 16px; gap: 8px;
    }
    .sidebar .logo { font-size: 18px; margin-bottom: 0; }
    .sidebar .logo-sub { display: none; }
    .nav-label { display: none; }
    .sidebar a { padding: 8px 10px; font-size: 12px; margin-bottom: 0; }
    .sidebar a .icon { font-size: 14px; }
    .sidebar-bottom { margin-top: 0; padding-top: 0; border-top: none; width: 100%; }
    .sidebar-bottom form { display: inline; }
    .sidebar-bottom button { padding: 8px 16px; font-size: 12px; }
    .sidebar-bottom div { display: none; }
    .main { margin-left: 0; padding: 20px 16px; }
    .page-title { font-size: 22px; }
}
   </style>
</head>
<body>
    <div class="sidebar">
        <span class="logo">StudBud</span>
        <span class="logo-sub">Your study companion</span>

        <span class="nav-label">Menu</span>
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span class="icon">🏠</span> Dashboard
        </a>
        <a href="{{ route('subjects.index') }}" class="{{ request()->routeIs('subjects.*') ? 'active' : '' }}">
            <span class="icon">📖</span> Subjects
        </a>
        <a href="{{ route('tasks.index') }}" class="{{ request()->routeIs('tasks.*') ? 'active' : '' }}">
            <span class="icon">✅</span> Tasks
        </a>
        <a href="{{ route('pomodoro') }}" class="{{ request()->routeIs('pomodoro') ? 'active' : '' }}">
            <span class="icon">🍅</span> Pomodoro
        </a>

        <span class="nav-label" style="margin-top: 16px;">Insights</span>
        <a href="{{ route('progress') }}" class="{{ request()->routeIs('progress') ? 'active' : '' }}">
            <span class="icon">📊</span> Progress
        </a>
        <a href="{{ route('suggestions') }}" class="{{ request()->routeIs('suggestions') ? 'active' : '' }}">
            <span class="icon">🧠</span> Suggestions
        </a>
        <a href="{{ route('goals.index') }}" class="{{ request()->routeIs('goals.*') ? 'active' : '' }}">
            <span class="icon">🎯</span> Goals
        </a>

        <div class="sidebar-bottom">
            <div style="font-size: 12px; color: #685D54; margin-bottom: 12px;">
                Logged in as<br>
                <span style="color: #A39382; font-weight: 500;">{{ Auth::user()->name }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline" style="width: 100%; border-color: #685D54; color: #A39382;">
                    Logout
                </button>
            </form>
        </div>
    </div>

    <div class="main">
        @if(session('success'))
            <div class="alert alert-success">✓ {{ session('success') }}</div>
        @endif
        @yield('content')
    </div>
</body>
</html>