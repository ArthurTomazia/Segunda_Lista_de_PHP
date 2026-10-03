<?php 

$caracteres = null;
$palavras = null;
$frases = null;
$palavraLonga = null;
$palavraCurta = null;
$palavrasRepetidas = null;
$palavrasFrequentes = null;
$semEspacos = null;
$formatado = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
$texto = $_POST['texto'];
$resultado = processarTexto($texto);
$caracteres=$resultado['caracteres_resultado'];
$palavras=$resultado['palavras_resultado'];
$frases=$resultado['frases_resultado'];
$palavraLonga=$resultado['palavraLonga_resultado'];
$palavraCurta=$resultado['palavraCurta_resultado'];
$palavrasRepetidas=$resultado['palavrasRepetidas_resultado'];
$palavrasFrequentes=$resultado['palavrasFrequentes_resultado'];
$semEspacos=$resultado['semEspacos_resultado'];
$formatado=$resultado['formatado_resultado'];

}

function processarTexto($texto){
$caracteres = caracteres($texto);
$palavras = palavras($texto);
$frases = frases($texto);
$palavraLonga = palavraLonga($texto);
$palavraCurta = palavraCurta($texto);
$palavrasRepetidas = palavrasRepetidas($texto);
$palavrasFrequentes = palavrasFrequentes($texto);
$semEspacos = semEspacos($texto);
$formatado = formatado($texto);

return [
'caracteres_resultado'=>$caracteres,
'palavras_resultado'=>$palavras,
'frases_resultado'=>$frases,
'palavraLonga_resultado'=>$palavraLonga,
'palavraCurta_resultado'=>$palavraCurta,
'palavrasRepetidas_resultado'=>$palavrasRepetidas,
'palavrasFrequentes_resultado'=>$palavrasFrequentes,
'semEspacos_resultado'=>$semEspacos,
'formatado_resultado'=>$formatado
];
}

//função para contar quantos caracteres tem no texto
function caracteres($a){

$semEspaco = preg_replace('/\s+/', "", $a);
$caracteres = mb_strlen($semEspaco);

return $caracteres;
}

//função para contar quantas palavras tem no texto
function palavras($b){
$conta = array_filter(preg_split('/\s+/', trim($b)));
$palavras = count($conta);
return $palavras;


}

//função para contar quantas frases tem no texto
function frases($c){
$frases = preg_match_all('/[.,!?;:]/', $c);
if($frases === 0){
    $frases = 1;
}

return $frases;
}

//função para ver qual a palavra mais longa do texto
function palavraLonga($d){
$textoLimpo = preg_replace('/[.,\/#!$%\^&\*;:{}=\-_`~()?]/', '', $d);
$textoExplodido = explode(' ', $textoLimpo);
$maior = null;
foreach ($textoExplodido as $texto){
    if(strlen($texto) > strlen($maior)){
        $maior = $texto;
    }
}
$palavraLonga = $maior;

return $palavraLonga;
}

//função para ver qual a palavra mais curta do texto
function palavraCurta($e){
$textoLimpo = preg_replace('/[.,\/#!$%\^&\*;:{}=\-_`~()?]/', '', $e);
$textoExplodido = explode(' ', $textoLimpo);
$menor = "aksjnbdasbdbsdkasjdbkajsbdbadbsadbjkasbdjksajdhasjdhkjashdjkash";
foreach($textoExplodido as $texto){
    if(strlen($texto) < strlen($menor)){
        $menor = $texto;
    }
}
$palavraCurta=$menor;
return $palavraCurta;
}

//função para ver a quantidade de palavras repetidas no texto
function palavrasRepetidas($f){
$textoLimpo = preg_replace('/[^\p{L}\p{N}\s]/u', '', $f);
    $textoMinusculo = mb_strtolower($textoLimpo, "UTF-8");
    $palavras = array_filter(explode(' ', $textoMinusculo));
    
    $contagem = array_count_values($palavras);
    

    $repetidas = array_filter($contagem, function($qtd) {
        return $qtd > 1;
    });

    $resultado = [];
    foreach ($repetidas as $palavra => $qtd) {
        $resultado[] = "$palavra ($qtd)";
    }
    
    return implode(', ', $resultado);
}

//função para guardar as 5 palavras mais repetidas do texto
function palavrasFrequentes($g){
$textoLimpo = preg_replace('/[^\p{L}\p{N}\s]/u', '', $g);
    $textoMinusculo = mb_strtolower($textoLimpo, "UTF-8");
    $palavras = array_filter(explode(' ', $textoMinusculo));
    
    if (empty($palavras)) return '';

    $contagem = array_count_values($palavras);
    arsort($contagem); // Ordena do maior para o menor mantendo chaves
    $top5 = array_slice($contagem, 0, 5, true);

    $resultado = [];
    foreach ($top5 as $palavra => $qtd) {
        $resultado[] = "$palavra ($qtd)";
    }
    
    return implode(', ', $resultado);
}

//função para retirar os espaços duplciados do texto
function semEspacos($h){
    
    return trim(preg_replace('/\s+/', ' ', $h));
}

//função para formatar o texto com a primeira letra de cada palavra maiuscula
function formatado($i){
$formatado = mb_convert_case($i, MB_CASE_TITLE, "UTF-8");

return $formatado;
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ex02</title>
</head>
<body>

<form method="POST">

<label for="texto">Insira o seu texto: </label>
<input type="text" name="texto">
<br>
<button type="submit">Avaliar</button>
<br><br>

<label>Quantidade de caracteres: <?php echo $caracteres; ?></label>
<br>
<label>Quantidade de palavras: <?php echo $palavras; ?></label>
<br>
<label>Quantidade de frases: <?php echo $frases; ?></label>
<br>
<label>Palavra mais longa: <?php echo $palavraLonga; ?></label>
<br>
<label>Palavra mais curta: <?php echo $palavraCurta; ?></label>
<br>
<label>Palavras repetidas: <?php echo $palavrasRepetidas; ?></label>
<br>
<label>5 Palavras mais frequentes: <?php echo $palavrasFrequentes; ?></label>
<br>
<label>texto sem espaços desnecessários: <?php echo $semEspacos; ?></label>
<br>
<label>Texto formatado: <?php echo $formatado; ?></label>
<br>


    <br>
    <button><a href="../index.php">Home</a></button>
</form>
    
</body>
</html>