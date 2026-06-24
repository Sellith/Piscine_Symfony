curl -s $1 | grep -E -o '"([^+$]+)"' | cut -d'"' -f2
