#!/usr/bin/env python3
import os

# Color mapping from old to new refined palette
color_mapping = {
    # Pink to Rose
    'wncdi-pink': 'wncdi-accent',
    
    # Yellow to Gold
    'wncdi-yellow': 'wncdi-gold',
}

# Find all Vue files
vue_dir = r"c:\Users\nafid\wncdi's\resources\js"
updated_count = 0

for root, dirs, files in os.walk(vue_dir):
    for file in files:
        if file.endswith('.vue'):
            filepath = os.path.join(root, file)
            
            with open(filepath, 'r', encoding='utf-8') as f:
                content = f.read()
            
            updated_content = content
            replacements_made = 0
            
            # Replace each color mapping
            for old_color, new_color in color_mapping.items():
                old_count = updated_content.count(old_color)
                if old_count > 0:
                    updated_content = updated_content.replace(old_color, new_color)
                    replacements_made += old_count
            
            # Write back if changes were made
            if replacements_made > 0:
                with open(filepath, 'w', encoding='utf-8') as f:
                    f.write(updated_content)
                rel_path = os.path.relpath(filepath, vue_dir)
                print(f"✓ {rel_path}: {replacements_made} color updates")
                updated_count += 1

print(f"\n✨ Updated {updated_count} Vue files with refined colors!")
print("\nNew Color Palette:")
print("  Primary (Slate):   #0f172a (deep, professional)")
print("  Accent (Rose):     #e11d48 (elegant, refined)")
print("  Gold:              #f59e0b (warm, inviting)")
print("  Secondary (Cyan):  #06b6d4 (modern depth)")
