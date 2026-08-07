import os
import re

directory = "/var/www/sternaafrica.org"
count = 0

og_pattern = re.compile(r"(<meta property=[\"']og:image[\"'] content=)[\"'][^\"']*[\"'](\s*/?>)")
tw_pattern = re.compile(r"(<meta name=[\"']twitter:image[\"'] content=)[\"'][^\"']*[\"'](\s*/?>)")

new_image_url = "https://sternaafrica.org/images/garde.jpg"

for root, _, files in os.walk(directory):
    for file in files:
        if file.endswith((".html", ".php")):
            filepath = os.path.join(root, file)
            # Skip old archive folders
            if "archives_ancien_site" in filepath or "scratch" in filepath:
                continue
                
            with open(filepath, "r", encoding="utf-8", errors="ignore") as f:
                content = f.read()
                
            changed = False
            
            if og_pattern.search(content):
                content = og_pattern.sub(r"\g<1>\"" + new_image_url + r"\"\g<2>", content)
                changed = True
                
            if tw_pattern.search(content):
                content = tw_pattern.sub(r"\g<1>\"" + new_image_url + r"\"\g<2>", content)
                changed = True
                
            # If the json-ld schema has thumbnail URLs that are the transition brush
            if "TRANSITION-BRUSH-WHITE" in content or "thumbnailUrl" in content:
                content = re.sub(r"\"thumbnailUrl\":\"[^\"]*\"", f"\"thumbnailUrl\":\"{new_image_url}\"", content)
                content = re.sub(
                    r"\"@type\":\"ImageObject\",\"inLanguage\":\"fr-FR\",\"@id\":\"([^\"]*)\",\"url\":\"[^\"]*\",\"contentUrl\":\"[^\"]*\"",
                    r"\"@type\":\"ImageObject\",\"inLanguage\":\"fr-FR\",\"@id\":\"\g<1>\",\"url\":\"" + new_image_url + r"\",\"contentUrl\":\"" + new_image_url + r"\"",
                    content
                )
                changed = True

            if changed:
                with open(filepath, "w", encoding="utf-8") as f:
                    f.write(content)
                count += 1

print(f"Updated og:image in {count} files.")
