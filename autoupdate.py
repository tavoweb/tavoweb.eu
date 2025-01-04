import os
import subprocess

# „GitHub“ URL ir tikslinis aplankas
github_url = "https://github.com/tavoweb/tavoweb.eu.git"
local_repo_path = "/home/admin/domains/tavoweb.eu/public_html/"
target_path = "/home/admin/domains/tavoweb.eu/public_html/"

def update_repo():
    try:
        # Tikriname, ar tikslinis aplankas yra Git saugykla
        if not os.path.exists(target_path) or not os.path.exists(os.path.join(target_path, ".git")):
            print("Klonuojama saugykla...")
            if os.path.exists(target_path):
                print("Aplankas egzistuoja, bet nėra Git saugykla. Valome aplanką...")
                subprocess.run(["rm", "-rf", target_path], check=True)
            subprocess.run(["git", "clone", github_url, target_path], check=True)
        else:
            # Pereiname į tikslinį aplanką ir atnaujiname saugyklą
            os.chdir(target_path)
            print("Atnaujinama saugykla...")
            subprocess.run(["git", "pull"], check=True)
        print("Veiksmas atliktas sėkmingai!")
    except subprocess.CalledProcessError as e:
        print(f"Klaida vykdant Git komandą: {e}")
    except Exception as e:
        print(f"Iškilo klaida: {e}")

# Paleidžiame funkciją
update_repo()

