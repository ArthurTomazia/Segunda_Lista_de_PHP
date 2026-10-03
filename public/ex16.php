<?php
$resultado=null; 
$letrasMaiusculas = null;
$letrasMinusculas = null;
$quantidadeNumeros = null;
$caracteresEspeciais = null;
$tamanho = null;
$seguranca = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
$senha=$_POST['senha'];
$resultado=analisarSenha($senha);
$letrasMaiusculas=$resultado['letrasMaiusculas_resultado'];
$letrasMinusculas=$resultado['letrasMinusculas_resultado'];
$quantidadeNumeros=$resultado['quantidadeNumeros_resultado'];
$caracteresEspeciais=$resultado['caracteresEspeciais_resultado'];
$tamanho=$resultado['tamanho_resultado'];
$seguranca=$resultado['seguranca_resultado'];
}

//função que ira receber os valores e devolver os valores
//tambem calcula a seguranca da senha
function analisarSenha($senha){ 


$letrasMaiusculas = letrasMaiusculas($senha);
$letrasMinusculas = letrasMinusculas($senha);
$quantidadeNumeros = quantidadeNumeros($senha);
$caracteresEspeciais = caracteresEspeciais($senha);
$tamanho = tamanho($senha);

//calculo de seguranca
$forca = 0;

if($letrasMaiusculas>=1){$forca += 2;}
if($letrasMinusculas>=4){$forca += 2;}
if($quantidadeNumeros>=3){$forca += 2;}
if($caracteresEspeciais>=1){$forca += 2;}
if($tamanho>=8){$forca += 2;}

if($forca >= 8){
    $seguranca = "Muito forte";
}elseif($forca >= 6){
    $seguranca = "Forte";
}elseif($forca >= 4){
    $seguranca = "Média";
}else{
    $seguranca = "Fraca";
}



return[
    'letrasMaiusculas_resultado'=>$letrasMaiusculas,
    'letrasMinusculas_resultado'=>$letrasMinusculas,
    'quantidadeNumeros_resultado'=>$quantidadeNumeros,
    'caracteresEspeciais_resultado'=>$caracteresEspeciais,
    'tamanho_resultado'=>$tamanho,
    'seguranca_resultado'=>$seguranca,
    'seguranca_resultado'=>$seguranca
];

}



//função que ira ver quantas letras maiusculas tem na senha
function letrasMaiusculas($a){

preg_match_all('/\p{Lu}/u', $a, $matches);
$letrasMaiusculas = count($matches[0]);

  return $letrasMaiusculas;
}




//função que ira ver quantas letras minusculas tem na senha
function letrasMinusculas($b){

preg_match_all('/\p{Ll}/u', $b, $matches);
$letrasMinusculas = count($matches[0]);

    return $letrasMinusculas;
}

//função que ira a ver a quantidade de números da senha
function quantidadeNumeros($c){

preg_match_all('/\d/', $c, $matches);
$quantidadeNumeros = count($matches[0]);

    return $quantidadeNumeros;

}

//função que ira ver a quantidade de caracteres especiais da senha
function caracteresEspeciais($d){

preg_match_all('/[^a-zA-Z0-9\s]/u', $d, $matches);
$caracteresEspeciais = count($matches[0]);

    return $caracteresEspeciais;
}

//função que ira ver o tamanho da senha
function tamanho($e){

$semEspaco = preg_replace('/\s+/', "", $e);
$tamanho = mb_strlen($semEspaco);

    return $tamanho;
}






?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ex01</title>
</head>
<body>
    
    <form method="POST">

    <label for="senha">Insira a sua senha:</label>
    <input type="text" name="senha">
    <br>
    <button type="submit">Verificar</button>
    <br>
    <label>Quantidade de letras maiusculas: <?php echo $letrasMaiusculas; ?></label>
    <br>
    <label>Quantidade de letras minusculas: <?php echo $letrasMinusculas; ?></label>
    <br>
    <label>Quantidade de números: <?php echo $quantidadeNumeros; ?></label>
    <br>
    <label>Quantidade de caracteres especiais: <?php echo $caracteresEspeciais; ?></label>
    <br>
    <label>Quantidade de letras/números: <?php echo $tamanho; ?></label>
    <br>
    <label>Seguranca da conta: <?php echo $seguranca; ?></label>

    </form>

    <br><br>
    <button><a href="../index.php">Home</a></button>

</body>
</html>