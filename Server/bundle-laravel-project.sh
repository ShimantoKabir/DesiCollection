#!/bin/bash

# ------------------------------------------------------------------------------
# Laravel Project Bundler
# Scans the project and combines source code into a single text file.
# ------------------------------------------------------------------------------

OUTPUT_FILE="laravel-project-code.txt"

# 1. SETUP IGNORES
# Directories to completely skip (Pruned from find)
IGNORE_DIRS=(
  ".git" "node_modules" "vendor" "storage" "bootstrap/cache" 
  "public/storage" "public/build" ".idea" ".vscode"
)

# Specific filenames to skip
IGNORE_FILES=(
  "package-lock.json"
  "composer.lock"
  "auth.json"
  ".DS_Store"
  ".phpunit.result.cache"
  "$OUTPUT_FILE"
  "bundle-laravel-project.sh" # Don't include self
)

# Allowed file extensions (Whitelist)
# Added: php, blade.php, js, ts, vue, css, scss, env, example, sql
VALID_EXTENSIONS=(
  "php" "js" "ts" "vue" "css" "scss" "html" 
  "json" "yaml" "yml" "xml" "md" "sql"
  "env" "example" "dockerfile" "sh"
)

# ------------------------------------------------------------------------------

echo "Scanning Laravel project at: $(pwd) ..."
> "$OUTPUT_FILE" # Clear/Create file

# Construct the 'find' command prune arguments
PRUNE_ARGS=""
for dir in "${IGNORE_DIRS[@]}"; do
  PRUNE_ARGS="$PRUNE_ARGS -name \"$dir\" -o"
done
PRUNE_ARGS=${PRUNE_ARGS%-o}

# Helper to check extension
is_valid_extension() {
  local filename=$(basename "$1")
  
  # Special case for .env files which might not have a "prefix"
  if [[ "$filename" == ".env"* ]]; then return 0; fi

  local ext="${filename##*.}"
  if [ "$filename" == "$ext" ]; then return 1; fi

  for valid in "${VALID_EXTENSIONS[@]}"; do
    if [[ "${ext,,}" == "${valid,,}" ]]; then
      return 0
    fi
  done
  return 1
}

# Helper to check ignored files
is_ignored_file() {
  local filename=$(basename "$1")
  for ignore in "${IGNORE_FILES[@]}"; do
    if [[ "$filename" == "$ignore" ]]; then
      return 0
    fi
  done
  return 1
}

# Main Loop
eval "find . -type d \( $PRUNE_ARGS \) -prune -o -type f -print0" | while IFS= read -r -d '' file; do

  if is_ignored_file "$file"; then continue; fi
  if ! is_valid_extension "$file"; then continue; fi

  # Security Check: Skip if it's a binary file (even if extension matched)
  if grep -qI . "$file"; then
    echo "Adding: $file"
    
    # Write Header with relative path for cleaner reading
    echo "------------------------------------------------------------------------" >> "$OUTPUT_FILE"
    echo "FILE: $file" >> "$OUTPUT_FILE"
    echo "------------------------------------------------------------------------" >> "$OUTPUT_FILE"

    # Write Content
    cat "$file" >> "$OUTPUT_FILE"

    # Spacing
    echo -e "\n\n" >> "$OUTPUT_FILE"
  else
    echo "Skipping binary: $file"
  fi

done

echo ""
echo "Done! Laravel project code saved to: $OUTPUT_FILE"