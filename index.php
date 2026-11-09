<?php 

    $prodotto = "";
    $prezzo = "";
    $sconto = "";

    $prodotto = isset($_POST["prodotto"]) && !empty($_POST["prodotto"]) ? htmlspecialchars($_POST["prodotto"]) : 'NOT_VALID';
    $prezzo = isset($_POST["prezzo"]) && !empty($_POST["prezzo"]) && is_numeric($_POST["prezzo"]) ? floatval($_POST["prezzo"]) : 'NOT_VALID';
    $sconto = isset($_POST["sconto"]) && !empty($_POST["sconto"]) && is_numeric($_POST["sconto"]) ? intval($_POST["sconto"]) : 'NOT_VALID';

    $errore_prodotto = false;
    $errore_prezzo = false;
    $errore_sconto = false;

    $mostra_risultato = false;

    if ($prodotto == 'NOT_VALID' || strlen($prodotto) > 30) {
        $errore_prodotto = true;
        $prodottoInput = !empty($_POST["prodotto"]) ? ($_POST["prodotto"]) : "";
    }

    if ($prezzo == 'NOT_VALID' || $prezzo <= 0) {
        $errore_prezzo = true;
        $prezzoInput = !empty($_POST["prezzo"]) ? ($_POST["prezzo"]) : "";
    }

    if ($sconto == 'NOT_VALID' || $sconto <= 0 || $sconto > 90) {
        $errore_sconto = true;
        $scontoInput = !empty($_POST["sconto"]) ? ($_POST["sconto"]) : "";
    }

    $classe_card = "";
    $fascia = "";
    $risultato = 0;

    if (!$errore_sconto && !$errore_prodotto && !$errore_sconto ) {
        $mostra_risultato = true;    
        $risultato = $prezzo - (($prezzo * $sconto)/100);
        
        if ($sconto < 20) {
            $classe_card = "piccolo";
            $fascia = "PICCOLO";
        } else if ($sconto >= 20 && $sconto < 50 ) {
            $classe_card = "buono";
            $fascia = "BUONO";
        } else  if ($sconto >= 50 ) {
            $classe_card = "super";
            $fascia = "SUPER";
        }
    } else {
        $fascia = "NOT_VALID";
        $risultato = "NOT_VALID";
    }
    
    $prezzoFormattato = ($prezzo != "NOT_VALID") ? "€" . number_format($prezzo, 2, '.', '') : "NOT_VALID";
    $scontoFormattato = ($sconto != "NOT_VALID") ? $sconto . "%" : "NOT_VALID";
    $risultatoFormattato = ($risultato != "NOT_VALID") ? "€" . number_format($risultato, 2, '.', '') : "NOT_VALID";

    $data = date("d/m/Y - G:i:s");
    $ip = $_SERVER['REMOTE_ADDR'];

    $nomeFile = "README.md";
    $file = fopen($nomeFile, "a");

    $record = implode(" - ", [$data, $ip, $prodotto, $prezzo, $sconto, $risultatoFormattato, $fascia]);
    $record .= PHP_EOL;
    fwrite($file, $record);
    fclose($file);  



?>
    
<?php if (!$mostra_risultato): ?>
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
            <input type="text" id="prodotto" name="prodotto" maxlength="30" required class="<?php if (!empty($errore_prodotto)): ?> errore <?php endif; ?>" value = "<?php if (!empty($errore_prodotto)) { echo htmlspecialchars($prodottoInput); } else { echo $prodotto; } ?>">
            <?php if (!empty($errore_prodotto)): ?>
                <p class="msg-errore">Valore non valido.</p>
            <?php endif; ?>
            <label for="prezzo">Prezzo (€)</label>
            <input type="text" id="prezzo" name="prezzo" class="<?php if (!empty($errore_prezzo)): ?> errore <?php endif; ?>" value = "<?php if (!empty($errore_prezzo)) { echo ($prezzoInput); } else { echo $prezzo; } ?>">
            <?php if (!empty($errore_prezzo)): ?>
                <p class="msg-errore">Valore non valido.</p>
            <?php endif; ?>
            <label for="sconto">Sconto (%)</label>
            <input type="text" id="sconto" name="sconto" maxlength = "2" class="<?php if (!empty($errore_sconto)): ?> errore <?php endif; ?>" value = "<?php if (!empty($errore_sconto)) { echo htmlspecialchars($scontoInput); } else { echo $sconto; }?>">
            <?php if (!empty($errore_sconto)): ?>
                <p class="msg-errore">Valore non valido.</p>
            <?php endif; ?>
            <button type="submit">Calcola</button>
        </form>
    </body>
    </html>

<?php else: ?>

    <!DOCTYPE html>
    <html lang="it">
    <head>
        <meta charset="UTF-8">
        <title>Calcolatore di sconto</title>
        <link rel="stylesheet" href="stile.css">
    </head>
    <body>

        <div class="container"> </div>
            <h1>Ecco il tuo Prezzo</h1>
        
            <?php if ($prodotto != "NOT_VALID" && $prezzo != "NOT_VALID" && $sconto != "NOT_VALID"): ?>
                    <div class = "card <?php echo $classe_card ?>">
                        <div class="prodotto">Prodotto: <?php echo $prodotto; ?></div>
                        <div class="dati-inseriti">
                            Prezzo &euro; <?php echo $prezzo; ?> &middot; Sconto <?php echo $sconto; ?> &percnt;
                        </div>
                        <div class="valore-risultato">
                            &euro; <?php echo number_format($risultato, 2, '.', ''); ?>
                        </div>
                        <div class="testo-fascia">
                            <?php echo $fascia; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="card" style="text-align: center;">
                        <p>Nessun dato valido ricevuto.</p>
                    </div>
                <?php endif; ?>

            <a href="index.php" class="link-riprova">Calcola di nuovo</a>
        </div>
    </body>
    </html>
<?php endif; ?>