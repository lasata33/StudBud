# 📚 StudBud — Smart Study Planner

> A free all-in-one study companion built for students who want to stay organised, focused, and consistent.

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Alpine.js](https://img.shields.io/badge/Alpine.js-3-77C1D2?style=for-the-badge&logo=alpine.js&logoColor=white)

---

## ✨ Features

### 🧩 Core
- **Subject Manager** — Add subjects with exam dates and auto priority ranking
- **Task Tracker** — Manage tasks per subject with deadlines and completion tracking
- **Study Dashboard** — Overview of today's tasks, streak, and study time

### ⏱️ Pomodoro Timer
- 25 min focus / 5 min short break / 15 min long break
- Beautiful circular progress ring with pulse animation
- Confetti celebration + toast notifications on session complete
- Session counter and daily log

### 📊 Progress & Insights
- Weekly study hours bar chart (Chart.js)
- Subject-wise progress bars
- Smart AI-like study suggestions based on real patterns
- Daily streak system with motivation tracking

### 🎯 Smart Features
- Auto priority ranking based on exam date proximity
- "You haven't studied X today" nudges
- Overdue task alerts
- Daily goal setting and tracking

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 12 |
| Frontend | Blade + Alpine.js |
| Styling | Custom CSS (Milk/Oat/Mocha palette) |
| Charts | Chart.js |
| Auth | Laravel Breeze |
| Database | MySQL |
| Build Tool | Vite |

---

## 🚀 Installation

```bash
# Clone the repo
git clone https://github.com/lasata33/StudBud.git
cd StudBud

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Copy environment file
cp .env.example .env

# Generate app key
php artisan key:generate

# Set up your database in .env then run:
php artisan migrate

# Build assets
npm run build

# Start server
php artisan serve
```

---

## 🎨 UI Design

StudBud uses a warm, cozy color palette inspired by café aesthetics:

- **Milk** `#FBF7F4` — Page background
- **Oat** `#E5DED2` — Cards and borders  
- **Taupe** `#A39382` — Muted text and icons
- **Mocha** `#685D54` — Buttons, accents, sidebar active
- **Charcoal** `#232323` — Sidebar background and headings

---

## 📸 Pages

- 🏠 Landing page with animated floating cards
- 📊 Dashboard with circular goal ring
- 📖 Subject manager with priority badges
- ✅ Task tracker with deadline badges
- 🍅 Pomodoro timer with confetti
- 📈 Progress charts
- 🧠 Smart suggestions
- 🎯 Goal & streak tracker

---

## 👩‍💻 Developer

Built by **Lasata Maharjan** as an internship project.

> "Study smarter, not harder." ☕