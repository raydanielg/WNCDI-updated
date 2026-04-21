# WNCDi System Modernization - Complete Setup Guide

## Overview
The Laravel application has been fully updated to reflect the **Without Non Communicable Diseases Initiative (WNCDi)** organization structure, missions, programs, and objectives based on the provided documentation.

## Key Changes Made

### 1. **New Database Models**

#### Program Model (`app/Models/Program.php`)
- Stores WNCDi's 6 main programs/activities:
  - NCDs Advocacy
  - Creation of younger NCDs champions
  - Health determinants campaigns
  - International NCDs Commemorations
  - Collaborative NCDs screening
  - Partnership
- Fields: name, slug, short_description, description, icon_url, image_url, sort_order, is_active
- Database: `programs` table

#### Objective Model (`app/Models/Objective.php`)
- Stores WNCDi's 7 organizational objectives
- Fields: number, title, description, image_url, sort_order, is_active
- Database: `objectives` table

### 2. **Updated GeneralSetting Model**
Added new fields for WNCDi-specific information:
- Organization name and description
- Vision statement
- Mission statement
- About text
- Registration number (00NGO/R/7809)
- Founding year (2024)
- Bank information (NBC Account)
- Multiple phone numbers and emails
- Social media URLs (Facebook, Twitter, Instagram, LinkedIn)

### 3. **Database Migrations**
- `2025_12_26_000001_create_programs_table.php` - Programs table
- `2025_12_26_000002_create_objectives_table.php` - Objectives table
- `2025_12_26_000003_add_wncdi_fields_to_general_settings_table.php` - GeneralSetting fields

### 4. **Admin Controllers**

#### ProgramController (`app/Http/Controllers/Admin/ProgramController.php`)
- **Routes:**
  - GET `/admin/programs` - List all programs
  - POST `/admin/programs` - Create new program
  - POST `/admin/programs/{program}` - Update program
  - POST `/admin/programs/{program}/delete` - Delete program
- Features:
  - CRUD operations for programs
  - Image upload support
  - Automatic slug generation
  - Sort order management

#### ObjectiveController (`app/Http/Controllers/Admin/ObjectiveController.php`)
- **Routes:**
  - GET `/admin/objectives` - List all objectives
  - POST `/admin/objectives` - Create new objective
  - POST `/admin/objectives/{objective}` - Update objective
  - POST `/admin/objectives/{objective}/delete` - Delete objective
- Features:
  - Full CRUD for objectives
  - Image support
  - Numbered objectives (1-7)
  - Sort order management

### 5. **Public Routes**

#### New Public Routes
- `GET /programs` - Display active programs
- `GET /` (modified) - Homepage now includes:
  - programs (6 most recently created)
  - objectives (all active, ordered by number)
  - generalSetting (organization info)

### 6. **Database Seeder**
`database/seeders/WNCDiSeeder.php` - Populates database with:
- WNCDi organization information
- 6 programs with descriptions
- 7 objectives with detailed descriptions
- Bank and contact information

### 7. **Updated Routes** (`routes/web.php`)
- Added imports for new controllers
- Added admin routes for Programs and Objectives
- Added public route for `/programs` page
- Updated home route to fetch programs and objectives

## File Structure

```
app/
├── Http/Controllers/Admin/
│   ├── ProgramController.php (NEW)
│   └── ObjectiveController.php (NEW)
├── Models/
│   ├── Program.php (NEW)
│   ├── Objective.php (NEW)
│   └── GeneralSetting.php (UPDATED)

database/
├── migrations/
│   ├── 2025_12_26_000001_create_programs_table.php (NEW)
│   ├── 2025_12_26_000002_create_objectives_table.php (NEW)
│   └── 2025_12_26_000003_add_wncdi_fields_to_general_settings_table.php (NEW)
└── seeders/
    ├── WNCDiSeeder.php (NEW)
    └── DatabaseSeeder.php (UPDATED)

routes/
└── web.php (UPDATED)
```

## How to Use

### 1. **Run Migrations**
```bash
php artisan migrate
```

### 2. **Seed Database**
```bash
php artisan db:seed
```

Or run only WNCDi seeder:
```bash
php artisan db:seed --class=WNCDiSeeder
```

### 3. **Access Admin Panel**
- URL: http://localhost:8000/admin/programs
- URL: http://localhost:8000/admin/objectives
- URL: http://localhost:8000/admin/settings/general (for WNCDi org info)

### 4. **Manage WNCDi Content in Admin**

