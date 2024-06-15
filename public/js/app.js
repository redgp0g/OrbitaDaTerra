function habilitar() {
    if (document.getElementById("toggle").checked) {
        document.getElementById("btnCadastro").disabled = false;
    } else {
        document.getElementById("btnCadastro").disabled = true;
    }
}

$(".celular").on("input", function (e) {
    var x = e.target.value
        .replace(/\D/g, "")
        .match(/(\d{0,2})(\d{0,5})(\d{0,4})/);
    e.target.value = !x[2]
        ? x[1]
        : "(" + x[1] + ") " + x[2] + (x[3] ? "-" + x[3] : "");
});

$(".celular").on("change", function (e) {
    var pattern = /\(\d{2}\) \d{5}-\d{4}/;
    var isValid = pattern.test(e.target.value);

    if (!isValid) {
        alert(
            "Por favor, digite um número de celular válido no formato (12) 34567-8910."
        );
    }
});

$(".telefone").on("input", function (e) {
    var x = e.target.value
        .replace(/\D/g, "")
        .match(/(\d{0,2})(\d{0,4})(\d{0,4})/);
    e.target.value = !x[2]
        ? x[1]
        : "(" + x[1] + ") " + x[2] + (x[3] ? "-" + x[3] : "");
});

$(".telefone").on("change", function (e) {
    var pattern = /\(\d{2}\) \d{4}-\d{4}/;
    var isValid = pattern.test(e.target.value);

    if (!isValid) {
        alert(
            "Por favor, digite um número de celular válido no formato (01) 2345-6789."
        );
    }
});

function mascaraCEP(inputCep) {
    var cep = inputCep.value.replace(/\D/g, "");
    cep = cep.replace(/^(\d{5})(\d{3})/, "$1-$2");
    inputCep.value = cep;
}

function mascaraCPF(inputCpf) {
    var cpf = inputCpf.value
        .replace(/\D/g, "")
        .match(/(\d{0,3})(\d{0,3})(\d{0,3})(\d{0,2})/);
    inputCpf.value = !cpf[2]
        ? cpf[1]
        : cpf[1] +
          "." +
          cpf[2] +
          (cpf[3] ? "." + cpf[3] : "") +
          (cpf[4] ? "-" + cpf[4] : "");
}

function mascaraCNPJ(inputCnpj) {
    var cnpj = inputCnpj.value
        .replace(/\D/g, "")
        .match(/(\d{0,2})(\d{0,3})(\d{0,3})(\d{0,4})(\d{0,2})/);
    inputCnpj.value = !cnpj[2]
        ? cnpj[1]
        : cnpj[1] +
          "." +
          cnpj[2] +
          (cnpj[3] ? "." + cnpj[3] : "") +
          (cnpj[4] ? "/" + cnpj[4] : "") +
          (cnpj[5] ? "-" + cnpj[5] : "");
}

const getIPAddress = async () => {
    try {
        const response = await fetch("https://api.ipify.org");
        const data = await response.text();
        console.log(data);
    } catch (error) {
        console.error("Falhou ao pegar o IP:", error);
    }
};

getIPAddress();

function atualizarOptionsFiltroDataTable(
    filtro,
    table,
    optionSelecionado,
    posicaoColuna
) {
    filtro.empty();
    filtro.append('<option value="">Todas(os)</option>');

    var dados = table.column(posicaoColuna, { filter: "applied" }).data();

    var dadosUnicos = dados.unique().toArray();

    dadosUnicos.forEach(function (value) {
        var count = dados
            .filter(function (item) {
                return item === value;
            })
            .count();
        if (value == "") {
            filtro.append('<option value=" ">Nenhum(a)</option>');
        }
        if (value !== null && value !== "") {
            filtro.append(
                '<option value="' +
                    value +
                    '"' +
                    (optionSelecionado === value ? " selected" : "") +
                    ">" +
                    value +
                    " (" +
                    count +
                    ") </option>"
            );
        }
    });
}

$("#cep").focusout(function () {
    var cep = $("#cep").val();
    cep = cep.replace(/\D/g, "");
    var url = "https://api.brasilaberto.com/v1/zipcode/" + cep;

    fetch(url)
        .then((response) => response.json())
        .then((data) => {
            if (data && data.result) {
                $("#endereco").val(data.result.street);
                $("#bairro").val(data.result.district);
                $("#cidade").val(data.result.city);
                $("#estado").val(data.result.state);
            } else {
                console.error("Resposta da API sem dados válidos.");
            }
        })
        .catch((error) => {
            console.error("Erro na requisição:", error);
        });

    return false;
});
