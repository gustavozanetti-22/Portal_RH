const funcionarios = JSON.parse(
    localStorage.getItem("funcionarios")
) || [];

let beneficios = JSON.parse(
    localStorage.getItem("beneficios")
) || [];

function salvarBeneficios(){

    localStorage.setItem(
        "beneficios",
        JSON.stringify(beneficios)
    );

}

function buscarBeneficioFuncionario(id){

    return beneficios.find(
        b => b.funcionarioId == id
    );

}

function renderizarTabela(lista = funcionarios){

    const tabela = document.getElementById(
        "tabelaBeneficios"
    );

    if(!tabela) return;

    tabela.innerHTML = "";

    lista.forEach(funcionario => {

        const dados =
            buscarBeneficioFuncionario(
                funcionario.id
            );

        tabela.innerHTML += `

            <tr>

                <td>
                    ${funcionario.nome}
                </td>

                <td>
                    ${
                        dados
                        ? dados.convenio
                        : "-"
                    }
                </td>

                <td>
                    ${
                        dados
                        ? dados.valeTransporte
                        : "-"
                    }
                </td>

                <td>
                    ${
                        dados
                        ? dados.valeRefeicao
                        : "-"
                    }
                </td>

                <td>
                    ${
                        dados
                        ? dados.odontologico
                        : "-"
                    }
                </td>

                <td>

                    <button
                        class="btn-editar"
                        onclick="editarBeneficios(${funcionario.id})"
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
    ).innerText =
        funcionarios.length;

    document.getElementById(
        "totalConvenio"
    ).innerText =
        beneficios.filter(
            b => b.convenio === "Sim"
        ).length;

    document.getElementById(
        "totalVT"
    ).innerText =
        beneficios.filter(
            b => b.valeTransporte === "Sim"
        ).length;

}

function editarBeneficios(id){

    window.location.href =
        `beneficios-formulario.php?id=${id}`;

}

function filtrarFuncionarios(){

    const nome = document
    .getElementById("filtroNome")
    .value
    .toLowerCase();

    const convenio = document
    .getElementById("filtroConvenio")
    .value;

    const filtrados =
        funcionarios.filter(funcionario => {

            const dados =
                buscarBeneficioFuncionario(
                    funcionario.id
                );

            const nomeOk =
                funcionario.nome
                .toLowerCase()
                .includes(nome);

            const convenioOk =
                convenio === ""
                ||
                (
                    dados
                    &&
                    dados.convenio === convenio
                );

            return nomeOk && convenioOk;

        });

    renderizarTabela(filtrados);

}

function gerarRelatorioPDF(){

    let conteudo = `
RELATÓRIO DE BENEFÍCIOS

`;

    funcionarios.forEach(funcionario => {

        const dados =
            buscarBeneficioFuncionario(
                funcionario.id
            );

        conteudo += `

Funcionário:
${funcionario.nome}

Convênio:
${dados ? dados.convenio : "-"}

Vale Transporte:
${dados ? dados.valeTransporte : "-"}

Vale Refeição:
${dados ? dados.valeRefeicao : "-"}

Plano Odontológico:
${dados ? dados.odontologico : "-"}

-----------------------------------

`;

    });

    const blob = new Blob(
        [conteudo],
        { type: "application/pdf" }
    );

    const link =
        document.createElement("a");

    link.href =
        URL.createObjectURL(blob);

    link.download =
        "relatorio-beneficios.pdf";

    link.click();

}

document.addEventListener(
    "DOMContentLoaded",
    () => {

        renderizarTabela();

        const filtroNome =
            document.getElementById(
                "filtroNome"
            );

        const filtroConvenio =
            document.getElementById(
                "filtroConvenio"
            );

        if(filtroNome){

            filtroNome.addEventListener(
                "input",
                filtrarFuncionarios
            );

        }

        if(filtroConvenio){

            filtroConvenio.addEventListener(
                "change",
                filtrarFuncionarios
            );

        }

        const form =
            document.getElementById(
                "formBeneficios"
            );

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

            const dados =
                buscarBeneficioFuncionario(id);

            if(funcionario){

                document.getElementById(
                    "funcionario"
                ).value =
                    funcionario.nome;

            }

            if(dados){

                document.getElementById(
                    "convenio"
                ).value =
                    dados.convenio;

                document.getElementById(
                    "valeTransporte"
                ).value =
                    dados.valeTransporte;

                document.getElementById(
                    "valeRefeicao"
                ).value =
                    dados.valeRefeicao;

                document.getElementById(
                    "odontologico"
                ).value =
                    dados.odontologico;

            }

            form.addEventListener(
                "submit",
                (e) => {

                    e.preventDefault();

                    const novoBeneficio = {

                        funcionarioId: id,

                        convenio:
                        document.getElementById(
                            "convenio"
                        ).value,

                        valeTransporte:
                        document.getElementById(
                            "valeTransporte"
                        ).value,

                        valeRefeicao:
                        document.getElementById(
                            "valeRefeicao"
                        ).value,

                        odontologico:
                        document.getElementById(
                            "odontologico"
                        ).value

                    };

                    const index =
                        beneficios.findIndex(
                            b => b.funcionarioId == id
                        );

                    if(index >= 0){

                        beneficios[index] =
                            novoBeneficio;

                    }else{

                        beneficios.push(
                            novoBeneficio
                        );

                    }

                    salvarBeneficios();

                    window.location.href =
                        "beneficios.php";

                }
            );

        }

    }
);