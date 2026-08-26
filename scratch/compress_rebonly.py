import os
import sys
from PIL import Image

TARGET_DIRS = [
    '/var/www/rebonly.com/uploads',
    '/var/www/rebonly.com/assets'
]

MAX_DIM = 1200
QUALITY = 82
MIN_SIZE_BYTES = 150 * 1024  # Compress files larger than 150KB

total_saved = 0
processed = 0
errors = 0

print("Starting RebOnly image compression...")

for target_dir in TARGET_DIRS:
    if not os.path.exists(target_dir):
        continue

    for root, _, files in os.walk(target_dir):
        for file in files:
            ext = os.path.splitext(file)[1].lower()
            if ext not in ['.jpg', '.jpeg', '.png']:
                continue

            filepath = os.path.join(root, file)
            try:
                stat = os.stat(filepath)
                if stat.st_size < MIN_SIZE_BYTES:
                    continue

                orig_size = stat.st_size

                with Image.open(filepath) as img:
                    width, height = img.size

                    if width > MAX_DIM or height > MAX_DIM:
                        img.thumbnail((MAX_DIM, MAX_DIM), Image.Resampling.LANCZOS)

                    if ext in ['.jpg', '.jpeg']:
                        if img.mode in ('RGBA', 'P', 'LA'):
                            img = img.convert('RGB')
                        img.save(filepath, format='JPEG', quality=QUALITY, optimize=True)
                    elif ext == '.png':
                        if img.mode == 'P':
                            img = img.convert('RGBA')
                        img.save(filepath, format='PNG', optimize=True)

                new_size = os.path.getsize(filepath)
                saved = orig_size - new_size
                if saved > 0:
                    total_saved += saved
                    processed += 1
                    print(f"Compressed {filepath}: {orig_size / (1024*1024):.2f}MB -> {new_size / (1024*1024):.2f}MB (saved {saved / (1024*1024):.2f}MB)")
                else:
                    print(f"Skipped {filepath}: no size reduction")

            except Exception as e:
                errors += 1
                print(f"Error processing {filepath}: {e}")

print(f"\nRebOnly compression complete! Processed {processed} files. Total saved: {total_saved / (1024*1024):.2f} MB. Errors: {errors}")
