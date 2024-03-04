//pages mailing
$(document).ready(function(){
    // pra buscar a value do button tem que usar .variavel pra buscar o id tem que se usar #iddooponete
    $('.selectMailing').click(function(){
        let idMailing = $(this).attr('id_mailing');
        console.log(idMailing);
        $('#id_mailing').val(idMailing);
    });

});

//Esconder divs especificas do select follow-up
$(document).ready(function() {

    $('#select').on('change', function(){
        let selectValor = '#'+$(this).val();
        $('#follow').children('div').hide();
        $('#follow').children(selectValor).show();
    });
});

//DataTable list system
let jquery_datatable = $('#table').DataTable( {
    language: {
        url: 'https://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json'
    }
} );

//Buscar cidade de datatables
$(document).ready(function () {
    var typingTimerCode;
    var typingTimerName;
    var doneTypingInterval = 10000; // Tempo de pausa após a digitação (em milissegundos)

    function searchByCode() {
        var cityCode = $("#codigo_cidade").val();
        $.ajax({
            type: "GET",
            url: "../../app/Utils/Ajax/CodCity/city_search.php",
            data: { cityCode: cityCode },
            success: function (data) {
                var result = JSON.parse(data);
                $("#cidade").val(result.cidade);
                $("#estado").val(result.uf);
                $("#regiao").val(result.regiao);
                $("#cluster").val(result.cluster);
            },
            error: function () {
                $("#cidade").val("");
                $("#estado").val("");
                $("#regiao").val("");
                $("#cluster").val("");
            }
        });
    }

    function searchByName() {
        var searchQuery = $("#cidade").val();
        $.ajax({
            type: "GET",
            url: "../../app/Utils/Ajax/CodCity/city_search.php",
            data: { searchQuery: searchQuery },
            success: function (data) {
                var result = JSON.parse(data);
                $("#codigo_cidade").val(result.cod_cidade);
                $("#cidade").val(result.cidade);
                $("#estado").val(result.uf);
                $("#regiao").val(result.regiao);
                $("#cluster").val(result.cluster);
            },
            error: function () {
                $("#codigo_cidade").val("");
                $("#cidade").val("");
                $("#estado").val("");
                $("#regiao").val("");
                $("#cluster").val("");
            }
        });
    }

    $("#codigo_cidade").on('keyup', function () {
        clearTimeout(typingTimerCode);
        if ($("#codigo_cidade").val()) {
            typingTimerCode = setTimeout(searchByCode, doneTypingInterval);
        } else {
            $("#cidade").val("");
            $("#estado").val("");
            $("#regiao").val("");
            $("#cluster").val("");
        }
    });

    $("#cidade").on('keyup', function () {
        clearTimeout(typingTimerName);
        if ($("#cidade").val()) {
            typingTimerName = setTimeout(searchByName, doneTypingInterval);
        } else {
            $("#codigo_cidade").val("");
            $("#cidade").val("");
            $("#estado").val("");
            $("#regiao").val("");
            $("#cluster").val("");
        }
    });

    // Evento blur para o campo cityCode
    $("#codigo_cidade").on('blur', function () {
        searchByCode();
    });

    // Evento blur para o campo cidade
    $("#cidade").on('blur', function () {
        searchByName();
    });
});


