//DataTable list system
$(document).ready(function() {
    $('#table').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'colvis'
        ]
    } );
} );


//pages mailing
$(document).ready(function(){
    // pra buscar a value do button tem que usar .variavel pra buscar o id tem que se usar #iddooponete
    $('.selectMailing').click(function(){
        let idMailing = $(this).attr('id_mailing');
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