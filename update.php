<?php
// Nuotolinės ir vietinės versijos failų keliai
$localVersionFile = __DIR__ . '/version.txt'; // Vietinis versijos failas
$remoteVersionUrl = 'https://raw.githubusercontent.com/tavoweb/tavoweb.eu/main/version.txt'; // Nuotolinis versijos failas
$githubRepoZipUrl = 'https://github.com/tavoweb/tavoweb.eu/archive/refs/heads/main.zip'; // Saugyklos ZIP URL
$localProjectPath = __DIR__ . '/project'; // Katalogas, kuriame saugomas projektas

try {
    // 1. Patikrinkite, ar egzistuoja vietinis versijos failas
    if (!file_exists($localVersionFile)) {
        throw new Exception("Vietinis versijos failas nerastas: $localVersionFile");
    }
    
    // 2. Skaitykite vietinę versiją
    $localVersion = trim(file_get_contents($localVersionFile));
    if (!$localVersion) {
        throw new Exception("Negalima nuskaityti vietinės versijos iš failo.");
    }
    
    // 3. Gaukite nuotolinę versiją
    $remoteVersion = trim(file_get_contents($remoteVersionUrl));
    if (!$remoteVersion) {
        throw new Exception("Negalima nuskaityti nuotolinės versijos iš: $remoteVersionUrl");
    }
    
    echo "Vietinė versija: $localVersion\n";
    echo "Nuotolinė versija: $remoteVersion\n";
    
    // 4. Palyginkite versijas
    if ($localVersion === $remoteVersion) {
        echo "Versijos sutampa. Atnaujinimas nereikalingas.\n";
        exit;
    }

    echo "Versijos skiriasi. Atnaujinama...\n";

    // 5. Atsisiųskite saugyklos ZIP failą
    $tempZipFile = __DIR__ . '/repo.zip';
    file_put_contents($tempZipFile, fopen($githubRepoZipUrl, 'r'));

    // 6. Išarchyvuokite ZIP failą
    $zip = new ZipArchive;
    if ($zip->open($tempZipFile) === TRUE) {
        // Ištriname seną projektą, jei jis egzistuoja
        if (is_dir($localProjectPath)) {
            deleteDirectory($localProjectPath);
        }
        mkdir($localProjectPath, 0755, true);
        
        // Išarchyvuojame į laikino katalogo vidų
        $zip->extractTo($localProjectPath);
        $zip->close();
        echo "Projektas atnaujintas sėkmingai.\n";
    } else {
        throw new Exception("Nepavyko atidaryti ZIP failo.");
    }

    // 7. Atnaujinkite vietinį versijos failą
    file_put_contents($localVersionFile, $remoteVersion);

    // 8. Ištrinkite laikiną ZIP failą
    unlink($tempZipFile);

    echo "Atnaujinimas baigtas.\n";

} catch (Exception $e) {
    echo "Klaida: " . $e->getMessage() . "\n";
}

// Pagalbinė funkcija katalogo ištrynimui
function deleteDirectory($dir) {
    if (!is_dir($dir)) return;
    $items = array_diff(scandir($dir), ['.', '..']);
    foreach ($items as $item) {
        $path = "$dir/$item";
        is_dir($path) ? deleteDirectory($path) : unlink($path);
    }
    rmdir($dir);
}
?>