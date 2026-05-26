const API = "api/funcionarios/";

const tbody =
document.getElementById(
    "tbody-funcionarios"
);

const form =
document.getElementById(
    "form-funcionario"
);

let editando = null;

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

async function carregarFuncionarios(){

    try{

        const response =
            await fetch(
                API + "listar.php"
            );

        const funcionarios =
            await response.json();

        console.log(
            "FUNCIONARIOS:",
            funcionarios
        );

        tbody.innerHTML = "";

        if(!Array.isArray(funcionarios)){

            alert(
                funcionarios.message +
                "\n" +
                (funcionarios.erro || "")
            );

            return;
        }

        funcionarios.forEach(
            funcionario => {

                const funcionarioJson =
                    JSON.stringify(funcionario)
                    .replace(/'/g, "&apos;");

                tbody.innerHTML += `

                    <tr>

                        <td>
                            ${funcionario.nome}
                        </td>

                        <td>
                            ${funcionario.cargo}
                        </td>

                        <td>
                            R$
                            ${parseFloat(
                                funcionario.salario
                            ).toFixed(2)}
                        </td>

                        <td>
                            ${funcionario.email}
                        </td>

                        <td>
                            ${
                                formatarData(
                                    funcionario.data_admissao
                                )
                            }
                        </td>

                        <td>
                            ${
                                funcionario.horario_entrada
                                || "-"
                            }
                        </td>

                        <td>
                            ${
                                funcionario.horario_saida
                                || "-"
                            }
                        </td>

                        <td>

                            <button
                                class="btn-editar"
                                onclick='editarFuncionario(
                                    ${funcionarioJson}
                                )'
                            >
                                Editar
                            </button>

                            <button
                                class="btn-excluir"
                                onclick="
                                    solicitarExclusao(
                                        ${funcionario.id},
                                        '${encodeURIComponent(funcionario.nome)}'
                                    )
                                "
                            >
                                Excluir
                            </button>

                        </td>

                    </tr>

                `;

            }
        );

    }catch(error){

        console.log(error);

        alert(
            "Erro ao carregar funcionários"
        );

    }

}

form.addEventListener(
    "submit",
    async function(e){

        e.preventDefault();

        const funcionario = {

            nome:
                document.getElementById(
                    "nome"
                ).value,

            cargo:
                document.getElementById(
                    "cargo"
                ).value,

            salario:
                document.getElementById(
                    "salario"
                ).value,

            email:
                document.getElementById(
                    "email"
                ).value,

            data_admissao:
                document.getElementById(
                    "data_admissao"
                ).value,

            horario_entrada:
                document.getElementById(
                    "horario_entrada"
                ).value,

            horario_saida:
                document.getElementById(
                    "horario_saida"
                ).value

        };

        if(editando){

            funcionario.id =
                editando;

        }

        const endpoint =
            editando
            ? "editar.php"
            : "criar.php";

        try{

            const response =
                await fetch(

                    API + endpoint,

                    {

                        method: "POST",

                        headers: {

                            "Content-Type":
                            "application/json"

                        },

                        body: JSON.stringify(
                            funcionario
                        )

                    }

                );

            const data =
                await response.json();

            console.log(
                "RESPOSTA API:",
                data
            );

            if(!data.success){

                alert(

                    data.message +
                    "\n" +
                    (data.erro || "")

                );

                return;
            }

            alert(
                data.message
                ||
                "Funcionário salvo com sucesso"
            );

            form.reset();

            editando = null;

            carregarFuncionarios();

        }catch(error){

            console.log(error);

            alert(
                "Erro ao conectar com a API"
            );

        }

    }
);

function editarFuncionario(
    funcionario
){

    editando =
        funcionario.id;

    document.getElementById(
        "nome"
    ).value =
        funcionario.nome;

    document.getElementById(
        "cargo"
    ).value =
        funcionario.cargo;

    document.getElementById(
        "salario"
    ).value =
        funcionario.salario;

    document.getElementById(
        "email"
    ).value =
        funcionario.email;

    document.getElementById(
        "data_admissao"
    ).value =
        funcionario.data_admissao
        || "";

    document.getElementById(
        "horario_entrada"
    ).value =
        funcionario.horario_entrada
        || "";

    document.getElementById(
        "horario_saida"
    ).value =
        funcionario.horario_saida
        || "";

    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });

}

function solicitarExclusao(id, nomeCodificado) {

    window.location.href =
        "excluir_funcionario.php?id=" +
        id +
        "&nome=" +
        nomeCodificado;

}

carregarFuncionarios();
