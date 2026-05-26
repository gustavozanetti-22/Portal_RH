const API_FUNCIONARIOS = "api/funcionarios/";
const API_FERIAS = "api/ferias/";

const tbody = document.getElementById("tbody-ferias");
const modal = document.getElementById("modal-ferias");
const form = document.getElementById("form-ferias");

let funcionariosCache = [];
let feriasCache = [];

function dataLocal(dataString) {
    if (!dataString) {
        return null;
    }

    const partes = dataString.split("-");

    return new Date(
        parseInt(partes[0]),
        parseInt(partes[1]) - 1,
        parseInt(partes[2])
    );
}

function dataISO(data) {
    if (!data) {
        return "";
    }

    const ano = data.getFullYear();
    const mes = String(data.getMonth() + 1).padStart(2, "0");
    const dia = String(data.getDate()).padStart(2, "0");

    return `${ano}-${mes}-${dia}`;
}

function formatarData(data) {
    if (!data) {
        return "-";
    }

    const partes = data.split("-");

    if (partes.length !== 3) {
        return data;
    }

    return `${partes[2]}/${partes[1]}/${partes[0]}`;
}

function calcularDiasTrabalhados(dataBase) {
    if (!dataBase) {
        return 0;
    }

    const inicio = dataLocal(dataBase);
    const hoje = new Date();

    if (inicio > hoje) {
        return 0;
    }

    const diferenca = hoje.getTime() - inicio.getTime();

    return Math.floor(
        diferenca / (1000 * 60 * 60 * 24)
    );
}

function verificarStatusFerias(dataSaida, retorno) {
    if (!dataSaida || !retorno) {
        return "Ativo";
    }

    const hoje = new Date();
    const inicio = dataLocal(dataSaida);
    const fim = dataLocal(retorno);

    if (hoje >= inicio && hoje <= fim) {
        return "Em férias";
    }

    return "Ativo";
}

async function carregarFerias() {
    try {
        const responseFuncionarios = await fetch(API_FUNCIONARIOS + "listar.php");
        funcionariosCache = await responseFuncionarios.json();

        const responseFerias = await fetch(API_FERIAS + "listar.php");
        feriasCache = await responseFerias.json();

        if (!Array.isArray(funcionariosCache)) {
            alert("Erro ao carregar funcionários.");
            console.log(funcionariosCache);
            return;
        }

        if (!Array.isArray(feriasCache)) {
            alert("Erro ao carregar férias.");
            console.log(feriasCache);
            return;
        }

        tbody.innerHTML = "";

        funcionariosCache.forEach(funcionario => {
            const registro = feriasCache.find(f =>
                f.funcionario_id == funcionario.id
            );

            const nuncaTirouFerias =
                registro?.nunca_tirou_ferias == 1;

            const baseContagem =
                nuncaTirouFerias
                    ? funcionario.data_admissao
                    : (
                        registro?.ultima_feria ||
                        funcionario.data_admissao
                    );

            const diasTrabalhados =
                calcularDiasTrabalhados(baseContagem);

            tbody.innerHTML += `
                <tr>
                    <td>${funcionario.nome}</td>

                    <td>${formatarData(funcionario.data_admissao)}</td>

                    <td>${formatarData(baseContagem)}</td>

                    <td>${diasTrabalhados}</td>

                    <td>
                        ${
                            nuncaTirouFerias
                            ? "Nunca tirou"
                            : formatarData(registro?.ultima_feria)
                        }
                    </td>

                    <td>${formatarData(registro?.proxima_feria)}</td>

                    <td>${formatarData(registro?.data_saida)}</td>

                    <td>${formatarData(registro?.retorno_ferias)}</td>

                    <td>
                        ${
                            registro?.vendeu_10_dias == 1
                            ? "Sim"
                            : "Não"
                        }
                    </td>

                    <td>
                        ${
                            registro?.ferias_pagas == 1
                            ? "Sim"
                            : "Não"
                        }
                    </td>

                    <td>
                        ${
                            verificarStatusFerias(
                                registro?.data_saida,
                                registro?.retorno_ferias
                            )
                        }
                    </td>

                    <td>
                        <button
                            class="btn-editar"
                            data-id="${funcionario.id}"
                        >
                            Editar
                        </button>
                    </td>
                </tr>
            `;
        });

        document.querySelectorAll(".btn-editar").forEach(botao => {
            botao.addEventListener("click", function () {
                const id = this.getAttribute("data-id");

                const funcionario = funcionariosCache.find(f =>
                    f.id == id
                );

                const registro = feriasCache.find(f =>
                    f.funcionario_id == id
                );

                abrirModal(funcionario, registro);
            });
        });

    } catch (error) {
        console.error(error);
        alert("Erro ao localizar a API de férias.");
    }
}

