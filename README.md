# 🏥 Clinic Booking System

A full-featured clinic management and appointment booking platform built with **Laravel 11**, designed for doctors, patients, and administrators.

---

## ✨ Features

### 👤 Roles & Permissions
- **Admin** — Full control over doctors, patients, appointments, and settings
- **Doctor** — Manage schedule, view appointments, update availability
- **Patient** — Book appointments, view history, receive reminders

### 📅 Appointment Management
- Book, confirm, cancel, and reschedule appointments
- Doctor availability and time slot management
- Appointment status tracking (pending / confirmed / cancelled / completed)

### 🔔 Notifications
- Email notifications for appointment confirmation and cancellation
- Automated **2-hour reminder** emails via Laravel Task Scheduling
- Notifications sent to both doctor and patient

### 📋 Activity Log
- Full audit trail of user actions across the system

### 🛡️ Security
- Role-based access control (RBAC) with Laravel middleware
- Form validation and CSRF protection
- Authentication via Laravel Breeze

---

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 12 |
| Database | MySQL |
| Frontend | Blade + Tailwind CSS |
| Auth | Laravel Breeze |
| Scheduling | Laravel Task Scheduler |
| Queue | Laravel Queue (Database driver) |
| Notifications | Laravel Notifications (Mail) |
| ORM | Eloquent |

---

## ⚙️ Installation

```bash
# 1. Clone the repository
git clone https://github.com/AbdAlrahmanAboShefa/Clinic-booking-system.git
cd Clinic-booking-system

# 2. Install dependencies
composer install
npm install && npm run build

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Configure database in .env then run migrations
php artisan migrate --seed

# 5. Start the development server
php artisan serve
```

---

## 📧 Mail Configuration

Update your `.env` with your mail provider credentials:

```env
MAIL_MAILER=smtp
MAIL_HOST=your-mail-host
MAIL_PORT=587
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_FROM_ADDRESS=noreply@yourclinic.com
MAIL_FROM_NAME="Clinic Booking System"
```

---

## ⏰ Task Scheduling

The system sends automated appointment reminders 2 hours before each appointment.

To enable scheduling, add this to your server's cron:

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

For local development:

```bash
php artisan schedule:work
```

Run the queue worker to process notifications:

```bash
php artisan queue:work
```

---

## 👥 Default Roles

After seeding, the following roles are available:
- `admin`
- `doctor`
- `patient`

---

## 📁 Project Structure

```
app/
├── Console/Commands/        # Scheduled commands (e.g. SendAppointmentReminders)
├── Http/Controllers/        # Controllers for each role
├── Models/                  # Eloquent models
├── Notifications/           # Mail notifications
├── Policies/                # Authorization policies
resources/
├── views/                   # Blade templates
database/
├── migrations/              # Database schema
├── seeders/                 # Sample data
```

---

## 🚀 Upcoming Features

- [ ] Online payment integration
- [ ] Doctor ratings and reviews
- [ ] Patient medical history
- [ ] SMS notifications
- [ ] REST API for mobile app

---

## 📄 License

This project is open-sourced under the [MIT license](LICENSE).

---

## 🙋‍♂️ Author

**Abd Alrahman Abo Shefa**
- GitHub: [@AbdAlrahmanAboShefa](https://github.com/AbdAlrahmanAboShefa)