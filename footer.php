

    <div class="b-example-divider"></div>

  

  <div class="bg-dark text-secondary px-4 py-5 text-center">

    <div class="py-5">

      <h1 class="display-5 fw-bold text-white"></h1>

      <div class="col-lg-6 mx-auto">

        <p class="fs-5 mb-4"></p>

        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">

        </div>

      </div>

    </div>

  </div>



  <div class="b-example-divider mb-0"></div>

<footer class="footer mt-auto py-3 bg-light">

    <div class="container">

      <span class="text-muted">TavoWEB. <a>Versija: 
            <?php
                // Patikrinkite, ar failas 'version.txt' egzistuoja
                $versionFile = 'version.txt';
                if (file_exists($versionFile)) {
                    // Nuskaitykite versijos numerį iš failo
                    $version = trim(file_get_contents($versionFile));
                    echo $version ? $version : 'Nėra nustatyto versijos';
                } else {
                    echo 'Failas "version.txt" nerastas';
                }
            ?>
        </a></span>

    </div>

  </footer>

</body>

</html>