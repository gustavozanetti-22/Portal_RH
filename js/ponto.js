const funcionarios = JSON.parse(
    localStorage.getItem("funcionarios")
) || [];

let pontos = JSON.parse(
    localStorage.getItem("pontos")
) || [];

/*
========================================
FERIADOS SP
========================================
*/

const feriadosSP = [

    "2026-01-01",
    "2026-01-25",
    "2026-02-16",
    "2026-02-17",
    "2026-04-03",
    "2026-04-21",
    "2026-05-01",
    "2026-06-04",
    "2026-07-09",
    "2026-09-07",
    "2026-10-12",
    "2026-11-02",
    "2026-11-15",
    "2026-12-25"

];

/*
========================================
SELECIONAR MÊS
========================================
*/

function selecionarMes(){

    const mes =
        document.getElementById(
            "mesSelecionado"
        ).value;

    if(!mes){

        alert("Selecione um mês");

        return;

    }

    localStorage.setItem(
        "mesPonto",
        mes
    );

    document.getElementById(
        "modalMes"
    ).style.display = "none";

    carregarTabela();

}

/*
========================================
CÁLCULOS
========================================
*/

function calcularValorHora(salario){

    return salario / 220;

}

function calcularValorMinuto(salario){

    return calcularValorHora(salario) / 60;

}

function calcularDesconto(minutos, salario){

    if(minutos <= 10){

        return 0;

    }

    const minutosDesconto =
        minutos - 10;

    return (
        calcularValorMinuto(salario)
        *
        minutosDesconto
    );

}

function calcularExtra(minutos, salario){

    return (
        calcularValorMinuto(salario)
        *
        minutos
    );

}

/*
========================================
UTILS
========================================
*/

function converterHorarioMinutos(horario){

    const [hora, minuto] =
        horario.split(":");

    return (
        Number(hora) * 60
        +
        Number(minuto)
    );

}

/*
========================================
BUSCAR REGISTROS
========================================
*/

function buscarPontosFuncionario(id){

    return pontos.filter(
        p => p.funcionarioId == id
    );

}

/*
========================================
TELA PRINCIPAL
========================================
*/

function carregarTabela(){

    const tabela =
        document.getElementById(
            "tabelaFuncionarios"
        );

    if(!tabela) return;

    tabela.innerHTML = "";

    let folhaTotal = 0;
    let atrasosTotal = 0;
    let extrasTotal = 0;

    funcionarios.forEach(funcionario => {

        const registros =
            buscarPontosFuncionario(
                funcionario.id
            );

        let totalDesconto = 0;
        let totalExtra = 0;
        let minutosAtraso = 0;
        let minutosExtra = 0;

        registros.forEach(registro => {

            totalDesconto +=
                Number(registro.desconto || 0);

            totalExtra +=
                Number(registro.extraValor || 0);

            minutosAtraso +=
                Number(registro.atraso || 0);

            minutosExtra +=
                Number(registro.extra || 0);

        });

        const totalReceber =
            Number(funcionario.salario)
            -
            totalDesconto
            +
            totalExtra;

        folhaTotal += totalReceber;

        atrasosTotal += minutosAtraso;

        extrasTotal += minutosExtra;

        tabela.innerHTML += `

            <tr>

                <td>
                    ${funcionario.nome}
                </td>

                <td>
                    ${funcionario.cargo}
                </td>

                <td>
                    R$ ${Number(funcionario.salario).toFixed(2)}
                </td>

                <td>
                    R$ ${totalReceber.toFixed(2)}
                </td>

                <td>
                    ${minutosAtraso} min
                </td>

                <td>
                    ${minutosExtra} min
                </td>

                <td>

                    <button
                        class="btn-ponto"
                        onclick="abrirPonto(${funcionario.id})"
                    >

                        Fazer ponto

                    </button>

                </td>

            </tr>

        `;

    });

    document.getElementById(
        "totalFolha"
    ).innerText =
        "R$ " + folhaTotal.toFixed(2);

    document.getElementById(
        "totalAtrasos"
    ).innerText =
        atrasosTotal + " min";

    document.getElementById(
        "horasExtras"
    ).innerText =
        extrasTotal + " min";

}