//Switch to input filder CPF and Contract
document.addEventListener("DOMContentLoaded", function() {
    const buscarPorCpf = document.getElementById("buscarPorCpf");
    const buscarPorContrato = document.getElementById("buscarPorContrato");
    const campoBuscar = document.getElementById("campoBuscar");

    if(campoBuscar) { // Verifica se campoBuscar não é null
        const inputBuscar = campoBuscar.querySelector("input");

        buscarPorCpf.addEventListener("change", function() {
            if(this.checked) {
                campoBuscar.style.display = "block";
                inputBuscar.setAttribute("placeholder", "Digite o CPF ou CNPJ");
                inputBuscar.setAttribute("pattern", "\\d{11,15}");
                inputBuscar.setAttribute("maxlength", "15");
                inputBuscar.setAttribute("name", "cpfcnpj");
                document.querySelector('h6[for="buscar"]').textContent = "Buscar por CPF ou CNPJ:";
            }
        });

        buscarPorContrato.addEventListener("change", function() {
            if(this.checked) {
                campoBuscar.style.display = "block";
                inputBuscar.setAttribute("placeholder", "Digite o número do Contrato");
                inputBuscar.setAttribute("pattern", "\\d{1,9}");
                inputBuscar.setAttribute("maxlength", "9");
                inputBuscar.setAttribute("name", "contrato");
                document.querySelector('h6[for="buscar"]').textContent = "Buscar por Contrato:";
            }
        });
    }

    const buscarFinderCpf = document.getElementById("buscarFinderCpf");
    const buscarFinderCnpj = document.getElementById("buscarFinderCnpj");
    const campoBuscarFinder = document.getElementById("campoBuscarFinder");

    if(campoBuscarFinder) { // Verifica se campoBuscarFinder não é null
        const inputBuscarFinder = campoBuscarFinder.querySelector("input");

        buscarFinderCpf.addEventListener("change", function() {
            if(this.checked) {
                inputBuscarFinder.setAttribute("maxlength", "14"); // 11 dígitos + 3 caracteres de máscara (###.###.###-##)
                inputBuscarFinder.setAttribute("pattern", "\\d{3}\\.\\d{3}\\.\\d{3}-\\d{2}");
                inputBuscarFinder.setAttribute("name", "cpf");
                document.querySelector('h6[for="buscarFinder"]').textContent = "Buscar por CPF:";
                aplicaMascaraCpfCnpj(inputBuscarFinder, 'CPF');
            }
        });

        buscarFinderCnpj.addEventListener("change", function() {
            if(this.checked) {
                inputBuscarFinder.setAttribute("maxlength", "18"); // 14 dígitos + 4 caracteres de máscara (##.###.###/####-##)
                inputBuscarFinder.setAttribute("pattern", "\\d{2}\\.\\d{3}\\.\\d{3}/\\d{4}-\\d{2}");
                inputBuscarFinder.setAttribute("name", "cnpj");
                document.querySelector('h6[for="buscarFinder"]').textContent = "Buscar por CNPJ:";
                aplicaMascaraCpfCnpj(inputBuscarFinder, 'CNPJ');
            }
        });
    }
});

document.addEventListener("DOMContentLoaded", function() {
    const inputBuscarFinder = document.getElementById("campoBuscarFinder").querySelector("input");

    if(inputBuscarFinder) {
        inputBuscarFinder.addEventListener("input", function() {
            aplicaMascaraCpfCnpj(this);
        });
    }
});

function aplicaMascaraCpfCnpj(input) {
    let valor = input.value.replace(/\D/g, ''); // Remove tudo o que não é dígito
    if (valor.length <= 11) {
        // Aplica máscara de CPF
        valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
        valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
        valor = valor.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    } else {
        // Aplica máscara de CNPJ
        valor = valor.replace(/^(\d{2})(\d)/, '$1.$2');
        valor = valor.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
        valor = valor.replace(/\.(\d{3})(\d)/, '.$1/$2');
        valor = valor.replace(/(\d{4})(\d)/, '$1-$2');
    }
    input.value = valor;
}

/** get cities for state
(function(win,doc){
    'use strict';

    doc.querySelector('#estado').addEventListener('change',async(e)=>{
       let reqs = await fetch('../../app/Utils/Ajax/Class/CidadeController.php',{
           method:'post',
           headers:{
               'Content-Type':'application/x-www-form-urlencoded'
           },
           body:`estado=${e.target.value}`
       });
       let ress = await reqs.json();
       let selCidades = doc.querySelector('#cidade');
       selCidades.options.length = 1;
       ress.map((elem,ind,obj)=>{
           let opt = doc.createElement('option');
           opt.value = elem.id;
           opt.innerHTML = elem.nome;
           selCidades.appendChild(opt);
       });
       selCidades.removeAttribute('disabled');
    });
})(window,document);
**/