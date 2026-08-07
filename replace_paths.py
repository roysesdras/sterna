import os

def replace_in_file(filepath, old_str, new_str):
    try:
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()
        
        if old_str in content:
            content = content.replace(old_str, new_str)
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(content)
            print(f"Replaced in {filepath}")
    except Exception as e:
        print(f"Error reading/writing {filepath}: {e}")

def walk_and_replace(root_dir):
    for dirpath, _, filenames in os.walk(root_dir):
        if 'archives_ancien_site' in dirpath:
            continue
        for filename in filenames:
            if filename.endswith('.php') or filename.endswith('.html'):
                filepath = os.path.join(dirpath, filename)
                replace_in_file(filepath, '/engage/', '/')

if __name__ == "__main__":
    walk_and_replace('/var/www/sternaafrica.org')