function abrirModal(funcionario, registro) {
    modal.style.display = "flex";

    document.getElementById("funcionario_id").value =
        funcionario.id;

    document.getElementById("data_admissao_funcionario").value =
        funcionario.data_admissao || "";

    const nuncaTirou =
        registro?.nunca_tirou_ferias == 1;

    document.getElementById("ja_tirou_ferias").value =
        nuncaTirou ? "0" : "1";

    document.getElementById("ultima_feria").value =
        nuncaTirou
            ? funcionario.data_admissao || ""
            : registro?.ultima_feria || "";

    document.getElementById("data_saida").value =
        registro?.data_saida || "";

    document.getElementById("vendeu_10_dias").value =
        registro?.vendeu_10_dias || 0;

    document.getElementById("ferias_pagas").value =
        registro?.ferias_pagas || 0;

    document.getElementById("observacoes").value =
        registro?.observacoes || "";

    controlarUltimaFerias();
}

function controlarUltimaFerias() {
    const jaTirou =
        document.getElementById("ja_tirou_ferias").value;

    const campoUltima =
        document.getElementById("ultima_feria");

    const dataAdmissao =
        document.getElementById("data_admissao_funcionario").value;

    if (jaTirou == "0") {
        campoUltima.value = dataAdmissao || "";
        campoUltima.disabled = true;
    } else {
        campoUltima.disabled = false;
    }
}

document
    .getElementById("ja_tirou_ferias")
    .addEventListener("change", controlarUltimaFerias);

function fecharModal() {
    modal.style.display = "none";
}

form.addEventListener("submit", async function (e) {
    e.preventDefault();

    try {
        const jaTirouFerias =
            document.getElementById("ja_tirou_ferias").value;

        const dataAdmissao =
            document.getElementById("data_admissao_funcionario").value;

        const ultimaFerias =
            jaTirouFerias == "0"
                ? dataAdmissao
                : document.getElementById("ultima_feria").value;

        const dataSaida =
            document.getElementById("data_saida").value;

        const vendeu10 =
            parseInt(document.getElementById("vendeu_10_dias").value);

        let retornoFerias = "";
        let proximaFerias = "";

        if (dataSaida) {
            const retorno = dataLocal(dataSaida);

            retorno.setDate(
                retorno.getDate() + (vendeu10 ? 20 : 30)
            );

            const proxima = dataLocal(dataSaida);

            proxima.setFullYear(
                proxima.getFullYear() + 1
            );

            retornoFerias = dataISO(retorno);
            proximaFerias = dataISO(proxima);
        }

        const dados = {
            funcionario_id: document.getElementById("funcionario_id").value,
            ultima_feria: ultimaFerias,
            proxima_feria: proximaFerias,
            data_saida: dataSaida,
            retorno_ferias: retornoFerias,
            vendeu_10_dias: vendeu10,
            ferias_pagas: document.getElementById("ferias_pagas").value,
            nunca_tirou_ferias: jaTirouFerias == "0" ? 1 : 0,
            observacoes: document.getElementById("observacoes").value
        };

        const response = await fetch(API_FERIAS + "salvar.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(dados)
        });

        const resultado = await response.json();

        if (!resultado.success) {
            alert(
                resultado.message +
                "\n" +
                (resultado.erro || "")
            );
            return;
        }

        alert("Férias salvas com sucesso!");

        fecharModal();
        carregarFerias();

    } catch (error) {
        console.error(error);
        alert("Erro ao salvar férias.");
    }
});

window.addEventListener("click", function (e) {
    if (e.target == modal) {
        fecharModal();
    }
});

carregarFerias();