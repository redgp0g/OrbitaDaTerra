function habilitar() {
    if (document.getElementById("toggle").checked) {
        document.getElementById("btnCadastro").disabled = false;
    } else {
        document.getElementById("btnCadastro").disabled = true;
    }
}

function mascaraCEP(inputCep) {
    let cep = inputCep.value.replace(/\D/g, "");
    cep = cep.replace(/^(\d{5})(\d{3})/, "$1-$2");
    inputCep.value = cep;
}

function mascaraCPF(inputCpf) {
    let cpf = inputCpf.value
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
    let cnpj = inputCnpj.value
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

function atualizarOptionsFiltroDataTable(
    filtro,
    table,
    optionSelecionado,
    posicaoColuna
) {
    filtro.empty();
    filtro.append('<option value="">Todas(os)</option>');

    let dados = table.column(posicaoColuna, {filter: "applied"}).data();

    let dadosUnicos = dados.unique().toArray();

    dadosUnicos.forEach(function (value) {
        let count = dados
            .filter(function (item) {
                return item === value;
            })
            .count();
        if (value === "") {
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

$("#CEP").focusout(function () {
    let cep = $(this).val();
    cep = cep.replace(/\D/g, "");
    let url = "https://viacep.com.br/ws/" + cep + "/json/";

    fetch(url)
        .then((response) => response.json())
        .then((data) => {
            $("#Endereco").val(data.logradouro);
            $("#Bairro").val(data.bairro);
            $("#Cidade").val(data.localidade);
            $("#Estado").val(data.estado);
        })
        .catch((error) => {
            console.error("Erro na requisição:", error);
        });

    return false;
});

function validarCPF(cpf) {
    let token = "5735|bXDX7IRtgcyFFLs4SMSX3BFGXBvseRWR";
    let apiUrl = "https://api.invertexto.com/v1/validator?type=cpf&token=" + token + "&value=" + cpf;

    $.get(apiUrl, function (data) {
        if (data.valid) {
            console.log("CPF válido");
        } else {
            console.log("CPF inválido");
            alert('CPF Inválido');
            $("#CPF").val("");
            $("#CPF").focus();
        }
    })
        .fail(function () {
            console.log("Erro ao chamar a API de validação do CPF");
        });
}

$("input[data-type='currency']").on({
    keyup: function () {
        formatCurrency($(this));
    },
    blur: function () {
        formatCurrency($(this), "blur");
    }
});


function formatNumber(n) {
    // format number 1000000 to 1,234,567
    return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".")
}


function formatCurrency(input, blur) {
    // appends $ to value, validates decimal side
    // and puts cursor back in right position.

    // get input value
    let input_val = input.val();

    // don't validate empty input
    if (input_val === "") {
        return;
    }

    // original length
    let original_len = input_val.length;

    // initial caret position
    let caret_pos = input.prop("selectionStart");

    // check for decimal
    if (input_val.indexOf(",") >= 0) {

        // get position of first decimal
        // this prevents multiple decimals from
        // being entered
        let decimal_pos = input_val.indexOf(",");

        // split number by decimal point
        let left_side = input_val.substring(0, decimal_pos);
        let right_side = input_val.substring(decimal_pos);

        // add commas to left side of number
        left_side = formatNumber(left_side);

        // validate right side
        right_side = formatNumber(right_side);

        // On blur make sure 2 numbers after decimal
        if (blur === "blur") {
            right_side += "00";
        }

        // Limit decimal to only 2 digits
        right_side = right_side.substring(0, 2);

        // join number by .
        input_val = "R$" + left_side + "," + right_side;

    } else {
        // no decimal entered
        // add commas to number
        // remove all non-digits
        input_val = formatNumber(input_val);
        input_val = "R$" + input_val;

        // final formatting
        if (blur === "blur") {
            input_val += ",00";
        }
    }

    // send updated string to input
    input.val(input_val);

    // put caret back in the right position
    let updated_len = input_val.length;
    caret_pos = updated_len - original_len + caret_pos;
    input[0].setSelectionRange(caret_pos, caret_pos);
}

