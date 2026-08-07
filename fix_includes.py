import os
import re

directory = "/var/www/sternaafrica.org"
count = 0

for root, _, files in os.walk(directory):
    for file in files:
        if file.endswith((".html", ".php")) and file not in ["navbar.php", "footer.php"]:
            filepath = os.path.join(root, file)
            if "archives_ancien_site" in filepath or "scratch" in filepath:
                continue
                
            with open(filepath, "r", encoding="utf-8", errors="ignore") as f:
                content = f.read()
                
            original_content = content
            
            # Fix broken navbar include
            if "<?php include $_SERVER[DOCUMENT_ROOT] . /navbar.php; ?>" in content:
                content = content.replace(
                    "<?php include $_SERVER[DOCUMENT_ROOT] . /navbar.php; ?>\n\t</header>",
                    "<?php include $_SERVER[\"DOCUMENT_ROOT\"] . \"/navbar.php\"; ?>"
                )
                content = content.replace(
                    "<?php include $_SERVER[DOCUMENT_ROOT] . /navbar.php; ?>",
                    "<?php include $_SERVER[\"DOCUMENT_ROOT\"] . \"/navbar.php\"; ?>"
                )
                
            # Fix broken footer include
            if "<?php include $_SERVER[DOCUMENT_ROOT] . /footer.php; ?>" in content:
                content = content.replace(
                    "<?php include $_SERVER[DOCUMENT_ROOT] . /footer.php; ?>",
                    "<?php include $_SERVER[\"DOCUMENT_ROOT\"] . \"/footer.php\"; ?>"
                )
                
            # Also clean up any lingering </header> tags right after navbar if they exist from a botched regex
            content = content.replace("<?php include $_SERVER[\"DOCUMENT_ROOT\"] . \"/navbar.php\"; ?>\n\t</header>", "<?php include $_SERVER[\"DOCUMENT_ROOT\"] . \"/navbar.php\"; ?>")
            content = content.replace("<?php include $_SERVER[\"DOCUMENT_ROOT\"] . \"/navbar.php\"; ?>\n</header>", "<?php include $_SERVER[\"DOCUMENT_ROOT\"] . \"/navbar.php\"; ?>")

            if content != original_content:
                with open(filepath, "w", encoding="utf-8") as f:
                    f.write(content)
                count += 1

print(f"Fixed PHP includes in {count} files.")