/*
========================================
ABRIR PONTO
========================================
*/

function abrirPonto(id){

    window.location.href =
        `ponto-funcionario.php?id=${id}`;

}

function voltarPonto(){

    window.location.href =
        "ponto.php";

}

/*
========================================
GERAR DIAS FUNCIONÁRIO
========================================
*/

function gerarDiasFuncionario(){

    const tabela =
        document.getElementById(
            "tabelaDias"
        );

    if(!tabela) return;

    tabela.innerHTML = "";

    const params =
        new URLSearchParams(
            window.location.search
        );

    const id =
        params.get("id");

    const funcionario =
        funcionarios.find(
            f => f.id == id
        );

    if(!funcionario) return;

    document.getElementById(
        "nomeFuncionario"
    ).innerText =
        funcionario.nome;

    document.getElementById(
        "cargoFuncionario"
    ).innerText =
        funcionario.cargo;

    /*
    ========================================
    CARREGA HORÁRIO PADRÃO SALVO
    ========================================
    */

    if(funcionario.horarioEntrada){

        document.getElementById(
            "entradaPadrao"
        ).value =
            funcionario.horarioEntrada;

    }

    if(funcionario.horarioSaida){

        document.getElementById(
            "saidaPadrao"
        ).value =
            funcionario.horarioSaida;

    }

    const mesSelecionado =
        localStorage.getItem(
            "mesPonto"
        );

    if(!mesSelecionado) return;

    const [ano, mes] =
        mesSelecionado.split("-");

    const diasMes =
        new Date(
            Number(ano),
            Number(mes),
            0
        ).getDate();

    for(let dia = 1; dia <= diasMes; dia++){

        const dataCompleta =
            `${ano}-${mes}-${String(dia).padStart(2, "0")}`;

        const data =
            new Date(
                Number(ano),
                Number(mes) - 1,
                dia
            );

        const diaSemana =
            data.getDay();

        const fimSemana =
            diaSemana === 0
            ||
            diaSemana === 6;

        const feriado =
            feriadosSP.includes(
                dataCompleta
            );

        if(fimSemana || feriado){

            tabela.innerHTML += `

                <tr class="folga">

                    <td>
                        ${data.toLocaleDateString("pt-BR")}
                    </td>

                    <td colspan="6">

                        Folga

                    </td>

                </tr>

            `;

            continue;

        }

        tabela.innerHTML += `

            <tr>

                <td>
                    ${data.toLocaleDateString("pt-BR")}
                </td>

                <td>

                    <input
                        type="time"
                        class="input-hora entrada"
                        data-dia="${dia}"
                    >

                </td>

                <td>

                    <input
                        type="time"
                        class="input-hora saida"
                        data-dia="${dia}"
                    >

                </td>

                <td>

                    <input
                        type="checkbox"
                        class="falta-check"
                        id="falta-${dia}"
                    >

                </td>

                <td id="atraso-${dia}">
                    0 min
                </td>

                <td id="extra-${dia}">
                    0 min
                </td>

                <td id="status-${dia}">
                    -
                </td>

            </tr>

        `;

    }

    carregarDadosSalvos();

}

/*
========================================
APLICAR HORÁRIO PADRÃO
========================================
*/

function aplicarHorarioPadrao(){

    const entrada =
        document.getElementById(
            "entradaPadrao"
        ).value;

    const saida =
        document.getElementById(
            "saidaPadrao"
        ).value;

    if(!entrada || !saida){

        alert(
            "Preencha entrada e saída"
        );

        return;

    }

    document
    .querySelectorAll(".entrada")
    .forEach(input => {

        input.value = entrada;

    });

    document
    .querySelectorAll(".saida")
    .forEach(input => {

        input.value = saida;

    });

    alert(
        "Horário aplicado em todos os dias!"
    );

}

