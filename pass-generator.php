<?php include 'header.php'; ?>
<script src="js/passgen.js"></script>
<title>Slaptažodžių generatorius</title>
<main>
    
    <form id="password-form">
        <label>Slaptažodžio ilgis:</label>
        <input type="number" min="1" max="50" id="length" value="12">
        <br>
        <label>Sudėtingumas:</label>
        
        <h4><input type="checkbox" id="letersex" value="letersex" checked> Didžiosios ir mažosios raidės isskyrus iLoO (ABC abc 1-9)</h4>
        
        <h4><input type="checkbox" id="uppercase" value="uppercase"> Didžiosios raidės (ABC)</h4>
        
        <h4><input type="checkbox" id="lowercase" value="lowercase"> Mažosios raidės (abc)</h4>
        
        <h4><input type="checkbox" id="numbers" value="numbers"> Skaičiai (0-9)</h4>
        
        <h4><input type="checkbox" id="symbols" value="symbols"> Simboliai (.,/;*)</h4>
        <br>
        <br>
        <button type="button" onclick="generatePassword()" class="btn btn-warning">Generuoti slaptažodį</button>
        <button type="button" onclick="clearForm()" class="btn btn-warning">Išvalyti</button>
        <br>
        <br>
        <label>Paskutinių generuotų slaptažodžių sąrašas:</label>
        <ul id="password-list">


        </ul>
    </form>

</main>
<?php include 'footer.php'; ?>