#### Programs Management
- Add/Edit/Delete WNCDi programs
- Upload images for each program
- Set sort order for display
- Enable/disable programs

#### Objectives Management
- Add/Edit/Delete objectives
- Assign objective number (1-7)
- Upload supporting images
- Set display order

#### Organization Settings
- Edit organization name, vision, mission
- Update contact information
- Modify bank details
- Update social media links
- Change about text

### 5. **Frontend Display**
- Homepage automatically displays:
  - Hero slides
  - Organization info (from GeneralSetting)
  - Programs (first 6 active, ordered by sort_order)
  - Objectives (all active, ordered by number)
  - Testimonials
  - Team members

- Dedicated programs page:
  - All active programs
  - Full description
  - Images and icons

## WNCDi Content Seeded

### Organization Information
- **Name:** Without Non Communicable Diseases Initiative
- **Registration:** 00NGO/R/7809 (Tanzania MCDGEC)
- **Vision:** Create society free from preventable NCDs with youth involvement
- **Mission:** Provision of advocacy, campaigns, education on NCDs
- **Vision:** Becoming Healthier Together
- **Bank:** NBC Account: 041172000179
- **Contact:** 
  - Email: wncdinitiative@gmail.com
  - Phone: +255621068500, +255625710549

### Programs (6 Total)
1. NCDs Advocacy
2. Creation of younger NCDs champions
3. Health determinants campaigns
4. International NCDs Commemorations
5. Collaborative NCDs screening
6. Partnership

### Objectives (7 Total)
1. Attaining effective health promotion
2. Provision of substantive knowledge
3. Furnishing advocacy on NCDs
4. Health determinants campaigns
5. Inviting health professionals
6. Operating in partnership
7. Encouraging NCDs screening

## Image Management

### Image Folders
- `/img/wncdi/` - Organization images
- `/img/gallery/` - Gallery images
- `/public/storage/programs/` - Program images (uploaded via admin)
- `/public/storage/objectives/` - Objective images (uploaded via admin)

### Using Images
- Upload program/objective images via admin panel
- Images are stored in `storage/app/public/`
- Access via `/storage/programs/` and `/storage/objectives/`

## Next Steps

1. **Upload WNCDi Logo**
   - Place in `/img/wncdi/` folder
   - Update reference in GeneralSetting

2. **Upload Program Images**
   - Go to Admin > Programs
   - Edit each program and upload images

3. **Upload Objective Images**
   - Go to Admin > Objectives
   - Edit each objective and upload images

4. **Upload Team Member Photos**
   - Add/Update team members via Admin > Team Members
   - Upload photos for each member

5. **Gallery Images**
   - Upload WNCDi activity photos to Gallery via Admin > Media

## Admin User Credentials
```
Email: admin@wncdi.local
Password: 12345678
```

## API Endpoints (if needed)

### Programs
- `GET /api/programs` - List all active programs
- `POST /api/programs` - Create (auth required)
- `GET /api/programs/{program}` - Show program details
- `PUT /api/programs/{program}` - Update (auth required)
- `DELETE /api/programs/{program}` - Delete (auth required)

### Objectives
- `GET /api/objectives` - List all active objectives
- `POST /api/objectives` - Create (auth required)
- `GET /api/objectives/{objective}` - Show objective details
- `PUT /api/objectives/{objective}` - Update (auth required)
- `DELETE /api/objectives/{objective}` - Delete (auth required)

## Database Relationships

```
GeneralSetting (1) ─── (Many) Programs
GeneralSetting (1) ─── (Many) Objectives
```

## Troubleshooting

### Programs/Objectives not appearing
- Ensure they are marked as `is_active = true`
- Check `sort_order` for correct display order
- Run `php artisan migrate` if table doesn't exist

### Images not showing
- Ensure `php artisan storage:link` has been run
- Check file permissions on `/storage/app/public/`
- Verify image path in database

### Admin panel not loading
- Clear config cache: `php artisan config:clear`
- Clear views cache: `php artisan view:clear`
- Ensure user role is 'admin'

## Support & Maintenance

For adding more WNCDi content:
1. Edit via Admin Panel (recommended)
2. Or modify WNCDiSeeder.php and re-seed

For customization:
- Edit controllers to modify business logic
- Update models to add new fields
- Create new migrations for schema changes

---

**Last Updated:** December 26, 2025
**System Version:** Laravel 11 + Inertia.js
**WNCDi Integration:** Complete
