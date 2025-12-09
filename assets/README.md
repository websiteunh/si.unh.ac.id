# Assets Directory Structure

This directory contains all static assets for the application.

## Directory Structure

```
assets/
├── vendor/          # Third-party libraries (managed via npm)
├── css/            # Custom CSS files
├── js/             # Custom JavaScript files
├── images/         # Static images (logos, icons, etc.)
├── fonts/          # Web fonts
├── uploads/        # User-uploaded files
│   ├── artikel/    # Article images
│   ├── images/     # General images (user photos, settings, etc.)
│   └── dokumen/    # Document files (PDFs, etc.)
└── scss/           # SCSS source files (for compilation)
```

## Frontend Dependencies Management

Frontend libraries are now managed via **npm** instead of manually copying files.

### Setup

1. Install Node.js and npm
2. Run `npm install` in project root
3. Assets will be automatically copied to `assets/vendor/` via postinstall script

### Adding New Frontend Libraries

1. Install via npm: `npm install <package-name>`
2. Add mapping in `scripts/copy-assets.js` if needed
3. Run `npm run copy-assets` to copy to assets/vendor

### Current Frontend Dependencies

Managed via `package.json`:
- Bootstrap 4.6.2
- jQuery 3.6.4
- DataTables
- Select2
- SweetAlert2
- Chart.js
- Summernote
- Moment.js
- FullCalendar
- AOS (Animate On Scroll)
- GLightbox
- Swiper
- Bootstrap Icons

## Backward Compatibility

Symlinks are created for backward compatibility:
- `art1kel/` → `uploads/artikel/`
- `im493/` → `uploads/images/`
- `dokum3nt/` → `uploads/dokumen/`

## Migration Notes

Old paths in code should be updated to new paths:
- `assets/art1kel/` → `assets/uploads/artikel/`
- `assets/im493/` → `assets/uploads/images/`
- `assets/dokum3nt/` → `assets/uploads/dokumen/`

Symlinks ensure old code continues to work, but new code should use the new paths.

## PHP vs Frontend Dependencies

- **PHP dependencies**: Managed via `composer.json` → stored in `vendor/` (root)
- **Frontend dependencies**: Managed via `package.json` → copied to `assets/vendor/`

These are separate because:
- PHP packages are for server-side code
- Frontend packages are for browser/client-side code
- They serve different purposes and cannot be merged