/*
========================================
SALVAR TUDO
========================================
*/

function salvarTudo(){

    const params =
        new URLSearchParams(
            window.location.search
        );

    const id =
        params.get("id");

    const funcionario =
        funcionarios.find(
            f => f.id == id
        );

    const entradaPadrao =
        document.getElementById(
            "entradaPadrao"
        ).value;

    const saidaPadrao =
        document.getElementById(
            "saidaPadrao"
        ).value;

    funcionario.horarioEntrada =
        entradaPadrao;

    funcionario.horarioSaida =
        saidaPadrao;

    localStorage.setItem(
        "funcionarios",
        JSON.stringify(funcionarios)
    );

    const mesSelecionado =
        localStorage.getItem(
            "mesPonto"
        );

    const [ano, mes] =
        mesSelecionado.split("-");

    const diasMes =
        new Date(
            Number(ano),
            Number(mes),
            0
        ).getDate();

    pontos = pontos.filter(p => {

        if(
            p.funcionarioId != id
        ){

            return true;

        }

        return !p.data.startsWith(
            `${ano}-${mes}`
        );

    });

    let totalFaltas = 0;
    let totalAtraso = 0;
    let totalExtra = 0;
    let totalDesconto = 0;
    let totalValorExtra = 0;

    for(let dia = 1; dia <= diasMes; dia++){

        const entradaInput =
            document.querySelector(
                `.entrada[data-dia="${dia}"]`
            );

        if(!entradaInput){

            continue;

        }

        const saidaInput =
            document.querySelector(
                `.saida[data-dia="${dia}"]`
            );

        const falta =
            document.getElementById(
                `falta-${dia}`
            ).checked;

        const entrada =
            entradaInput.value;

        const saida =
            saidaInput.value;

        const dataCompleta =
            `${ano}-${mes}-${String(dia).padStart(2, "0")}`;

        /*
        ========================================
        FALTA
        ========================================
        */

        if(falta){

            totalFaltas++;

            const descontoFalta =
                calcularValorHora(
                    Number(funcionario.salario)
                ) * 8;

            totalDesconto +=
                descontoFalta;

            pontos.push({

                funcionarioId: id,

                data: dataCompleta,

                falta: true,

                atraso: 0,

                extra: 0,

                desconto:
                    descontoFalta.toFixed(2),

                extraValor: 0

            });

            document.getElementById(
                `status-${dia}`
            ).innerHTML = `

                <span class="status-falta">

                    Falta registrada

                </span>

            `;

            continue;

        }

        if(!entrada || !saida){

            continue;

        }

        const entradaMin =
            converterHorarioMinutos(
                entrada
            );

        const saidaMin =
            converterHorarioMinutos(
                saida
            );

        const inicioMin =
            converterHorarioMinutos(
                entradaPadrao
            );

        const fimMin =
            converterHorarioMinutos(
                saidaPadrao
            );

        let atraso = 0;

        if(entradaMin > inicioMin){

            atraso =
                entradaMin - inicioMin;

        }

        let extra = 0;

        if(saidaMin > fimMin){

            extra =
                saidaMin - fimMin;

        }

        const desconto =
            calcularDesconto(
                atraso,
                Number(funcionario.salario)
            );

        const extraValor =
            calcularExtra(
                extra,
                Number(funcionario.salario)
            );

        totalAtraso += atraso;

        totalExtra += extra;

        totalDesconto += desconto;

        totalValorExtra += extraValor;

        pontos.push({

            funcionarioId: id,

            data: dataCompleta,

            entrada,
            saida,

            falta: false,

            atraso,
            extra,

            desconto:
                desconto.toFixed(2),

            extraValor:
                extraValor.toFixed(2)

        });

        document.getElementById(
            `status-${dia}`
        ).innerHTML = `

            <span class="status-ok">

                ✔ Salvo

            </span>

        `;

        document.getElementById(
            `atraso-${dia}`
        ).innerText =
            atraso + " min";

        document.getElementById(
            `extra-${dia}`
        ).innerText =
            extra + " min";

    }

    localStorage.setItem(
        "pontos",
        JSON.stringify(pontos)
    );

    document.getElementById(
        "totalFaltas"
    ).innerText =
        totalFaltas;

    document.getElementById(
        "tempoAtraso"
    ).innerText =
        totalAtraso + " min";

    document.getElementById(
        "tempoExtra"
    ).innerText =
        totalExtra + " min";

    document.getElementById(
        "valorDesconto"
    ).innerText =
        "R$ " + totalDesconto.toFixed(2);

    document.getElementById(
        "valorExtra"
    ).innerText =
        "R$ " + totalValorExtra.toFixed(2);

    alert(
        "Pontos salvos com sucesso!"
    );

}

