<?php 
$resultado = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $NUMERO=$_POST['numero'];
    $resultado = oi($NUMERO);
}

function oi($x){
    $NuMeRo = $x + 2;z
    return $NuMeRo;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<form method="POST">

<label for="texto">oii</label>
<input type="number" name="numero">
<br>
<label>Resultado: <?php echo $resultado; ?> </label>
<br>
<button type="submit">Enviar</button>

</form>

</body>
</html>