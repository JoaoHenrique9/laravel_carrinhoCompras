$("#cep").focusout(function(){cep=$(this).val(),cep=cep.replace("/-/",""),cep=cep.replace(/[.]/,""),$.ajax({url:"https://viacep.com.br/ws/"+cep+"/json/unicode/",dataType:"json",success:function(o){$("#logradouro").val(o.logradouro),$("#complemento").val(o.complemento),$("#bairro").val(o.bairro),$("#cidade").val(o.localidade),$("#uf").val(o.uf),$("#numero").focus()}})});
