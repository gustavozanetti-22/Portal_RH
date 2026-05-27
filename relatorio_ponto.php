<?php session_start(); if(!isset($_SESSION['usuario'])){ header("Location: login.php"); exit(); } ?>
<!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8"><title>Relatório Ponto</title>
<style>
body{font-family:Arial;padding:30px;background:#f3f4f6} .topo{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px}
table{width:100%;border-collapse:collapse;background:white}
th,td{padding:10px;border:1px solid #ddd} th{background:#111827;color:white}
button{padding:12px 18px;border:none;background:#2563eb;color:white;border-radius:10px;cursor:pointer}
@media print{button{display:none}}
</style></head><body>
<div class="topo"><h1>Relatório de Ponto</h1><button onclick="window.print()">Gerar PDF</button></div>
<table id="tb"><thead><tr><th>Funcionário</th><th>Atraso</th><th>Hora Extra</th><th>Faltas</th><th>Descontos</th><th>Adicionais</th><th>Total a Pagar</th></tr></thead><tbody></tbody></table>
<script>
Promise.all([
fetch('api/funcionarios/listar.php').then(r=>r.json()),
fetch('api/ponto/listar.php').then(r=>r.json())
]).then(([funcs,pontos])=>{
 const tbody=document.querySelector('#tb tbody');
 funcs.forEach(f=>{
   const p=pontos.filter(x=>x.funcionario_id==f.id);
   let atraso=0,extra=0,faltas=0,descontos=0,adicionais=0;
   p.forEach(i=>{
     atraso += parseInt(i.atraso_minutos||0);
     extra += parseInt(i.hora_extra_minutos||0);
     descontos += parseFloat(i.valor_desconto||0);
     adicionais += parseFloat(i.valor_extra||0);
     if(i.falta==1) faltas++;
   });
   const total = parseFloat(f.salario||0)-descontos+adicionais;
   tbody.innerHTML += `<tr>
   <td>${f.nome}</td><td>${atraso} min</td><td>${extra} min</td><td>${faltas}</td>
   <td>R$ ${descontos.toFixed(2)}</td><td>R$ ${adicionais.toFixed(2)}</td><td>R$ ${total.toFixed(2)}</td>
   </tr>`;
 });
});
</script></body></html>