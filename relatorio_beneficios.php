<?php session_start(); if(!isset($_SESSION['usuario'])){ header("Location: login.php"); exit(); } ?>
<!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8"><title>Relatório Benefícios</title>
<style>
body{font-family:Arial;padding:30px;background:#f3f4f6} .topo{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px}
table{width:100%;border-collapse:collapse;background:white}
th,td{padding:10px;border:1px solid #ddd} th{background:#111827;color:white}
button{padding:12px 18px;border:none;background:#2563eb;color:white;border-radius:10px;cursor:pointer}
@media print{button{display:none}}
</style></head><body>
<div class="topo"><h1>Relatório de Benefícios</h1><button onclick="window.print()">Gerar PDF</button></div>
<table id="tb"><thead><tr><th>Funcionário</th><th>Convênio</th><th>VT</th><th>VR</th><th>VA</th><th>Odonto</th></tr></thead><tbody></tbody></table>
<script>
Promise.all([
fetch('api/funcionarios/listar.php').then(r=>r.json()),
fetch('api/beneficios/listar.php').then(r=>r.json())
]).then(([funcs,beneficios])=>{
 const tbody=document.querySelector('#tb tbody');
 funcs.forEach(f=>{
   const b=beneficios.find(x=>x.funcionario_id==f.id)||{};
   const s=v=>v==1?'Sim':'Não';
   tbody.innerHTML += `<tr>
   <td>${f.nome}</td><td>${s(b.convenio)}</td><td>${s(b.vt)}</td><td>${s(b.vr)}</td><td>${s(b.va)}</td><td>${s(b.odonto)}</td>
   </tr>`;
 });
});
</script></body></html>