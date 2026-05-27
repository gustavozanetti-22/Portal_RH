<?php
session_start();
if(!isset($_SESSION['usuario'])){ header("Location: login.php"); exit(); }
?>
<!DOCTYPE html><html lang="pt-br"><head>
<meta charset="UTF-8">
<title>Relatório Funcionários</title>
<link rel="stylesheet" href="css/global.css">
<style>
body{font-family:Arial;padding:30px;background:#f3f4f6}
.topo{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px}
table{width:100%;border-collapse:collapse;background:white}
th,td{padding:12px;border:1px solid #ddd;text-align:left}
th{background:#111827;color:white}
button{padding:12px 18px;border:none;background:#2563eb;color:white;border-radius:10px;cursor:pointer}
@media print{button{display:none}}
</style></head><body>
<div class="topo">
<h1>Relatório de Funcionários</h1>
<button onclick="window.print()">Gerar PDF</button>
</div>
<table id="tabela"><thead><tr>
<th>Nome</th><th>CPF</th><th>Cargo</th><th>Salário</th><th>Email</th><th>Data Admissão</th><th>Entrada</th><th>Saída</th>
</tr></thead><tbody></tbody></table>
<script>
fetch('api/funcionarios/listar.php')
.then(r=>r.json())
.then(data=>{
 const tbody=document.querySelector('#tabela tbody');
 data.forEach(f=>{
   tbody.innerHTML += `<tr>
   <td>${f.nome||''}</td>
   <td>${f.cpf||''}</td>
   <td>${f.cargo||''}</td>
   <td>R$ ${f.salario||''}</td>
   <td>${f.email||''}</td>
   <td>${f.data_admissao||''}</td>
   <td>${f.horario_entrada||''}</td>
   <td>${f.horario_saida||''}</td>
   </tr>`;
 });
});
</script></body></html>