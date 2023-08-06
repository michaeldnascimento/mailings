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
    var doneTypingInterval = 1000; // Tempo de pausa após a digitação (em milissegundos)

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
});


//get cities for state
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


//Switch to input filder CPF and Contract
document.addEventListener("DOMContentLoaded", function() {
    const buscarPorCpf = document.getElementById("buscarPorCpf");
    const buscarPorContrato = document.getElementById("buscarPorContrato");
    const campoBuscar = document.getElementById("campoBuscar");
    const inputBuscar = campoBuscar.querySelector("input");
  
    buscarPorCpf.addEventListener("change", function() {
      campoBuscar.style.display = "block";
      campoBuscar.querySelector("input").setAttribute("placeholder", "Digite o CPF");
      campoBuscar.querySelector("input").setAttribute("pattern", "\\d{15}"); // Adicionar pattern para aceitar somente 11 dígitos numéricos (CPF)
      campoBuscar.querySelector("input").setAttribute("maxlength", "15");
      campoBuscar.querySelector("input").setAttribute("name", "cpf"); // Definir o name do input como "cpf" para a submissão do formulário
      document.querySelector('h6[for="buscar"]').textContent = "Buscar por CPF:";
    });
  
    buscarPorContrato.addEventListener("change", function() {
      campoBuscar.style.display = "block";
      campoBuscar.querySelector("input").setAttribute("placeholder", "Digite o número do Contrato");
      campoBuscar.querySelector("input").setAttribute("pattern", "\\d{1,9}"); // Adicionar pattern para aceitar no máximo 9 dígitos numéricos (Contrato)
      campoBuscar.querySelector("input").setAttribute("maxlength", "9");
      campoBuscar.querySelector("input").setAttribute("name", "contrato"); // Definir o name do input como "contrato" para a submissão do formulário
      document.querySelector('h6[for="buscar"]').textContent = "Buscar por Contrato:";
    });
});