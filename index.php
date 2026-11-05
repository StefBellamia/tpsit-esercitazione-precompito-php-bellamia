<?php 

$prodotto = isset($_POST["prodotto"]) && !isempty($_POST["prodotto"]) ? htmlspecialchars($_POST["prodotto"]) : 'NOT_VALID';
$prezzo = isset($_POST["prezzo"]) && !isempty($_POST["prezzo"]) && is_numeric($_POST["prezzo"]) ? floatval($_POST["prezzo"]) 
$sconto =



?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Calcolatore di sconto</title>
    <link rel="stylesheet" href="stile.css">
</head>
<body>
    <h1>Calcolatore di sconto</h1>
    <form method="post" action="index.php">
        <label for="prodotto">Prodotto</label>
        <input type="text" id="prodotto" name="prodotto" maxlength="30" required>
        <label for="prezzo">Prezzo (€)</label>
        <input type="text" id="prezzo" name="prezzo" class="errore">
        <p class="msg-errore">Il prezzo deve essere maggiore di 0</p>
        <label for="sconto">Sconto (%)</label>
        <input type="text" id="sconto" name="sconto" maxlength = "2">
        <button type="submit">Calcola</button>
    </form>
</body>
</html>