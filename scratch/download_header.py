import urllib.request
import os

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

for i, url in enumerate(urls):
    filename = f"slide_{i+1}.jpg"
    filepath = os.path.join(out_dir, filename)
    print(f"Downloading {url} to {filepath}")
    urllib.request.urlretrieve(url, filepath)

print("All downloaded!")
