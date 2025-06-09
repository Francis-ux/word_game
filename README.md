<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Word Typing Game

A dynamic, web-based typing challenge built with Laravel, designed to test typing speed and accuracy. Players type randomly served words within a 60-second countdown, earning points for correct entries. The game features a leaderboard to track high scores and an admin panel to manage word lists.

## Features
- **Dynamic Word Generation**: Random words are fetched from the backend for each game session.
- **Scoring System**: Score based on correct words (10 points each), with accuracy and words-per-minute (WPM) tracking.
- **Countdown Timer**: 60-second game duration to challenge players.
- **Leaderboard**: Displays top 10 scores with player names, scores, accuracy, and WPM.
- **Admin Panel**: Allows administrators to add or delete words in the word list.
- **Responsive Design**: Built with Tailwind CSS for a clean, mobile-friendly interface.
- **Real-Time Feedback**: Immediate updates for score, accuracy, and WPM during gameplay.

## Prerequisites
- PHP >= 8.1
- Composer
- Laravel 11.x
- MySQL or SQLite (or another supported database)
- Node.js and npm (for Tailwind CSS, optional if using CDN)
- Web browser (e.g., Chrome, Firefox)

## Installation
1. **Clone the Repository**:
   ```bash
   git clone <repository-url>
   cd word-game
   ```

2. **Install Dependencies**:
   ```bash
   composer install
   npm install # Optional if using Tailwind CSS locally
   ```

3. **Configure Environment**:
   - Copy `.env.example` to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Update `.env` with your database credentials (e.g., MySQL or SQLite):
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=word_game
     DB_USERNAME=root
     DB_PASSWORD=
     ```

4. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

5. **Run Migrations and Seed Database**:
   ```bash
   php artisan migrate --seed
   ```

6. **Serve the Application**:
   ```bash
   php artisan serve
   ```
   Access the game at `http://localhost:8000`.

## Usage
### Playing the Game
1. Navigate to `http://localhost:8000`.
2. Click **Start Game** to begin.
3. Type the displayed word exactly as shown in the input field.
4. Score 10 points for each correct word.
5. The game ends after 60 seconds, showing your score, accuracy, and WPM.
6. Enter your name to submit your score to the leaderboard.
7. View the top 10 scores in the leaderboard section.

### Admin Panel
1. Navigate to `http://localhost:8000/admin/words`.
2. Add new words using the form.
3. Delete existing words from the list.
4. Note: The admin panel is not secured by default. Add authentication (e.g., Laravel Breeze or Sanctum) for production use.

## Project Structure
- `app/Models/Word.php`: Model for the words table.
- `app/Models/Leaderboard.php`: Model for the leaderboard table.
- `app/Http/Controllers/GameController.php`: Handles game logic, word fetching, and leaderboard.
- `app/Http/Controllers/AdminController.php`: Manages word list CRUD operations.
- `resources/views/game.blade.php`: Frontend for the game interface.
- `resources/views/admin/words.blade.php`: Admin panel for word management.
- `database/migrations/`: Migrations for `words` and `leaderboards` tables.
- `database/seeders/WordSeeder.php`: Seeds initial words into the database.

## Database Schema
- **words**:
  - `id`: Primary key
  - `word`: Unique string (e.g., "apple")
  - `created_at`, `updated_at`: Timestamps
- **leaderboards**:
  - `id`: Primary key
  - `player_name`: String (e.g., "John")
  - `score`: Integer (e.g., 50)
  - `accuracy`: Float (e.g., 90.00)
  - `wpm`: Float (e.g., 30.00)
  - `created_at`, `updated_at`: Timestamps

## Scoring Logic
- **Score**: 10 points per correct word.
- **Accuracy**: `(correct words / total words typed) * 100`.
- **WPM**: `(correct words / 60 seconds) * 60`.

## Troubleshooting
- **Leaderboard not updating**:
  - Check the browser's Console (F12) for JavaScript errors.
  - Verify the `/leaderboard` endpoint returns JSON data in the Network tab.
  - Ensure the CSRF token is included in POST requests (`<meta name="csrf-token" content="{{ csrf_token() }}">` in `game.blade.php`).
- **No words displayed**:
  - Run `php artisan migrate --seed` to populate the `words` table.
  - Check the `/words` endpoint in the Network tab.
- **Database errors**:
  - Verify `.env` database settings.
  - Check `storage/logs/laravel.log` for detailed errors.

## Future Improvements
- Add user authentication for secure admin access.
- Implement difficulty levels (e.g., easy, medium, hard word lists).
- Add real-time multiplayer mode.
- Enhance UI with animations and sound effects.
- Add API endpoints for mobile app integration.

## Contributing
1. Fork the repository.
2. Create a feature branch (`git checkout -b feature-name`).
3. Commit changes (`git commit -m "Add feature"`).
4. Push to the branch (`git push origin feature-name`).
5. Open a pull request.

## License
This project is licensed under the MIT License.

## Contact
For issues or suggestions, open an issue on the repository or contact the maintainer.