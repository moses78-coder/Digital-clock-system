# Digital-clock-system
# ChronoDesk - Digital Clock System

## Features
- Live clock with seconds, weekday and date
- 12/24-hour format
- Selectable display time zone
- Stopwatch: start, pause, lap and reset
- Countdown timer
- MySQLi-backed alarm creation, enable/disable and delete
- One-time and daily repeating alarms
- Sound alert and optional browser notification

## Requirements
XAMPP (Apache and MySQL), VS Code and a modern browser.

## Installation
1. Extract this folder into `C:\xampp\htdocs\digital-clock-system`.
2. Start Apache and MySQL in XAMPP.
3. Open `http://localhost/phpmyadmin`.
4. Select Import, choose `database/digital_clock.sql`, and click Go.
5. Visit `http://localhost/digital-clock-system/`.

Default MySQL settings are in `config/database.php`: host localhost, user root, blank password. Update them if your local MySQL password differs.

## Alarm limitations
- The browser tab must remain open for the app to check alarm times.
- Allow notifications if desktop notifications are wanted. Sound alerts depend on browser audio permissions; interact with the page first.
- Alarms use the computer's local time. The time-zone selector changes the large clock display, not the alarm schedule.
- Daily alarms repeat at the stored local computer time.

This is an academic/local project. Before public deployment, add user accounts, access controls, HTTPS, backups, audit logging and security testing.
