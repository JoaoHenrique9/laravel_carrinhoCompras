$("#cep").focusout(function() {
    cep = $(this).val()
    cep = cep.replace('/-/', "")
    cep = cep.replace(/[.]/, "")
    $.ajax({
        url: 'https://viacep.com.br/ws/' + cep + '/json/unicode/',
        dataType: 'json',
        success: function(resposta) {
            $("#logradouro").val(resposta.logradouro);
            $("#complemento").val(resposta.complemento);
            $("#bairro").val(resposta.bairro);
            $("#cidade").val(resposta.localidade);
            $("#uf").val(resposta.uf);
            $("#numero").focus();
        }
    });
});