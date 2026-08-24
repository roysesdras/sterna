import urllib.request
import os
import socket

socket.setdefaulttimeout(10) # 10 seconds timeout

urls = [
    "https://i.postimg.cc/zfCN6jSD/Whats-App-Image-2026-08-20-at-12-06-18-PM.jpg",
    "https://i.postimg.cc/JhN8vqch/Whats-App-Image-2026-08-20-at-12-06-18-PM(1).jpg",
    "https://i.postimg.cc/3wXhVBCR/Whats-App-Image-2026-08-20-at-12-06-19-PM.jpg",
    "https://i.postimg.cc/pdfv4ZYL/Whats-App-Image-2026-08-20-at-12-06-19-PM(1).jpg",
    "https://i.postimg.cc/FKyv8Zgz/Whats-App-Image-2026-08-20-at-12-06-38-PM.jpg",
    "https://i.postimg.cc/JhN8vqct/Whats-App-Image-2026-08-20-at-12-06-38-PM(1).jpg",
    "https://i.postimg.cc/V6zw8CDm/Whats-App-Image-2026-08-20-at-12-06-39-PM.jpg",
    "https://i.postimg.cc/0Q9vswcN/Whats-App-Image-2026-08-20-at-12-06-40-PM.jpg",
    "https://i.postimg.cc/50fJVCn0/Whats-App-Image-2026-08-20-at-12-06-41-PM.jpg",
    "https://i.postimg.cc/ZRJmSdVn/Whats-App-Image-2026-08-20-at-12-06-41-PM(1).jpg",
    "https://i.postimg.cc/j5RTb7Zn/Whats-App-Image-2026-08-20-at-12-06-43-PM.jpg",
    "https://i.postimg.cc/9Mc2h7Jq/Whats-App-Image-2026-08-20-at-12-06-43-PM(1).jpg",
    "https://i.postimg.cc/hjKnBdpd/Whats-App-Image-2026-08-20-at-12-06-43-PM(2).jpg",
    "https://i.postimg.cc/fLMsN9Bm/Whats-App-Image-2026-08-20-at-12-06-44-PM.jpg",
    "https://i.postimg.cc/rmqTkrQj/Whats-App-Image-2026-08-20-at-12-06-44-PM(1).jpg"
]

out_dir = "/var/www/sternaafrica.org/assets/img/header"

success_count = 0
for i, url in enumerate(urls):
    filename = f"slide_{i+1}.jpg"
    filepath = os.path.join(out_dir, filename)
    
    # Check if already exists and size > 0
    if os.path.exists(filepath) and os.path.getsize(filepath) > 0:
        success_count += 1
        continue
        
    print(f"Downloading slide_{i+1}...")
    try:
        # User-Agent to avoid blocks
        req = urllib.request.Request(url, headers={'User-Agent': 'Mozilla/5.0'})
        with urllib.request.urlopen(req) as response, open(filepath, 'wb') as out_file:
            data = response.read()
            out_file.write(data)
        success_count += 1
    except Exception as e:
        print(f"Failed {filename}: {e}")

print(f"Total downloaded: {success_count}/{len(urls)}")
