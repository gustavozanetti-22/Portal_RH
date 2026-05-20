let funcionarios = JSON.parse(localStorage.getItem("funcionarios")) || [

    {
        id: 1,
        nome: "Gustavo Zanetti",
        cargo: "Desenvolvedor",
        salario: 5000,
        email: "gustavo@email.com"
    },

    {
        id: 2,
        nome: "Maria Silva",
        cargo: "RH",
        salario: 4200,
        email: "maria@email.com"
    }

];

function salvarLocalStorage(){

    localStorage.setItem(
        "funcionarios",
        JSON.stringify(funcionarios)
    );

}

function renderizarTabela(lista = funcionarios){

    const tabela = document.getElementById("tabelaFuncionarios");

    if(!tabela) return;

    tabela.innerHTML = "";

    lista.forEach(funcionario => {

        tabela.innerHTML += `

            <tr>

                <td>${funcionario.id}</td>

                <td>${funcionario.nome}</td>

                <td>${funcionario.cargo}</td>

                <td>
                    R$ ${funcionario.salario}
                </td>

                <td>${funcionario.email}</td>

                <td>

                    <button 
                        class="btn-editar"
                        onclick="editarFuncionario(${funcionario.id})"
                    >
                        Editar
                    </button>

                    <button 
                        class="btn-excluir"
                        onclick="excluirFuncionario(${funcionario.id})"
                    >
                        Excluir
                    </button>

                </td>

            </tr>

        `;

    });

    atualizarCards(lista);

}

function atualizarCards(lista){

    document.getElementById("totalFuncionarios").innerText = lista.length;

    const folha = lista.reduce(
        (total, funcionario) => total + Number(funcionario.salario),
        0
    );

    document.getElementById("folhaSalarial").innerText =
        "R$ " + folha.toLocaleString("pt-BR");

}

function filtrarFuncionarios(){

    const nome = document
    .getElementById("filtroNome")
    .value
    .toLowerCase();

    const cargo = document
    .getElementById("filtroCargo")
    .value
    .toLowerCase();

    const filtrados = funcionarios.filter(funcionario => {

        return (

            funcionario.nome
            .toLowerCase()
            .includes(nome)

            &&

            funcionario.cargo
            .toLowerCase()
            .includes(cargo)

        );

    });

    renderizarTabela(filtrados);

}

function abrirFormulario(){

    localStorage.removeItem("funcionarioEditando");

    window.location.href = "funcionario-formulario.php";

}

function editarFuncionario(id){

    localStorage.setItem(
        "funcionarioEditando",
        id
    );

    window.location.href = "funcionario-formulario.php";

}

function excluirFuncionario(id){

    funcionarios = funcionarios.filter(
        funcionario => funcionario.id !== id
    );

    salvarLocalStorage();

    renderizarTabela();

}

document.addEventListener("DOMContentLoaded", () => {

    renderizarTabela();

    const filtroNome = document.getElementById("filtroNome");

    const filtroCargo = document.getElementById("filtroCargo");

    if(filtroNome){

        filtroNome.addEventListener(
            "input",
            filtrarFuncionarios
        );

    }

    if(filtroCargo){

        filtroCargo.addEventListener(
            "input",
            filtrarFuncionarios
        );

    }

    const form = document.getElementById("formFuncionario");

    if(form){

        const idEditando = localStorage.getItem(
            "funcionarioEditando"
        );

        if(idEditando){

            const funcionario = funcionarios.find(
                f => f.id == idEditando
            );

            if(funcionario){

                document.getElementById("nome").value = funcionario.nome;

                document.getElementById("cargo").value = funcionario.cargo;

                document.getElementById("salario").value = funcionario.salario;

                document.getElementById("email").value = funcionario.email;

            }

        }

        form.addEventListener("submit", (e) => {

            e.preventDefault();

            const nome = document.getElementById("nome").value;

            const cargo = document.getElementById("cargo").value;

            const salario = document.getElementById("salario").value;

            const email = document.getElementById("email").value;

            if(idEditando){

                const index = funcionarios.findIndex(
                    f => f.id == idEditando
                );

                funcionarios[index] = {

                    ...funcionarios[index],

                    nome,
                    cargo,
                    salario,
                    email

                };

            }else{

                funcionarios.push({

                    id: funcionarios.length + 1,

                    nome,
                    cargo,
                    salario,
                    email

                });

            }

            salvarLocalStorage();

            window.location.href = "funcionarios.php";

        });

    }

});