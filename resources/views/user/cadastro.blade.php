@extends('layouts.layout')
@section('title', 'Cadastro')
@section('content')


    <div class="container">
        <div class="row">

            <div class="col-sm-12 col-lg-9 card-login">
                @if (Session::has('mensagem-falha'))
                    <div class="alert alert-danger text-center p-3">
                        <strong>{{ Session::get('mensagem-falha') }}</strong>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        Cadastro
                    </div>
                    <div class="card-body">
                        <!--Formulário-->
                        <form action="{{ route('user.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <input id="name" name="name" type="text" class="form-control" value=""
                                            placeholder="Nome Completo" required="">
                                    </div>
                                    <div class="form-group">
                                        <input id="email" name="email" type="email" class="form-control" value=""
                                            placeholder="E-mail" required="">
                                    </div>
                                    <div class="form-group">
                                        <input id="password" name="password" type="password" class="form-control" value=""
                                            placeholder="Senha" required="">
                                    </div>
                                    <div class="form-group">
                                        <input id="cpf" name="cpf" type="text" class="form-control cpf-mask" value=""
                                            placeholder="CPF" required=""  onkeypress="$(this).mask('000.000.000-00');">
                                    </div>
                                    <div class="form-group">
                                        <select id="uf" name="estado" class="form-control">
                                            <option value="">Estado</option>
                                            <option value="AC">Acre</option>
                                            <option value="AL">Alagoas</option>
                                            <option value="AP">Amapá</option>
                                            <option value="AM">Amazonas</option>
                                            <option value="BA">Bahia</option>
                                            <option value="CE">Ceará</option>
                                            <option value="DF">Distrito Federal</option>
                                            <option value="ES">Espírito Santo</option>
                                            <option value="GO">Goiás</option>
                                            <option value="MA">Maranhão</option>
                                            <option value="MT">Mato Grosso</option>
                                            <option value="MS">Mato Grosso do Sul</option>
                                            <option value="MG">Minas Gerais</option>
                                            <option value="PA">Pará</option>
                                            <option value="PB">Paraíba</option>
                                            <option value="PR">Paraná</option>
                                            <option value="PE">Pernambuco</option>
                                            <option value="PI">Piauí</option>
                                            <option value="RJ">Rio de Janeiro</option>
                                            <option value="RN">Rio Grande do Norte</option>
                                            <option value="RS">Rio Grande do Sul</option>
                                            <option value="RO">Rondônia</option>
                                            <option value="RR">Roraima</option>
                                            <option value="SC">Santa Catarina</option>
                                            <option value="SP">São Paulo</option>
                                            <option value="SE">Sergipe</option>
                                            <option value="TO">Tocantins</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-6">

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input id="cep" type="text" name="cep" class="form-control" value=""
                                                    placeholder="CEP" onkeypress=" $(this).mask('00.000-000')" required="">
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <input id="numero" type="text" name="numero" class="form-control" value=""
                                                    placeholder="Numero" required="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input id="logradouro" type="text" name="logradouro" class="form-control" value=""
                                            placeholder="Logradouro" required="">
                                    </div>


                                    <div class="form-group">
                                        <input id="complemento" type="text" name="complemento" class="form-control" value=""
                                            placeholder="Complemento">
                                    </div>
                                    <div class="form-group">
                                        <input id="bairro" type="text" name="bairro" class="form-control" value=""
                                            placeholder="Bairro" required="">
                                    </div>
                                    <div class="form-group">
                                        <input id="cidade" type="text" name="cidade" class="form-control" value=""
                                            placeholder="cidade" required="">
                                    </div>
                                </div>



                            </div>
                            <button class="btn btn-lg btn-info btn-block" type="submit">Entrar</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
