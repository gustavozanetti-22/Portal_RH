const API_FUNCIONARIOS =
"api/funcionarios/";

const API_FERIAS =
"api/ferias/";

const tbody =
document.getElementById(
    "tbody-ferias"
);

const modal =
document.getElementById(
    "modal-ferias"
);

const form =
document.getElementById(
    "form-ferias"
);

const selectAno =
document.getElementById(
    "ano-ferias"
);

const btnCarregarFerias =
document.getElementById(
    "btn-carregar-ferias"
);

btnCarregarFerias.addEventListener(
    "click",
    carregarFerias
);

function dataLocal(dataString){

    if(!dataString){
        return null;
    }

    const partes =
    dataString.split("-");

    return new Date(
        parseInt(partes[0]),
        parseInt(partes[1]) - 1,
        parseInt(partes[2])
    );

}

function formatarData(data){

    if(!data) return "-";

    const partes =
    data.split("-");

    if(partes.length !== 3){
        return data;
    }

    return `${partes[2]}/${partes[1]}/${partes[0]}`;

}

function calcularDiasTrabalhados(
    dataBase,
    anoReferencia
){

    if(!dataBase){
        return 0;
    }

    const inicio =
    dataLocal(dataBase);

    const hoje =
    new Date();

    let fim =
    new Date(
        parseInt(anoReferencia),
        11,
        31
    );

    if(
        hoje.getFullYear() ===
        parseInt(anoReferencia)
    ){
        fim = hoje;
    }

    if(inicio > fim){
        return 0;
    }

    const diferenca =
    fim.getTime() -
    inicio.getTime();

    return Math.floor(
        diferenca /
        (1000 * 60 * 60 * 24)
    );

}

function verificarStatusFerias(
    dataSaida,
    retorno
){

    if(!dataSaida || !retorno){

        return "Ativo";

    }

    const hoje =
    new Date();

    const inicio =
    dataLocal(dataSaida);

    const fim =
    dataLocal(retorno);

    if(
        hoje >= inicio &&
        hoje <= fim
    ){

        return "Em férias";

    }

    return "Ativo";

}

