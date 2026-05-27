<?php session_start(); if(!isset($_SESSION['usuario'])){ header("Location: login.php"); exit(); } ?>
<!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8"><title>Relatório Férias</title>
<style>
body{font-family:Arial;padding:30px;background:#f3f4f6} .topo{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px}
table{width:100%;border-collapse:collapse;background:white;font-size:12px}
th,td{padding:10px;border:1px solid #ddd} th{background:#111827;color:white}
button{padding:12px 18px;border:none;background:#2563eb;color:white;border-radius:10px;cursor:pointer}
@media print{button{display:none}}
</style></head><body>
<div class="topo"><h1>Relatório de Férias</h1><button onclick="window.print()">Gerar PDF</button></div>
<table id="tb"><thead><tr><th>Funcionário</th><th>Admissão</th><th>Base</th><th>Dias</th><th>Última</th><th>Próxima</th><th>Saída</th><th>Retorno</th><th>Vendeu 10</th><th>Pagas</th><th>Status</th></tr></thead><tbody></tbody></table>
<script>
Promise.all([
fetch('api/funcionarios/listar.php').then(r=>r.json()),
fetch('api/ferias/listar.php').then(r=>r.json())
]).then(([funcs,ferias])=>{
 const tbody=document.querySelector('#tb tbody');
 funcs.forEach(f=>{
   const reg=ferias.find(x=>x.funcionario_id==f.id)||{};
   tbody.innerHTML += `<tr>
   <td>${f.nome||''}</td>
   <td>${f.data_admissao||''}</td>
   <td>${reg.ultima_feria||f.data_admissao||''}</td>
   <td>-</td>
   <td>${reg.ultima_feria||''}</td>
   <td>${reg.proxima_feria||''}</td>
   <td>${reg.data_saida||''}</td>
   <td>${reg.retorno_ferias||''}</td>
   <td>${reg.vendeu_10_dias==1?'Sim':'Não'}</td>
   <td>${reg.ferias_pagas==1?'Sim':'Não'}</td>
   <td>Ativo</td>
   </tr>`;
 });
});
</script></body></html>