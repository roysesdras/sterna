import os
import re
import urllib.request
import hashlib
from PIL import Image

PROJECTS = [
    '/var/www/sternaafrica.org',
    '/var/www/reseauurunaniafrique.org',
    '/var/www/rebonly.com'
]

URL_PATTERN = re.compile(r'https?://(?:i\.postimg\.cc|postimg\.cc|i\.ibb\.co|ibb\.co)/[^\s\'"<>]+')

MAX_DIM = 1200
QUALITY = 82

for project_dir in PROJECTS:
    if not os.path.exists(project_dir):
        continue

    local_img_dir = os.path.join(project_dir, 'assets', 'img', 'external')
    os.makedirs(local_img_dir, exist_ok=True)

    print(f"\nProcessing external images in {project_dir}...")
    localized_count = 0

    for root, _, files in os.walk(project_dir):
        # Skip vendor, node_modules, .git
        if any(skip in root for skip in ['vendor', 'node_modules', '.git', 'scratch']):
            continue

        for file in files:
            if not file.endswith(('.php', '.html', '.css', '.js')):
                continue

            filepath = os.path.join(root, file)
            try:
                with open(filepath, 'r', encoding='utf-8', errors='ignore') as f:
                    content = f.read()

                urls = list(set(URL_PATTERN.findall(content)))
                if not urls:
                    continue

                modified = False
                for url in urls:
                    # Clean trailing chars if any
                    clean_url = url.rstrip(';)"\'')
                    
                    # Generate deterministic local filename based on url
                    ext = os.path.splitext(clean_url.split('?')[0])[1].lower()
                    if ext not in ['.jpg', '.jpeg', '.png', '.webp', '.gif']:
                        ext = '.png' if 'png' in clean_url else '.jpg'

                    url_hash = hashlib.md5(clean_url.encode('utf-8')).hexdigest()[:10]
                    clean_name = os.path.basename(clean_url.split('?')[0])
                    clean_name = re.sub(r'[^a-zA-Z0-9_\.-]', '_', clean_name)
                    if not clean_name or clean_name == ext:
                        clean_name = f"ext_{url_hash}{ext}"
                    else:
                        clean_name = f"{url_hash}_{clean_name}"

                    local_path = os.path.join(local_img_dir, clean_name)
                    web_path = f"/assets/img/external/{clean_name}"

                    # Download if not exists
                    if not os.path.exists(local_path):
                        try:
                            req = urllib.request.Request(clean_url, headers={'User-Agent': 'Mozilla/5.0'})
                            with urllib.request.urlopen(req, timeout=10) as response, open(local_path, 'wb') as out_file:
                                out_file.write(response.read())

                            # Compress local image
                            try:
                                with Image.open(local_path) as img:
                                    w, h = img.size
                                    if w > MAX_DIM or h > MAX_DIM:
                                        img.thumbnail((MAX_DIM, MAX_DIM), Image.Resampling.LANCZOS)
                                    if ext in ['.jpg', '.jpeg']:
                                        if img.mode in ('RGBA', 'P', 'LA'):
                                            img = img.convert('RGB')
                                        img.save(local_path, format='JPEG', quality=QUALITY, optimize=True)
                                    elif ext == '.png':
                                        if img.mode == 'P':
                                            img = img.convert('RGBA')
                                        img.save(local_path, format='PNG', optimize=True)
                            except Exception as compress_err:
                                pass

                            print(f"Downloaded & compressed {clean_url} -> {web_path}")

                        except Exception as dl_err:
                            print(f"Failed to download {clean_url}: {dl_err}")
                            continue

                    # Replace in content
                    content = content.replace(clean_url, web_path)
                    modified = True
                    localized_count += 1

                if modified:
                    with open(filepath, 'w', encoding='utf-8') as f:
                        f.write(content)

            except Exception as file_err:
                print(f"Error checking {filepath}: {file_err}")

    print(f"Finished {project_dir}: {localized_count} external URLs localized and compressed.")

