<?php include 'header.php'; ?>
<link href="css/card.css" rel="stylesheet">
<main>
<div class="container">
    
<?php
// Nuotolinės ir vietinės versijos failų keliai
$localVersionFile = __DIR__ . '/version.txt'; // Vietinis versijos failas
$remoteVersionUrl = 'https://raw.githubusercontent.com/tavoweb/tavoweb.eu/main/version.txt'; // Nuotolinis versijos failas
$githubRepoZipUrl = 'https://github.com/tavoweb/tavoweb.eu/archive/refs/heads/main.zip'; // Saugyklos ZIP URL
$rootPath = __DIR__; // Šakninė katalogo vieta

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
    $tempExtractPath = __DIR__ . '/temp';
    $zip = new ZipArchive;
    if ($zip->open($tempZipFile) === TRUE) {
        // Pašaliname seną laikiną katalogą, jei jis egzistuoja
        if (is_dir($tempExtractPath)) {
            deleteDirectory($tempExtractPath);
        }
        mkdir($tempExtractPath, 0755, true);

        // Išarchyvuojame ZIP failą
        $zip->extractTo($tempExtractPath);
        $zip->close();
    } else {
        throw new Exception("Nepavyko atidaryti ZIP failo.");
    }

    // 7. Perkelkite failus iš `<repository-name>-main` tiesiai į šakninį katalogą
    $extractedMainDir = $tempExtractPath . '/tavoweb.eu-main';
    if (!is_dir($extractedMainDir)) {
        throw new Exception("Nepavyko rasti išarchyvuoto katalogo: $extractedMainDir");
    }

    // Perkeliame turinį tiesiai į šakninį katalogą
    copyDirectory($extractedMainDir, $rootPath);

    // Ištriname laikiną ZIP failą ir išarchyvuotą turinį
    unlink($tempZipFile);
    deleteDirectory($tempExtractPath);

    // 8. Atnaujinkite vietinį versijos failą
    file_put_contents($localVersionFile, $remoteVersion);

    echo "Atnaujinimas baigtas sėkmingai.\n";

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

// Pagalbinė funkcija failų ir katalogų kopijavimui
function copyDirectory($src, $dst) {
    $dir = opendir($src);
    while (($file = readdir($dir)) !== false) {
        if ($file == '.' || $file == '..') continue;
        $srcPath = "$src/$file";
        $dstPath = "$dst/$file";
        if (is_dir($srcPath)) {
            // Jei katalogas, sukuriame naują katalogą tiksliniame kelyje
            if (!is_dir($dstPath)) mkdir($dstPath, 0755, true);
            copyDirectory($srcPath, $dstPath);
        } else {
            copy($srcPath, $dstPath);
        }
    }
    closedir($dir);
} ?>
</div>
</main>
<?php include 'footer.php'; ?>