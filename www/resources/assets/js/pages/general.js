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