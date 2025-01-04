import os
import subprocess

# „GitHub“ URL ir vietinė saugyklos vieta
github_url = "https://github.com/vartotojas/projektas.git"
local_repo_path = "/home/admin/domains/tavoweb.eu/public_html"

def update_repo():
    try:
        # Patikriname, ar aplankas jau egzistuoja
        if not os.path.exists(local_repo_path):
            print("Klonuojama saugykla...")
            subprocess.run(["git", "clone", github_url, local_repo_path], check=True)
        else:
            # Pereiname į vietinį aplanką ir atnaujiname saugyklą
            os.chdir(local_repo_path)
            print("Atnaujinama saugykla...")
            subprocess.run(["git", "pull"], check=True)
        print("Veiksmas atliktas sėkmingai!")
    except subprocess.CalledProcessError as e:
        print(f"Klaida vykdant Git komandą: {e}")
    except Exception as e:
        print(f"Iškilo klaida: {e}")

# Paleidžiame funkciją
update_repo()
