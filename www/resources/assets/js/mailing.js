$(document).ready(function(){
    // pra buscar a value do button tem que usar .variavel pra buscar o id tem que se usar #iddooponete
    $('.selectMailing').click(function(){
        let idMailing = $(this).attr('id_mailing');

        $('#id_mailing').val(idMailing);
    });

    // pra buscar a value do button tem que usar .variavel pra buscar o id tem que se usar #iddooponete
    $('.enriquecerMailing').click(function(){
        let cpfMailing = $(this).attr('cpf_mailing');

        $('#cpf_mailing').val(cpfMailing);
    });

});

