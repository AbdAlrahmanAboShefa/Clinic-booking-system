# Clinic Booking System - Agent Documentation

## Project Overview
A Laravel-based clinic appointment booking system with role-based access control, appointment management, and scheduling features.

## Tech Stack
- **Framework**: Laravel 10+
- **Auth**: Laravel Breeze (Jetstream compatible)
- **Roles/Permissions**: Spatie Laravel Permission
- **Activity Logging**: Spatie Activitylog
- **Database**: MySQL/SQLite

## User Roles & Permissions

### Roles
| Role | Description |
|------|-------------|
| `admin` | Full system access |
| `doctor` | Manages own appointments and schedules |
| `staff` | Handles patients and appointments |
| `patient` | Books and manages own appointments |

### Permissions
```
dashboard.view
patients.view, patients.create, patients.edit, patients.delete
doctors.view, doctors.create, doctors.edit, doctors.delete
appointments.view, appointments.create, appointments.edit, appointments.cancel
schedules.manage
reports.view
settings.manage
```

## Models

### User
- `id`, `name`, `email`, `password`, `phone`, `profile_photo`
- Relationships: `hasOne(Doctor)`, `hasOne(Patient)`
- Traits: `HasRoles`, `LogsActivity`, `Notifiable`

### Patient
- `id`, `user_id`, `patient_code` (auto: PT-XXXXXX)
- `first_name`, `last_name`, `date_of_birth`, `gender`
- `phone`, `email`, `address`
- `emergency_contact_name`, `emergency_contact_phone`
- `blood_type`, `allergies` (array), `medical_notes`
- Relationships: `belongsTo(User)`, `hasMany(Appointment)`

### Doctor
- `id`, `user_id`, `specialization_id`
- `qualification`, `license_number`, `bio`
- `is_available` (boolean)
- Relationships: `belongsTo(User)`, `belongsTo(Specialization)`, `hasMany(DoctorSchedule)`, `hasMany(Appointment)`
- Traits: `LogsActivity`

### DoctorSchedule
- `id`, `doctor_id`, `day_of_week` (0-6)
- `start_time`, `end_time`, `break_start`, `break_end`
- `is_active` (boolean)

### Appointment
- `id`, `patient_id`, `doctor_id`
- `appointment_date`, `start_time`, `end_time`
- `status`: pending, confirmed, completed, cancelled, no_show
- `type`: consultation, followup, procedure
- `notes`, `cancellation_reason`, `cancelled_by`, `cancelled_at`
- Relationships: `belongsTo(Patient)`, `belongsTo(Doctor)`, `belongsToMany(Service)`

### Service
- `id`, `name`, `description`, `duration_minutes`, `price`, `is_active`

### Specialization
- `id`, `name`, `description`, `is_active`

## Controllers & Features

### AppointmentController (`/appointments`)
| Method | Route | Description |
|--------|-------|-------------|
| `index` | GET /appointments | List appointments (filtered by role) |
| `create` | GET /appointments/create | Show create form |
| `store` | POST /appointments | Create appointment with conflict detection |
| `show` | GET /appointments/{id} | View appointment details |
| `edit` | GET /appointments/{id}/edit | Edit appointment |
| `update` | PUT /appointments/{id} | Update appointment |
| `destroy` | DELETE /appointments/{id} | Delete appointment |
| `cancel` | POST /appointments/{id}/cancel | Cancel appointment |
| `confirm` | POST /appointments/{id}/confirm | Doctor confirms pending appointment |
| `reject` | POST /appointments/{id}/reject | Doctor rejects pending appointment |
| `getAvailableSlots` | GET /appointments/available-slots | AJAX - Get available time slots |

### DoctorController (`/doctors`)
| Method | Route | Description |
|--------|-------|-------------|
| `index` | GET /doctors | List doctors (filter by specialization/availability) |
| `create` | GET /doctors/create | Create doctor form |
| `store` | POST /doctors | Create doctor (assigns 'doctor' role) |
| `show` | GET /doctors/{id} | View doctor with appointments |
| `edit` | GET /doctors/{id}/edit | Edit doctor |
| `update` | PUT /doctors/{id} | Update doctor |
| `destroy` | DELETE /doctors/{id} | Delete doctor (prevents if has pending appointments) |

### PatientController (`/patients`)
| Method | Route | Description |
|--------|-------|-------------|
| `index` | GET /patients | List patients (search by name/code/phone) |
| `create` | GET /patients/create | Create patient (admin/staff) |
| `store` | POST /patients | Store patient |
| `show` | GET /patients/{id} | View patient details |
| `edit` | GET /patients/{id}/edit | Edit patient |
| `update` | PUT /patients/{id} | Update patient |
| `destroy` | DELETE /patients/{id} | Delete patient |
| `createProfile` | GET /patient/profile/create | Patient creates own profile |
| `storeProfile` | POST /patient/profile | Store patient profile |
| `editProfile` | GET /patient/profile/edit | Patient edits own profile |
| `updateProfile` | PATCH /patient/profile | Update patient profile |

