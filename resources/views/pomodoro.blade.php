@extends('layouts.app')

@section('content')
<style>
    @keyframes pulse-ring {
        0% { transform: rotate(-90deg) scale(1); }
        50% { transform: rotate(-90deg) scale(1.02); }
        100% { transform: rotate(-90deg) scale(1); }
    }
    .timer-running svg { animation: pulse-ring 2s ease-in-out infinite; }
</style>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.2/dist/confetti.browser.min.js"></script>

<div class="page-title">🍅 Pomodoro Timer</div>
<div class="page-subtitle">Stay focused, study smarter</div>

<div style="display: grid; grid-template-columns: 1fr; gap: 24px;">

    {{-- Timer Card --}}
    <div class="card" style="text-align: center; padding: 48px 32px;" x-data="pomodoro()" x-init="init()">

        {{-- Mode Tabs --}}
        <div style="display: inline-flex; background: #F0EBE5; border-radius: 12px; padding: 4px; margin-bottom: 40px;">
            <button @click="setMode('focus')"
                :style="mode === 'focus' ? 'background: #685D54; color: #FBF7F4;' : 'background: transparent; color: #A39382;'"
                style="padding: 8px 20px; border-radius: 10px; border: none; cursor: pointer; font-size: 13px; font-weight: 600; font-family: DM Sans, sans-serif; transition: all 0.2s;">
                Focus
            </button>
            <button @click="setMode('short')"
                :style="mode === 'short' ? 'background: #685D54; color: #FBF7F4;' : 'background: transparent; color: #A39382;'"
                style="padding: 8px 20px; border-radius: 10px; border: none; cursor: pointer; font-size: 13px; font-weight: 600; font-family: DM Sans, sans-serif; transition: all 0.2s;">
                Short Break
            </button>
            <button @click="setMode('long')"
                :style="mode === 'long' ? 'background: #685D54; color: #FBF7F4;' : 'background: transparent; color: #A39382;'"
                style="padding: 8px 20px; border-radius: 10px; border: none; cursor: pointer; font-size: 13px; font-weight: 600; font-family: DM Sans, sans-serif; transition: all 0.2s;">
                Long Break
            </button>
        </div>

        {{-- Circular Timer --}}
        <div style="position: relative; width: 260px; height: 260px; margin: 0 auto 40px;" x-bind:class="running ? 'timer-running' : ''">
            <svg width="260" height="260" style="transform: rotate(-90deg);">
                <circle cx="130" cy="130" r="115" fill="none" stroke="#E5DED2" stroke-width="10"/>
                <circle cx="130" cy="130" r="115" fill="none" stroke="#685D54" stroke-width="10"
                    stroke-linecap="round"
                    :stroke-dasharray="circumference"
                    :stroke-dashoffset="dashOffset"
                    style="transition: stroke-dashoffset 1s linear;"/>
            </svg>
            <div style="position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                <div x-text="timeDisplay" style="font-family: 'Playfair Display', serif; font-size: 56px; font-weight: 700; color: #232323; line-height: 1;"></div>
                <div x-text="modeLabel" style="font-size: 13px; color: #A39382; margin-top: 8px; text-transform: uppercase; letter-spacing: 1px;"></div>
            </div>
        </div>

        {{-- Controls --}}
        <div style="display: flex; gap: 12px; justify-content: center; margin-bottom: 32px;">
            <button @click="reset()"
                style="padding: 12px 24px; border-radius: 12px; border: 1.5px solid #E5DED2; background: transparent; color: #A39382; cursor: pointer; font-size: 14px; font-weight: 600; font-family: DM Sans, sans-serif; transition: all 0.2s;"
                onmouseover="this.style.borderColor='#A39382'" onmouseout="this.style.borderColor='#E5DED2'">
                ↺ Reset
            </button>
            <button @click="toggle()"
                :style="running ? 'background: #a05040;' : 'background: #685D54;'"
                style="padding: 12px 40px; border-radius: 12px; border: none; color: #FBF7F4; cursor: pointer; font-size: 16px; font-weight: 700; font-family: DM Sans, sans-serif; transition: all 0.2s; letter-spacing: 0.5px;"
                x-text="running ? '⏸ Pause' : '▶ Start'">
            </button>
        </div>

        {{-- Session counter --}}
        <div style="display: flex; gap: 8px; justify-content: center; margin-bottom: 24px;">
            <template x-for="i in 4">
                <div :style="i <= sessions ? 'background: #685D54;' : 'background: #E5DED2;'"
                    style="width: 12px; height: 12px; border-radius: 50%; transition: background 0.3s;"></div>
            </template>
        </div>
        <div style="font-size: 13px; color: #A39382;">
            Session <span x-text="sessions"></span> of 4 · <span x-text="totalCompleted"></span> completed today
        </div>
    </div>

    {{-- Right Panel --}}
    <div style="display: flex; flex-direction: column; gap: 16px;">

        {{-- Subject Selector --}}
        <div class="card">
            <div class="section-title">Studying now</div>
            <select id="subject-select" style="margin-bottom: 0;">
                <option value="">Select a subject...</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Session Log --}}
        <div class="card">
            <div class="section-title">Today's Sessions</div>
            <div id="session-log" style="display: flex; flex-direction: column; gap: 8px;">
                <div style="font-size: 13px; color: #A39382; text-align: center; padding: 16px 0;">
                    No sessions yet — start your first one! 🍅
                </div>
            </div>
        </div>

        {{-- Tips --}}
        <div class="card" style="background: #E5DED2; border: none;">
            <div class="section-title">💡 Focus Tips</div>
            <div style="font-size: 13px; color: #685D54; line-height: 1.8;">
                <div>📵 Put your phone face down</div>
                <div>🎵 Try lo-fi music or white noise</div>
                <div>💧 Keep water nearby</div>
                <div>🪟 Good lighting helps focus</div>
            </div>
        </div>
    </div>
