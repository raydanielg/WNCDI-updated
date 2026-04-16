# WNCDi System Implementation Checklist

## Pre-Flight Checks
- [ ] Review `WNCDI_SETUP.md` for complete overview
- [ ] Backup current database (if applicable)
- [ ] Ensure .env file is configured with database credentials

## Database Setup
- [ ] Run: `php artisan migrate` (creates new tables)
- [ ] Run: `php artisan db:seed` (seeds WNCDi content)
- [ ] Verify tables created:
  - `programs` table exists
  - `objectives` table exists
  - `general_settings` table has new fields

## Storage & Assets Setup
- [ ] Run: `php artisan storage:link` (link public storage)
- [ ] Check `/public/storage` directory exists
- [ ] Upload WNCDi logo to `/img/wncdi/`
- [ ] Place program images in `/img/wncdi/programs/`
- [ ] Place objective images in `/img/wncdi/objectives/`

## Admin Panel Verification
- [ ] Login to admin panel with: admin@tanford.net / 12345678
- [ ] Go to `/admin/programs` - should list 6 programs
- [ ] Go to `/admin/objectives` - should list 7 objectives  
- [ ] Go to `/admin/settings/general` - check new WNCDi fields populated

## Frontend Testing
- [ ] Visit homepage `/` - should show programs and objectives
- [ ] Visit `/programs` - should display all programs
- [ ] Check program images display correctly
- [ ] Verify organization info displays on home page

## Next Steps
- [ ] Upload program images via admin panel
- [ ] Upload objective images via admin panel
- [ ] Update team members with WNCDi team info
- [ ] Add WNCDi news/blog posts
- [ ] Upload gallery images
- [ ] Customize homepage layout if needed

## Admin Content Management

### Managing Programs
1. Go to `/admin/programs`
2. Click "Add Program" to create new
3. Fill in:
   - Name (auto-generates slug)
   - Short description
   - Full description
   - Icon URL (optional)
   - Upload image
   - Set sort order
   - Enable/disable
4. Save or delete

### Managing Objectives
1. Go to `/admin/objectives`
2. Click "Add Objective" to create new
3. Fill in:
   - Objective number (1-7)
   - Title
   - Description
   - Upload image (optional)
   - Set sort order
   - Enable/disable
4. Save or delete

### Updating Organization Info
1. Go to `/admin/settings/general`
2. Update:
   - Organization name
   - Vision statement
   - Mission statement
   - Bank information
   - Contact details
   - Social media links
   - About text
3. Save changes

## Troubleshooting

### Images Not Showing
- Run: `php artisan storage:link`
- Check file permissions: `chmod 755 storage/app/public`
- Clear cache: `php artisan config:clear`

### Database Errors
- Check database connection in .env
- Run migrations in correct order
- Reset database if needed: `php artisan migrate:fresh --seed`

### Admin Pages Blank
- Clear view cache: `php artisan view:clear`
- Clear config cache: `php artisan config:clear`
- Restart PHP development server

## File Locations Reference

### New Files Created
- `app/Models/Program.php`
- `app/Models/Objective.php`
- `app/Http/Controllers/Admin/ProgramController.php`
- `app/Http/Controllers/Admin/ObjectiveController.php`
- `database/seeders/WNCDiSeeder.php`
- `database/migrations/2025_12_26_000001_create_programs_table.php`
- `database/migrations/2025_12_26_000002_create_objectives_table.php`
- `database/migrations/2025_12_26_000003_add_wncdi_fields_to_general_settings_table.php`

### Updated Files
- `routes/web.php` - Added routes for programs and objectives
- `config/app.php` - Changed app name to 'WNCDi'
- `database/seeders/DatabaseSeeder.php` - Added WNCDiSeeder call

### Configuration Files
- `.env` - May need APP_NAME update
- `config/app.php` - Application name set to 'WNCDi'

## Quick Commands

```bash
# Run migrations
php artisan migrate

# Run all seeders
php artisan db:seed

# Run only WNCDi seeder
php artisan db:seed --class=WNCDiSeeder

# Link storage for images
php artisan storage:link

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Reset everything (WARNING: deletes data)
php artisan migrate:fresh --seed

# Development server
php artisan serve

# Build assets (if using Vite)
npm run build
npm run dev
```

## Support Documentation
- See `WNCDI_SETUP.md` for complete technical documentation
- Check Controllers for API endpoint patterns
- Review Models for database relationships

---

**Status:** Ready for Deployment
**Last Updated:** December 26, 2025
**System:** Laravel 11 + Inertia.js