/*
========================================
CARREGAR DADOS SALVOS
========================================
*/

function carregarDadosSalvos(){

    const params =
        new URLSearchParams(
            window.location.search
        );

    const id =
        params.get("id");

    const registros =
        buscarPontosFuncionario(id);

    registros.forEach(registro => {

        const dia =
            Number(
                registro.data.split("-")[2]
            );

        const entradaInput =
            document.querySelector(
                `.entrada[data-dia="${dia}"]`
            );

        const saidaInput =
            document.querySelector(
                `.saida[data-dia="${dia}"]`
            );

        if(entradaInput){

            entradaInput.value =
                registro.entrada || "";

        }

        if(saidaInput){

            saidaInput.value =
                registro.saida || "";

        }

        const faltaInput =
            document.getElementById(
                `falta-${dia}`
            );

        if(faltaInput){

            faltaInput.checked =
                registro.falta || false;

        }

        if(
            document.getElementById(
                `atraso-${dia}`
            )
        ){

            document.getElementById(
                `atraso-${dia}`
            ).innerText =
                registro.atraso + " min";

        }

        if(
            document.getElementById(
                `extra-${dia}`
            )
        ){

            document.getElementById(
                `extra-${dia}`
            ).innerText =
                registro.extra + " min";

        }

        if(
            document.getElementById(
                `status-${dia}`
            )
        ){

            document.getElementById(
                `status-${dia}`
            ).innerHTML = `

                <span class="status-ok">

                    ✔ Carregado

                </span>

            `;

        }

    });

}

/*
========================================
RELATÓRIO
========================================
*/

function gerarRelatorio(){

    let texto = `
RELATÓRIO DE PONTO

`;

    funcionarios.forEach(funcionario => {

        texto += `

========================================
FUNCIONÁRIO:
${funcionario.nome}
========================================

`;

        const registros =
            buscarPontosFuncionario(
                funcionario.id
            );

        registros.forEach(registro => {

            texto += `

Data:
${registro.data}

Entrada:
${registro.entrada || "-"}

Saída:
${registro.saida || "-"}

Falta:
${registro.falta ? "SIM" : "NÃO"}

Atraso:
${registro.atraso} min

Hora Extra:
${registro.extra} min

Desconto:
R$ ${registro.desconto}

Extra:
R$ ${registro.extraValor}

----------------------------------------

`;

        });

    });

    const blob = new Blob(
        [texto],
        {
            type: "text/plain"
        }
    );

    const link =
        document.createElement("a");

    link.href =
        URL.createObjectURL(blob);

    link.download =
        "relatorio-ponto.txt";

    link.click();

}

/*
========================================
LOAD
========================================
*/

document.addEventListener(
    "DOMContentLoaded",
    () => {

        carregarTabela();

        gerarDiasFuncionario();

        const modal =
            document.getElementById(
                "modalMes"
            );

        if(
            localStorage.getItem(
                "mesPonto"
            )
        ){

            if(modal){

                modal.style.display =
                    "none";

            }

        }

    }
);