</div>

<script>
function pomodoro() {
    return {
        mode: 'focus',
        running: false,
        seconds: 25 * 60,
        totalSeconds: 25 * 60,
        sessions: 0,
        totalCompleted: 0,
        timer: null,
        circumference: 2 * Math.PI * 115,

        get dashOffset() {
            return this.circumference - (this.seconds / this.totalSeconds) * this.circumference;
        },
        get timeDisplay() {
            const m = Math.floor(this.seconds / 60).toString().padStart(2, '0');
            const s = (this.seconds % 60).toString().padStart(2, '0');
            return `${m}:${s}`;
        },
        get modeLabel() {
            return this.mode === 'focus' ? 'Focus Time' : this.mode === 'short' ? 'Short Break' : 'Long Break';
        },

        init() {},

        setMode(m) {
            this.mode = m;
            this.running = false;
            clearInterval(this.timer);
            if (m === 'focus') this.totalSeconds = 25 * 60;
            else if (m === 'short') this.totalSeconds = 5 * 60;
            else this.totalSeconds = 15 * 60;
            this.seconds = this.totalSeconds;
        },

        toggle() {
            if (this.running) {
                clearInterval(this.timer);
                this.running = false;
            } else {
                this.running = true;
                this.timer = setInterval(() => {
                    if (this.seconds > 0) {
                        this.seconds--;
                    } else {
                        clearInterval(this.timer);
                        this.running = false;
                        this.onComplete();
                    }
                }, 1000);
            }
        },

        reset() {
            clearInterval(this.timer);
            this.running = false;
            this.seconds = this.totalSeconds;
        },

        onComplete() {
            if (this.mode === 'focus') {
                this.sessions = this.sessions >= 4 ? 1 : this.sessions + 1;
                this.totalCompleted++;
                this.saveSession();
                this.fireConfetti();
                this.showToast('🎉 Focus session done! Time for a break!', 'success');
            } else {
                this.showToast('⏰ Break over! Back to focus mode!', 'warning');
            }
            if (this.mode === 'focus') this.setMode('short');
            else this.setMode('focus');
        },

        fireConfetti() {
            const colors = ['#685D54', '#A39382', '#E5DED2', '#a8b89a', '#c9a99a'];
            confetti({ particleCount: 120, spread: 80, origin: { y: 0.6 }, colors });
            setTimeout(() => {
                confetti({ particleCount: 60, angle: 60, spread: 55, origin: { x: 0 }, colors });
                confetti({ particleCount: 60, angle: 120, spread: 55, origin: { x: 1 }, colors });
            }, 300);
        },

        showToast(message, type) {
            const toast = document.createElement('div');
            toast.style.cssText = `
                position: fixed; top: 24px; right: 24px; z-index: 9999;
                background: ${type === 'success' ? '#685D54' : '#A39382'};
                color: #FBF7F4; padding: 16px 24px; border-radius: 14px;
                font-size: 15px; font-weight: 500; font-family: DM Sans, sans-serif;
                box-shadow: 0 8px 32px rgba(104,93,84,0.3);
                transform: translateX(120%); transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            `;
            toast.textContent = message;
            document.body.appendChild(toast);
            setTimeout(() => toast.style.transform = 'translateX(0)', 10);
            setTimeout(() => {
                toast.style.transform = 'translateX(120%)';
                setTimeout(() => toast.remove(), 400);
            }, 4000);
        },

        saveSession() {
            const subjectId = document.getElementById('subject-select').value;
            if (!subjectId) return;
            fetch('/sessions/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ subject_id: subjectId, duration_mins: 25 })
            }).then(r => r.json()).then(data => {
                if (data.success) this.addToLog(subjectId);
            });
        },

        addToLog(subjectId) {
            const select = document.getElementById('subject-select');
            const subjectName = select.options[select.selectedIndex].text;
            const log = document.getElementById('session-log');
            const now = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            if (log.querySelector('div[style*="text-align: center"]')) log.innerHTML = '';
            const entry = document.createElement('div');
            entry.style.cssText = 'display: flex; justify-content: space-between; align-items: center; padding: 8px 12px; background: #FBF7F4; border-radius: 10px; font-size: 13px;';
            entry.innerHTML = `<span>🍅 ${subjectName}</span><span style="color: #A39382;">${now} · 25 mins</span>`;
            log.prepend(entry);
        }
    }
}
</script>
@endsection