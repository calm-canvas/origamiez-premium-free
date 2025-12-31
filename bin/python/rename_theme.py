import os

def get_theme_name_from_env(env_file_path):
    """
    Reads the .env file and returns the value of the THEME_NAME key.
    """
    try:
        with open(env_file_path, 'r') as f:
            for line in f:
                if line.startswith('THEME_NAME='):
                    return line.strip().split('=')[1]
    except FileNotFoundError:
        print(f"Error: {env_file_path} not found.")
        return None
    return None

def replace_theme_name_in_files(root_dir, old_name, new_name):
    """
    Walks through all files in a directory and replaces all occurrences of
    old_name with new_name.
    """
    if not new_name:
        print("Error: New theme name is not set. Aborting.")
        return

    for subdir, _, files in os.walk(root_dir):
        # Exclude .git, node_modules, and vendor directories
        excluded_parts = {'.git', 'node_modules', 'vendor'}
        if any(part in excluded_parts for part in subdir.split(os.path.sep)):
            continue

        for filename in files:
            file_path = os.path.join(subdir, filename)
            try:
                with open(file_path, 'r', encoding='utf-8') as f:
                    file_content = f.read()

                if old_name in file_content:
                    new_content = file_content.replace(old_name, new_name)
                    with open(file_path, 'w', encoding='utf-8') as f:
                        f.write(new_content)
                    print(f"Replaced '{old_name}' with '{new_name}' in {file_path}")
            
            except UnicodeDecodeError:
                # This happens for binary files, so we can safely ignore them.
                pass

            except Exception as e:
                print(f"Could not process file {file_path}: {e}")

if __name__ == "__main__":
    # The script is in /bin/python, so project_root is two levels up.
    project_root = os.path.abspath(os.path.join(os.path.dirname(__file__), '..', '..'))
    env_file = os.path.join(project_root, '.env')

    new_theme_name = get_theme_name_from_env(env_file)

    if new_theme_name:
        # Also rename the theme directory if it exists
        old_theme_dir = os.path.join(project_root, "medmag")
        new_theme_dir = os.path.join(project_root, new_theme_name)
        if os.path.isdir(old_theme_dir):
            try:
                os.rename(old_theme_dir, new_theme_dir)
                print(f"Renamed directory '{old_theme_dir}' to '{new_theme_dir}'")
                # After renaming the directory, we do the content replacement
                replace_theme_name_in_files(project_root, "medmag", new_theme_name)
            except OSError as e:
                print(f"Error renaming directory: {e}")
        else:
             # If the directory doesn't exist, just do the content replacement
             replace_theme_name_in_files(project_root, "medmag", new_theme_name)

    else:
        print("Could not find THEME_NAME in .env file.")
