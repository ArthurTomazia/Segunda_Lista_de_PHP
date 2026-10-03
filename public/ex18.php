<?php

// 1. Função para contar pacientes diferentes
function contarPacientesUnicos($consultas) {
    $pacientes = [];
    foreach ($consultas as $c) {
        $nome = $c[0];
        if (!in_array($nome, $pacientes)) {
            $pacientes[] = $nome;
        }
    }
    return count($pacientes);
}

// 2. Função para contar consultas por especialidade (Array Associativo)
function contarPorEspecialidade($consultas) {
    $especialidades = [];
    foreach ($consultas as $c) {
        $esp = $c[1];
        if (!isset($especialidades[$esp])) {
            $especialidades[$esp] = 0;
        }
        $especialidades[$esp]++;
    }
    return $especialidades;
}

// 3. Função para ordenar a lista pelo horário
function ordenarPorHorario($consultas) {
    $ordenado = $consultas;
    usort($ordenado, function($a, $b) {
        return strcmp($a[3], $b[3]);
    });
    return $ordenado;
}

// 4. Função para pesquisar pacientes pelo nome
function pesquisarPaciente($consultas, $nomeBuscado) {
    $encontrados = [];
    foreach ($consultas as $c) {
        if (strcasecmp($c[0], $nomeBuscado) === 0) {
            $encontrados[] = $c;
        }
    }
    return $encontrados;
}

// 5. Função para verificar horários duplicados na mesma data
function verificarHorariosDuplicados($consultas) {
    $horariosVistos = [];
    foreach ($consultas as $c) {
        $chaveDataHorario = $c[2] . " " . $c[3];
        if (in_array($chaveDataHorario, $horariosVistos)) {
            return true; // Existe duplicata
        }
        $horariosVistos[] = $chaveDataHorario;
    }
    return false; // Não existem duplicatas
}

// 6. Função Principal: reúne todas as informações em um único array
function organizarAgenda($consultas, $pacienteParaPesquisa = "") {
    $listaOrdenada = ordenarPorHorario($consultas);
    $totalConsultas = count($consultas);
    
    $primeiroAtendimento = $totalConsultas > 0 ? $listaOrdenada[0] : null;
    $ultimoAtendimento = $totalConsultas > 0 ? $listaOrdenada[$totalConsultas - 1] : null;

    // Retorna todos os resultados em um único array
    return [
        $totalConsultas,                                  // [0] Total de consultas
        contarPacientesUnicos($consultas),               // [1] Pacientes diferentes
        contarPorEspecialidade($consultas),              // [2] Consultas por especialidade
        $primeiroAtendimento,                             // [3] Primeiro atendimento do dia
        $ultimoAtendimento,                               // [4] Último atendimento do dia
        $listaOrdenada,                                   // [5] Lista ordenada por horário
        pesquisarPaciente($consultas, $pacienteParaPesquisa), // [6] Pesquisa de paciente
        verificarHorariosDuplicados($consultas)           // [7] Horários duplicados (true/false)
    ];
}

// ==========================================
// Exemplo de Execução / Teste
// ==========================================

// Vetor multidimensional com as consultas [Nome, Especialidade, Data, Horario]
$agenda = [
    ["Carlos Silva", "Cardiologia", "2026-10-10", "14:30"],
    ["Ana Souza", "Dermatologia", "2026-10-10", "09:00"],
    ["Carlos Silva", "Pediatria", "2026-10-10", "11:00"],
    ["Mariana Lima", "Dermatologia", "2026-10-10", "10:15"]
];

// Chamada da função buscando o paciente "Carlos Silva"
$resultado = organizarAgenda($agenda, "Carlos Silva");

// Exibindo os resultados com <br>
echo "Total de consultas: " . $resultado[0] . "<br>";
echo "Pacientes diferentes: " . $resultado[1] . "<br>";

echo "Consultas por especialidade:<br>";
echo "<pre>";
print_r($resultado[2]);
echo "</pre>";

echo "Primeiro atendimento: " . $resultado[3][0] . " às " . $resultado[3][3] . "<br>";
echo "Último atendimento: " . $resultado[4][0] . " às " . $resultado[4][3] . "<br>";

echo "Horários duplicados: " . ($resultado[7] ? "Sim" : "Não") . "<br>";

echo "Busca por paciente:<br>";
echo "<pre>";
print_r($resultado[6]);
echo "</pre>";