async function carregarFerias(){

    try{

        const anoReferencia =
        selectAno.value;

        const responseFuncionarios =
        await fetch(
            API_FUNCIONARIOS +
            "listar.php"
        );

        const funcionarios =
        await responseFuncionarios.json();

        const responseFerias =
        await fetch(
            API_FERIAS +
            "listar.php"
        );

        const ferias =
        await responseFerias.json();

        tbody.innerHTML = "";

        funcionarios.forEach(funcionario => {

            const registro =
            ferias.find(f =>
                f.funcionario_id ==
                funcionario.id
            );

            const jaTirouFerias =
            registro?.nunca_tirou_ferias == 1
            ? 0
            : 1;

            const baseContagem =
            jaTirouFerias == 0
            ? funcionario.data_admissao
            : (
                registro?.ultima_feria ||
                funcionario.data_admissao
            );

            const diasTrabalhados =
            calcularDiasTrabalhados(
                baseContagem,
                anoReferencia
            );

            const funcionarioJson =
            JSON.stringify(funcionario)
            .replace(/'/g, "&apos;");

            const registroJson =
            JSON.stringify(registro || null)
            .replace(/'/g, "&apos;");

            tbody.innerHTML += `

                <tr>

                    <td>
                        ${funcionario.nome}
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
                            formatarData(
                                baseContagem
                            )
                        }
                    </td>

                    <td>
                        ${diasTrabalhados}
                    </td>

                    <td>
                        ${
                            jaTirouFerias == 0
                            ? "Nunca tirou"
                            : (
                                formatarData(
                                    registro?.ultima_feria
                                )
                            )
                        }
                    </td>

                    <td>
                        ${
                            formatarData(
                                registro?.proxima_feria
                            )
                        }
                    </td>

                    <td>
                        ${
                            formatarData(
                                registro?.data_saida
                            )
                        }
                    </td>

                    <td>
                        ${
                            formatarData(
                                registro?.retorno_ferias
                            )
                        }
                    </td>

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
                            onclick='abrirModal(
                                ${funcionarioJson},
                                ${registroJson}
                            )'
                        >
                            Editar
                        </button>

                    </td>

                </tr>

            `;

        });

    }catch(error){

        console.error(error);

        alert(
            "Erro ao carregar férias."
        );

    }

}

function abrirModal(
    funcionario,
    registro
){

    modal.style.display =
    "flex";

    document.getElementById(
        "funcionario_id"
    ).value =
    funcionario.id;

    document.getElementById(
        "data_admissao_funcionario"
    ).value =
    funcionario.data_admissao || "";

    const nuncaTirou =
    registro?.nunca_tirou_ferias == 1;

    document.getElementById(
        "ja_tirou_ferias"
    ).value =
    nuncaTirou ? 0 : 1;

    document.getElementById(
        "ultima_feria"
    ).value =
    nuncaTirou
    ? funcionario.data_admissao || ""
    : registro?.ultima_feria || "";

    document.getElementById(
        "data_saida"
    ).value =
    registro?.data_saida || "";

    document.getElementById(
        "vendeu_10_dias"
    ).value =
    registro?.vendeu_10_dias || 0;

    document.getElementById(
        "ferias_pagas"
    ).value =
    registro?.ferias_pagas || 0;

    document.getElementById(
        "observacoes"
    ).value =
    registro?.observacoes || "";

    controlarUltimaFerias();

}

function controlarUltimaFerias(){

    const jaTirou =
    document.getElementById(
        "ja_tirou_ferias"
    ).value;

    const campoUltima =
    document.getElementById(
        "ultima_feria"
    );

    const dataAdmissao =
    document.getElementById(
        "data_admissao_funcionario"
    ).value;

    if(jaTirou == "0"){

        campoUltima.value =
        dataAdmissao || "";

        campoUltima.disabled =
        true;

    }else{

        campoUltima.disabled =
        false;

    }

}

document.getElementById(
    "ja_tirou_ferias"
).addEventListener(
    "change",
    controlarUltimaFerias
);

function fecharModal(){

    modal.style.display =
    "none";

}

form.addEventListener(
    "submit",
    async function(e){

        e.preventDefault();

        const jaTirouFerias =
        document.getElementById(
            "ja_tirou_ferias"
        ).value;

        const dataAdmissao =
        document.getElementById(
            "data_admissao_funcionario"
        ).value;

        const ultimaFerias =
        jaTirouFerias == "0"
        ? dataAdmissao
        : document.getElementById(
            "ultima_feria"
        ).value;

        const dataSaida =
        document.getElementById(
            "data_saida"
        ).value;

        const vendeu10 =
        parseInt(
            document.getElementById(
                "vendeu_10_dias"
            ).value
        );

        let retornoFerias = "";
        let proximaFerias = "";

        if(dataSaida){

            let retorno =
            dataLocal(dataSaida);

            retorno.setDate(
                retorno.getDate() +
                (vendeu10 ? 20 : 30)
            );

            const proxima =
            dataLocal(dataSaida);

            proxima.setFullYear(
                proxima.getFullYear() + 1
            );

            retornoFerias =
            retorno
            .toISOString()
            .split("T")[0];

            proximaFerias =
            proxima
            .toISOString()
            .split("T")[0];

        }

        const dados = {

            funcionario_id:
            document.getElementById(
                "funcionario_id"
            ).value,

            ultima_feria:
            ultimaFerias,

            proxima_feria:
            proximaFerias,

            data_saida:
            dataSaida,

            retorno_ferias:
            retornoFerias,

            vendeu_10_dias:
            vendeu10,

            ferias_pagas:
            document.getElementById(
                "ferias_pagas"
            ).value,

            nunca_tirou_ferias:
            jaTirouFerias == "0"
            ? 1
            : 0,

            observacoes:
            document.getElementById(
                "observacoes"
            ).value

        };

        const responseFerias =
        await fetch(
            API_FERIAS +
            "listar.php"
        );

        const lista =
        await responseFerias.json();

        const existe =
        lista.find(f =>
            f.funcionario_id ==
            dados.funcionario_id
        );

        const endpoint =
        existe
        ? "editar.php"
        : "salvar.php";

        const response =
        await fetch(

            API_FERIAS + endpoint,

            {

                method: "POST",

                headers: {

                    "Content-Type":
                    "application/json"

                },

                body: JSON.stringify(
                    dados
                )

            }

        );

        const resultado =
        await response.json();

        if(!resultado.success){

            alert(
                resultado.message +
                "\n" +
                (resultado.erro || "")
            );

            return;

        }

        alert(
            "Férias salvas com sucesso!"
        );

        fecharModal();

        carregarFerias();

    }
);

window.addEventListener(
    "click",
    function(e){

        if(e.target == modal){

            fecharModal();

        }

    }
);

carregarFerias();
