#!/bin/bash
shopt -s extglob dotglob
mv !(engage|archives_ancien_site|.git|.|..|replace_paths.py|migrate.sh) archives_ancien_site/
mv engage/* engage/.* . 2>/dev/null
rmdir engage
python3 replace_paths.py
