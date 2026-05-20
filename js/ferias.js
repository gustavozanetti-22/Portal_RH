const funcionarios = JSON.parse(
    localStorage.getItem("funcionarios")
) || [];

let ferias = JSON.parse(
    localStorage.getItem("ferias")
) || [];

function salvarFerias(){

    localStorage.setItem(
        "ferias",
        JSON.stringify(ferias)
    );

}

function formatarData(data){

    if(!data){

        return "Inicio na empresa";

    }

    return new Date(data)
    .toLocaleDateString("pt-BR");

}

function calcularDias(data){

    if(!data){

        return "Inicio na empresa";

    }

    const hoje = new Date();

    const ultima = new Date(data);

    const diferenca = hoje - ultima;

    const dias = Math.floor(
        diferenca / (1000 * 60 * 60 * 24)
    );

    return dias + " dias";

}

function calcularRetorno(data, vendeu){

    if(!data){

        return "-";

    }

    const retorno = new Date(data);

    retorno.setDate(

        retorno.getDate() +

        (
            vendeu === "Sim"
            ? 20
            : 30
        )

    );

    return retorno.toLocaleDateString("pt-BR");

}

function buscarFeriasFuncionario(id){

    return ferias.find(
        f => f.funcionarioId == id
    );

}

function renderizarTabela(){

    const tabela = document
    .getElementById("tabelaFerias");

    if(!tabela) return;

    tabela.innerHTML = "";

    funcionarios.forEach(funcionario => {

        const dadosFerias =
            buscarFeriasFuncionario(funcionario.id);

        tabela.innerHTML += `

            <tr>

                <td>
                    ${funcionario.nome}
                </td>

                <td>
                    ${
                        dadosFerias
                        ? formatarData(
                            dadosFerias.ultimaFerias
                        )
                        : "-"
                    }
                </td>

                <td>
                    ${
                        dadosFerias
                        ? calcularDias(
                            dadosFerias.ultimaFerias
                        )
                        : "-"
                    }
                </td>

                <td>
                    ${
                        dadosFerias
                        ? formatarData(
                            dadosFerias.saidaFerias
                        )
                        : "-"
                    }
                </td>

                <td>
                    ${
                        dadosFerias
                        ? calcularRetorno(
                            dadosFerias.saidaFerias,
                            dadosFerias.vendeuDias
                        )
                        : "-"
                    }
                </td>

                <td>
                    ${
                        dadosFerias
                        ? dadosFerias.vendeuDias
                        : "-"
                    }
                </td>

                <td>
                    ${
                        dadosFerias
                        ? dadosFerias.feriasPagas
                        : "-"
                    }
                </td>

                <td>

                    <button
                        class="btn-editar"
                        onclick="editarFerias(${funcionario.id})"
                    >
                        Editar
                    </button>

                </td>

            </tr>

        `;

    });

    atualizarCards();

}

function atualizarCards(){

    document.getElementById(
        "totalFuncionarios"
    ).innerText = funcionarios.length;

    document.getElementById(
        "emFerias"
    ).innerText = ferias.length;

    document.getElementById(
        "feriasPagas"
    ).innerText = ferias.filter(
        f => f.feriasPagas === "Sim"
    ).length;

}

function editarFerias(id){

    window.location.href =
        `ferias-formulario.php?id=${id}`;

}

function gerarRelatorio(){

    let conteudo = `
RELATÓRIO DE FÉRIAS

`;

    funcionarios.forEach(funcionario => {

        const dados =
            buscarFeriasFuncionario(funcionario.id);

        conteudo += `

Funcionário:
${funcionario.nome}

Últimas férias:
${dados ? formatarData(dados.ultimaFerias) : "Inicio na empresa"}

Saída:
${dados ? formatarData(dados.saidaFerias) : "-"}

Retorno:
${dados ? calcularRetorno(dados.saidaFerias, dados.vendeuDias) : "-"}

Vendeu 10 dias:
${dados ? dados.vendeuDias : "-"}

Férias pagas:
${dados ? dados.feriasPagas : "-"}

-----------------------------------

`;

    });

    const blob = new Blob(
        [conteudo],
        { type: "text/plain" }
    );

    const link =
        document.createElement("a");

    link.href =
        URL.createObjectURL(blob);

    link.download =
        "relatorio-ferias.txt";

    link.click();

}

document.addEventListener(
    "DOMContentLoaded",
    () => {

        renderizarTabela();

        const form =
            document.getElementById("formFerias");

        if(form){

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

            const dadosFerias =
                buscarFeriasFuncionario(id);

            if(funcionario){

                document.getElementById(
                    "funcionario"
                ).value =
                    funcionario.nome;

            }

            if(dadosFerias){

                document.getElementById(
                    "ultimaFerias"
                ).value =
                    dadosFerias.ultimaFerias;

                document.getElementById(
                    "saidaFerias"
                ).value =
                    dadosFerias.saidaFerias;

                document.getElementById(
                    "vendeuDias"
                ).value =
                    dadosFerias.vendeuDias;

                document.getElementById(
                    "feriasPagas"
                ).value =
                    dadosFerias.feriasPagas;

            }

            form.addEventListener(
                "submit",
                (e) => {

                    e.preventDefault();

                    const novaFerias = {

                        funcionarioId: id,

                        ultimaFerias:
                        document.getElementById(
                            "ultimaFerias"
                        ).value,

                        saidaFerias:
                        document.getElementById(
                            "saidaFerias"
                        ).value,

                        vendeuDias:
                        document.getElementById(
                            "vendeuDias"
                        ).value,

                        feriasPagas:
                        document.getElementById(
                            "feriasPagas"
                        ).value

                    };

                    const index =
                        ferias.findIndex(
                            f => f.funcionarioId == id
                        );

                    if(index >= 0){

                        ferias[index] =
                            novaFerias;

                    }else{

                        ferias.push(
                            novaFerias
                        );

                    }

                    salvarFerias();

                    window.location.href =
                        "ferias.php";

                }
            );

        }

    }
);