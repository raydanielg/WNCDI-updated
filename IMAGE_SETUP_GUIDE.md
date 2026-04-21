# Image Support & Troubleshooting Guide

## ✅ What Was Fixed

### 1. **Expanded Image Format Support**
All controllers now support these image formats:
- ✅ JPEG/JPG
- ✅ PNG
- ✅ WebP (modern format, smaller file size)
- ✅ SVG (vector format)
- ✅ GIF (animations supported)
- ✅ BMP
- ✅ TIFF/TIFF-X
- ✅ HEIC (iPhone images)

### 2. **Increased File Size Limits**
- **Standard images**: 10 MB (was 4 MB)
- **Hero/Banner images**: 15 MB (was 4 MB)
- **Audio files**: 20 MB
- **Video files**: 51 MB

### 3. **Extended Audio/Video Support**
- **Audio**: MP3, WAV, OGG, WebM
- **Video**: MP4, WebM, OGG, MOV (QuickTime)

### 4. **Updated Controllers**
The following controllers were updated with expanded format support:
- ✅ PostController (blog posts & media)
- ✅ ServiceController
- ✅ TestimonialController
- ✅ TeamMemberController
- ✅ HeroController (hero slides/banners)
- ✅ ProgramController
- ✅ ObjectiveController
- ✅ FocusAreaController
- ✅ AboutBlockController
- ✅ MediaItemController

---

## 🚀 How to Deploy Changes

### Step 1: Clear Application Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan optimize:clear
```

### Step 2: Rebuild Frontend Assets
```bash
npm run build
```

### Step 3: Verify Storage Link
```bash
php artisan storage:link
```

---

## 📂 Image Storage Structure

### Where Images Are Stored
```
storage/app/public/
├── posts/              # Blog post images
├── programs/           # Program images
├── objectives/         # Objective images
├── services/           # Service images
├── testimonials/       # Testimonial avatars
├── team/               # Team member photos
├── about/              # About section images
├── hero/               # Hero/banner slides
├── focus-areas/        # Focus area images
├── media/              # General media files
└── ...
```

### How to Access Images
All images are accessible via the `/storage/` URL:
- `/storage/posts/image.jpg`
- `/storage/programs/image.png`
- `/storage/team/photo.webp`

---

## 🔧 Image Upload Guidelines

### Recommended Image Sizes
- **Hero/Banner images**: 1920x600px (16:9 ratio)
- **Program/Service images**: 600x400px
- **Team photos**: 400x400px (square)
- **Testimonial avatars**: 200x200px
- **Blog featured images**: 800x450px (16:9)

### Recommended Formats
- **Web photos**: WebP (best compression) or PNG
- **Illustrations**: SVG (scalable) or PNG
- **Complex photos**: JPEG (good compression)
- **Animations**: GIF or WebM

### Max File Sizes
- Standard images: 10 MB
- Hero images: 15 MB  
- Video files: 51 MB
- Audio files: 20 MB

---

## ✅ Verification Checklist

### 1. **Check Storage Link**
Open browser and navigate to:
```
http://your-site/storage/
```
You should see a directory listing or an error - either way shows the link works.

### 2. **Verify Image Display**
1. Upload an image through admin panel
2. Check the database to see the image URL
3. Open that URL directly in browser (e.g., `http://your-site/storage/posts/test.jpg`)
4. Image should display

### 3. **Check File Permissions**
```bash
# Windows (should return True if accessible)
Test-Path "C:\Users\nafid\WNCDI-updated\storage\app\public"

# Verify symlink
Get-Item -Path "C:\Users\nafid\WNCDI-updated\public\storage" | Select-Object LinkType, Target
```

### 4. **Test Image Upload**
1. Go to admin panel
2. Upload an image in your preferred format (try WebP)
3. Save
4. Verify image appears on frontend

---

## 🐛 Troubleshooting

### Problem: Images Still Not Loading

**Solution 1: Clear All Caches**
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:cache
php artisan optimize:clear
```

**Solution 2: Rebuild Assets**
```bash
npm run build
```

**Solution 3: Verify Storage Link**
```bash
# Recreate the symlink
php artisan storage:link
```

### Problem: Upload Fails with "Invalid File Type"

**Cause**: Browser not recognizing file MIME type
**Solution**: 
1. Try a different image format (JPEG instead of PNG)
2. Check file extension matches format
3. Use online tool to verify file is not corrupted

### Problem: Images Load but Look Blurry/Pixelated

**Solution**: Use higher resolution images
- Desktop: At least 1200px wide
- Mobile: At least 600px wide
- Hero images: 1920x600px minimum

### Problem: WebP Images Not Displaying

**Cause**: Browser doesn't support WebP
**Solution**: 
1. Provide JPEG/PNG fallback
2. Check browser compatibility (modern browsers support it)
3. Use PNG for older browser support

---

## 📊 Supported MIME Types by Controller

### All Controllers Support
```
image/jpeg              - JPEG/JPG files
image/png               - PNG files
image/webp              - WebP files (modern)
image/svg+xml           - SVG vector files
image/gif               - GIF files
image/bmp               - Bitmap files
image/tiff              - TIFF files
image/x-tiff            - TIFF variant
image/heic              - iPhone HEIC format
```

### Audio (PostController only)
```
audio/mpeg              - MP3 files
audio/mp3               - MP3 files
audio/wav               - WAV files
audio/ogg               - OGG files
audio/webm              - WebM audio
```

### Video (PostController only)
```
video/mp4               - MP4 video
video/webm              - WebM video
video/ogg               - OGG video
video/quicktime         - MOV files
```

---

## 💾 Database Image URLs

Image URLs are stored in database tables with format:
```
/storage/{subdirectory}/{filename.ext}

Examples:
- /storage/posts/my-blog-image.jpg
- /storage/programs/program-icon.webp
- /storage/team/john-smith.png
```

Always use relative paths starting with `/storage/` for cross-environment compatibility.

---

## 🎯 Next Steps

1. **Clear caches**: Run the cache-clearing commands above
2. **Rebuild frontend**: Run `npm run build`
3. **Verify storage link**: Visit `/storage/` in browser
4. **Test upload**: Upload an image and verify it displays
5. **Try different formats**: Test WebP, PNG, JPEG to find optimal quality/size

---

## 📞 Still Having Issues?

**Check the following:**
1. ✅ Public/storage is a valid symlink to storage/app/public
2. ✅ storage/app/public directory has write permissions
3. ✅ Cache has been cleared
4. ✅ Frontend assets rebuilt with `npm run build`
5. ✅ File format is supported (see list above)
6. ✅ File size is within limits
7. ✅ Image is not corrupted (try opening in image editor)
