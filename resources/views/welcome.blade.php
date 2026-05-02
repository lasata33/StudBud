<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudBud — Your Study Companion</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DM Sans', sans-serif; background: #FBF7F4; color: #232323; overflow-x: hidden; }

        /* Navbar */
        nav {
            display: flex; justify-content: space-between; align-items: center;
            padding: 24px 64px; position: fixed; top: 0; left: 0; right: 0;
            background: #FBF7F4ee; backdrop-filter: blur(8px); z-index: 100;
            border-bottom: 1px solid #E5DED2;
        }
        .nav-logo { font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 700; color: #232323; }
        .nav-links { display: flex; gap: 12px; align-items: center; }
        .btn-nav { padding: 10px 24px; border-radius: 10px; font-size: 14px; font-weight: 500; cursor: pointer; text-decoration: none; font-family: 'DM Sans', sans-serif; transition: all 0.2s; }
        .btn-ghost { background: transparent; color: #685D54; border: 1.5px solid #E5DED2; }
        .btn-ghost:hover { border-color: #685D54; }
        .btn-solid { background: #685D54; color: #FBF7F4; border: 1.5px solid #685D54; }
        .btn-solid:hover { background: #574d45; transform: translateY(-1px); }

        /* Hero */
        .hero {
            min-height: 100vh; display: flex; align-items: center;
            padding: 120px 64px 80px;
            background: linear-gradient(135deg, #FBF7F4 0%, #F0EBE5 100%);
        }
        .hero-content { max-width: 600px; }
        .hero-tag {
            display: inline-block; background: #E5DED2; color: #685D54;
            padding: 6px 16px; border-radius: 20px; font-size: 12px;
            font-weight: 600; letter-spacing: 1px; text-transform: uppercase;
            margin-bottom: 24px;
        }
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 64px; font-weight: 900; line-height: 1.1;
            color: #232323; margin-bottom: 24px;
        }
        .hero-title span { color: #685D54; }
        .hero-desc {
            font-size: 18px; color: #A39382; line-height: 1.7;
            margin-bottom: 40px; font-weight: 300;
        }
        .hero-buttons { display: flex; gap: 12px; flex-wrap: wrap; }
        .hero-visual {
            flex: 1; display: flex; justify-content: center; align-items: center;
            padding-left: 80px;
        }

        /* Floating cards in hero */
        .float-card {
            background: #FFFFFF; border-radius: 16px; padding: 16px 20px;
            border: 1px solid #E5DED2; box-shadow: 0 8px 32px rgba(168,147,130,0.15);
            position: absolute; animation: float 4s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
        }
        .hero-card-wrap { position: relative; width: 380px; height: 420px; }

        /* Features */
        .features { padding: 100px 64px; background: #FFFFFF; }
        .section-tag { font-size: 12px; color: #A39382; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 12px; }
        .section-title { font-family: 'Playfair Display', serif; font-size: 40px; font-weight: 700; color: #232323; margin-bottom: 16px; }
        .section-desc { font-size: 16px; color: #A39382; max-width: 480px; line-height: 1.7; margin-bottom: 60px; }
        .features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
        .feature-card {
            background: #FBF7F4; border-radius: 20px; padding: 32px;
            border: 1px solid #E5DED2; transition: all 0.3s;
        }
        .feature-card:hover { transform: translateY(-6px); box-shadow: 0 12px 40px rgba(168,147,130,0.15); }
        .feature-icon { font-size: 36px; margin-bottom: 16px; }
        .feature-title { font-size: 18px; font-weight: 600; color: #232323; margin-bottom: 8px; }
        .feature-desc { font-size: 14px; color: #A39382; line-height: 1.7; }

        /* Stats */
        .stats { padding: 80px 64px; background: #232323; }
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 32px; text-align: center; }
        .stat-num { font-family: 'Playfair Display', serif; font-size: 48px; font-weight: 700; color: #E5DED2; }
        .stat-lbl { font-size: 13px; color: #685D54; margin-top: 4px; text-transform: uppercase; letter-spacing: 1px; }

        /* CTA */
        .cta {
            padding: 100px 64px; text-align: center;
            background: linear-gradient(135deg, #F0EBE5 0%, #FBF7F4 100%);
        }
        .cta-title { font-family: 'Playfair Display', serif; font-size: 48px; font-weight: 700; color: #232323; margin-bottom: 16px; }
        .cta-desc { font-size: 18px; color: #A39382; margin-bottom: 40px; }

        /* Footer */
        footer {
            padding: 32px 64px; background: #232323;
            display: flex; justify-content: space-between; align-items: center;
            border-top: 1px solid #2d2d2d;
        }
        footer p { font-size: 13px; color: #685D54; }

        /* Animations */
        .fade-up { opacity: 0; transform: translateY(30px); transition: all 0.7s ease; }
        .fade-up.visible { opacity: 1; transform: translateY(0); }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav>
        <div class="nav-logo">StudBud ☕</div>
        <div class="nav-links">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-nav btn-solid">Go to Dashboard →</a>
            @else
                <a href="{{ route('login') }}" class="btn-nav btn-ghost">Log in</a>
                <a href="{{ route('register') }}" class="btn-nav btn-solid">Get started free</a>
            @endauth
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-tag">✨ Free for students</div>
            <h1 class="hero-title">
                Study smarter,<br>
                not <span>harder.</span>
            </h1>
            <p class="hero-desc">
                StudBud is your all-in-one study companion — track subjects, manage tasks, run Pomodoro sessions, and get smart suggestions to stay on top of your goals.
            </p>
            <div class="hero-buttons">
                <a href="{{ route('register') }}" class="btn-nav btn-solid" style="font-size: 16px; padding: 14px 32px;">Start studying free →</a>
                <a href="{{ route('login') }}" class="btn-nav btn-ghost" style="font-size: 16px; padding: 14px 32px;">Log in</a>
            </div>
        </div>

        <div class="hero-visual">
            <div class="hero-card-wrap">
                <!-- Main timer card -->
                <div class="float-card" style="top: 20px; left: 20px; width: 220px; animation-delay: 0s;">
                    <div style="font-size: 11px; color: #A39382; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Pomodoro Timer</div>
                    <div style="font-family: 'Playfair Display', serif; font-size: 40px; font-weight: 700; color: #685D54; text-align: center;">24:13</div>
                    <div style="text-align: center; font-size: 12px; color: #A39382; margin-top: 4px;">Focus Time 🍅</div>
                    <div style="background: #E5DED2; border-radius: 10px; height: 6px; margin-top: 12px; overflow: hidden;">
                        <div style="background: #685D54; width: 65%; height: 100%; border-radius: 10px;"></div>
                    </div>
                </div>

                <!-- Streak card -->
                <div class="float-card" style="top: 40px; right: 0px; width: 160px; animation-delay: 1s;">
                    <div style="text-align: center;">
                        <div style="font-size: 28px;">🔥🔥🔥</div>
                        <div style="font-family: 'Playfair Display', serif; font-size: 32px; font-weight: 700; color: #685D54;">12</div>
                        <div style="font-size: 11px; color: #A39382; text-transform: uppercase; letter-spacing: 1px;">Day Streak</div>
                    </div>
                </div>

                <!-- Task card -->
                <div class="float-card" style="bottom: 80px; left: 0px; width: 260px; animation-delay: 2s;">
                    <div style="font-size: 11px; color: #A39382; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px;">Today's Tasks</div>
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                        <div style="width: 3px; height: 28px; background: #A39382; border-radius: 4px;"></div>
                        <div>
                            <div style="font-size: 13px; font-weight: 500; text-decoration: line-through; color: #A39382;">Complete ER diagram</div>
                            <div style="font-size: 11px; color: #A39382;">DBMS</div>
                        </div>
                        <span style="margin-left: auto; background: #d8ecd0; color: #4a7a40; padding: 2px 8px; border-radius: 10px; font-size: 10px;">✓</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div style="width: 3px; height: 28px; background: #685D54; border-radius: 4px;"></div>
                        <div>
                            <div style="font-size: 13px; font-weight: 500;">Review use case diagrams</div>
                            <div style="font-size: 11px; color: #A39382;">Software Engineering</div>
                        </div>
                    </div>
                </div>

                <!-- Suggestion card -->
                <div class="float-card" style="bottom: 20px; right: 10px; width: 190px; animation-delay: 1.5s;">
                    <div style="font-size: 11px; color: #a07040; background: #f5e6d0; padding: 8px 12px; border-radius: 8px; line-height: 1.5;">
                        👀 You haven't studied <strong>DBMS</strong> today!
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="features">
        <div class="fade-up">
            <div class="section-tag">What's inside</div>
            <div class="section-title">Everything you need to study better</div>
            <div class="section-desc">Built for students who want to stay organised, focused, and consistent — without the overwhelm.</div>
        </div>
        <div class="features-grid fade-up">
            <div class="feature-card">
                <div class="feature-icon">🍅</div>
                <div class="feature-title">Pomodoro Timer</div>
                <div class="feature-desc">Beautiful circular timer with 25/5 minute sessions. Track every session and watch your streak grow.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📖</div>
                <div class="feature-title">Subject Manager</div>
                <div class="feature-desc">Add subjects, set exam dates, and get automatic priority ranking based on how close your exams are.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">✅</div>
                <div class="feature-title">Task Tracker</div>
                <div class="feature-desc">Never miss a deadline. Track tasks per subject with smart overdue alerts and completion progress.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🧠</div>
                <div class="feature-title">Smart Suggestions</div>
                <div class="feature-desc">Get personalised nudges like "You haven't studied DBMS today" based on your real study patterns.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <div class="feature-title">Progress Charts</div>
                <div class="feature-desc">Visual weekly study chart and subject-wise progress bars so you always know where you stand.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔥</div>
                <div class="feature-title">Streak System</div>
                <div class="feature-desc">Build daily study habits with a streak counter that keeps you motivated and coming back every day.</div>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="stats">
        <div class="stats-grid fade-up">
            <div>
                <div class="stat-num">25<span style="font-size: 28px;">min</span></div>
                <div class="stat-lbl">Focus sessions</div>
            </div>
            <div>
                <div class="stat-num">∞</div>
                <div class="stat-lbl">Subjects supported</div>
            </div>
            <div>
                <div class="stat-num">100%</div>
                <div class="stat-lbl">Free forever</div>
            </div>
            <div>
                <div class="stat-num">☕</div>
                <div class="stat-lbl">Cozy vibes only</div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta">
        <div class="fade-up">
            <div class="cta-title">Ready to study smarter? ☕</div>
            <div class="cta-desc">Join StudBud for free and take control of your study life.</div>
            <a href="{{ route('register') }}" class="btn-nav btn-solid" style="font-size: 16px; padding: 16px 40px; display: inline-block;">
                Get started for free →
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>© 2026 StudBud — Made with ☕ for students</p>
        <p>Built with Laravel 12</p>
    </footer>

    <script>
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) e.target.classList.add('visible');
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
    </script>
</body>
</html>