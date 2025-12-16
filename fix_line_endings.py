import os

# List of extensions to process
TEXT_EXTENSIONS = {
    '.php', '.txt', '.css', '.js'
}

def is_text_file(filename):
    _, ext = os.path.splitext(filename)
    return ext.lower() in TEXT_EXTENSIONS

def to_unix_line_endings(file_path):
    try:
        with open(file_path, 'rb') as f:
            content = f.read()

        # Replace Windows (\r\n) and old Mac (\r) line endings with Unix (\n)
        new_content = content.replace(b'\r\n', b'\n').replace(b'\r', b'\n')

        if new_content != content:
            with open(file_path, 'wb') as f:
                f.write(new_content)
            print(f"Fixed: {file_path}")
    except Exception as e:
        print(f"Error processing {file_path}: {e}")

def process_directory(directory):
    for root, dirs, files in os.walk(directory):
        for file in files:
            if file.startswith('.'):
                continue

            if is_text_file(file):
                file_path = os.path.join(root, file)
                to_unix_line_endings(file_path)

if __name__ == "__main__":
    target_dir = "origamiez"
    if os.path.exists(target_dir):
        print(f"Scanning directory: {target_dir}...")
        process_directory(target_dir)
        print("Done.")
    else:
        print(f"Directory not found: {target_dir}")
