#!/usr/bin/env python3
from PIL import Image
import os

logo_files = [
    r"c:\Users\nafid\wncdi's\public\img\WNCDiLogo.png",
    r"c:\Users\nafid\wncdi's\public\img\wncdi\logo.png",
    r"c:\Users\nafid\wncdi's\public\img\wncdi\WNCDi.png"
]

for logo_path in logo_files:
    if os.path.exists(logo_path):
        try:
            # Open the image
            img = Image.open(logo_path)
            
            # Convert to RGBA if not already
            if img.mode != 'RGBA':
                img = img.convert('RGBA')
            
            # Get the image data
            data = img.getdata()
            
            # Convert white and near-white pixels to transparent
            new_data = []
            for item in data:
                if len(item) == 4:  # RGBA
                    r, g, b, a = item
                    # If pixel is white or near-white, make it transparent
                    if r > 240 and g > 240 and b > 240:
                        new_data.append((255, 255, 255, 0))  # Transparent
                    else:
                        new_data.append(item)
                elif len(item) == 3:  # RGB
                    r, g, b = item
                    if r > 240 and g > 240 and b > 240:
                        new_data.append((255, 255, 255, 0))  # Transparent
                    else:
                        new_data.append((item[0], item[1], item[2], 255))
            
            img.putdata(new_data)
            
            # Save the image
            img.save(logo_path)
            print(f"✓ Processed: {os.path.basename(logo_path)}")
        except Exception as e:
            print(f"✗ Error processing {logo_path}: {str(e)}")
    else:
        print(f"✗ File not found: {logo_path}")

print("\nComplete! All logos are now transparent.")
