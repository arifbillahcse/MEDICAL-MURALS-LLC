# Images Directory

This directory contains all local image assets for the Medical Murals website.

## Folder Structure

- **hero/** - Hero section background images and graphics
- **portfolio/** - Portfolio project images and thumbnails
- **products/** - Product showcase images (murals, domes, panels, etc.)
- **gallery/** - Gallery and slider images
- **icons/** - Icon assets and SVG graphics

## Usage

Replace external URLs (Unsplash, etc.) with local images from these folders as needed.

Example:
```html
<!-- Before: Using external URL -->
<img src="https://images.unsplash.com/..." alt="...">

<!-- After: Using local image -->
<img src="images/portfolio/project-1.jpg" alt="...">
```

## Image Optimization

When adding images:
1. Optimize for web (compress without losing quality)
2. Use appropriate format (JPG for photos, PNG for graphics with transparency)
3. Name files descriptively and in lowercase with hyphens
4. Keep file sizes reasonable (aim for < 200KB per image)