### ScheduleController (`/schedules`)
| Method | Route | Description |
|--------|-------|-------------|
| `index` | GET /schedules | List doctor schedules |
| `create` | GET /schedules/create | Create schedule form |
| `store` | POST /schedules | Create schedule |
| `edit` | GET /schedules/{id}/edit | Edit schedule |
| `update` | PUT /schedules/{id} | Update schedule |
| `destroy` | DELETE /schedules/{id} | Delete schedule |

### PermissionController (`/admin/permissions`)
| Method | Route | Description |
|--------|-------|-------------|
| `index` | GET /admin/permissions | View all roles/permissions |
| `assignRoleToUserPage` | GET /admin/permissions/users | User role assignment page |
| `assignRoleToUser` | POST | Assign role to user |
| `removeRoleFromUser` | POST | Remove role from user |
| `syncRolesToUser` | PATCH | Sync user roles |
| `manageUserRoles` | GET | Manage user roles page |
| `manageRolePermissions` | GET /admin/permissions/role/{id}/edit | Manage role permissions |
| `givePermissionToRole` | POST | Give permission to role |
| `revokePermissionFromRole` | POST | Revoke permission from role |
| `syncPermissionsToRole` | PATCH | Sync role permissions |

### ActivityLogController (`/admin/activity-log`)
| Method | Route | Description |
|--------|-------|-------------|
| `index` | GET /admin/activity-log | List activities (filter by log_name, causer, date) |
| `show` | GET /admin/activity-log/{id} | View activity details |

## Policies

### AppointmentPolicy
- `viewAny`: admin, staff
- `view`: admin, staff, doctor (own), patient (own)
- `create`: admin, staff, patient
- `update`: admin, staff, doctor (own)
- `delete`: admin, staff
- `cancel`: admin, staff, doctor (own), patient (own)
- `confirm`: admin, staff, doctor (own, pending only)
- `reject`: admin, staff, doctor (own, pending only)

### DoctorPolicy
- `viewAny`: admin, staff, doctor
- `view`: admin, staff, doctor (own)
- `create`: admin
- `update`: admin
- `delete`: admin (prevents if has pending appointments)

### PatientPolicy
- `viewAny`: admin, staff, doctor
- `view`: admin, staff, doctor, patient (own)
- `create`: admin, staff
- `update`: admin, staff, patient (own profile)
- `delete`: admin, staff

### DoctorSchedulePolicy
- `viewAny`: admin, staff, doctor (own)
- `view`: admin, staff, doctor (own)
- `create`: admin, doctor (own)
- `update`: admin, doctor (own)
- `delete`: admin, doctor (own)

## Notifications

### NewAppointmentForDoctor
Sent via email when a patient books an appointment.

### AppointmentConfirmedForPatient
Sent via email when a doctor confirms a pending appointment.

### AppointmentCancelledNotification
Sent via email when an appointment is cancelled (by doctor or patient).

### AppointmentReminderNotification
Sent via email 2 hours before confirmed appointments. Runs via scheduler every minute.

## Key Features

### 1. Appointment Booking
- Patient selects doctor, date, and time slot
- Available slots calculated based on doctor schedule and existing appointments
- Conflict detection prevents double-booking
- Break times respected in slot calculation
- New appointments start as "pending"

### 2. Doctor Appointment Management
- Doctors can confirm or reject pending appointments
- Only available to the doctor assigned to the appointment
- Only pending appointments can be confirmed/rejected
- Rejection requires cancellation reason

### 3. Doctor Schedules
- Doctors have weekly availability schedules
- Each day can have different hours
- Break times can be specified
- Schedules determine available booking slots

### 4. Role-Based Access
- Admin: Full system access
- Staff: Patient and appointment management
- Doctor: Own appointments and schedules
- Patient: Own profile and appointments

### 5. Activity Logging
- All model changes are logged
- Filterable by log name, user, date range
- Admin can view all system activities

### 6. Permission Management
- Admin can assign roles to users
- Admin can manage role permissions
- Permissions control UI visibility and access

## Commands

```bash
# Run seeder
php artisan db:seed

# Create admin user
php artisan make:admin

# Clear permissions cache
php artisan permission:cache:clear

# Send appointment reminders (manual)
php artisan app:send-appointment-reminders
```

## Views Structure
```
resources/views/
├── appointments/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── show.blade.php
├── doctors/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── patients/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit-profile.blade.php
├── schedules/
│   ├── index.blade.php
│   └── create.blade.php
├── admin/
│   ├── permissions/
│   └── activity-log/
├── layouts/
├── components/
├── auth/
└── profile/
```

## Configuration
- Appointment duration: `config/clinic.appointment_duration` (default: 30 min)
- Default start time: `config/clinic.default_start_time` (default: 09:00)
- Default end time: `config/clinic.default_end_time` (default: 17:00)
