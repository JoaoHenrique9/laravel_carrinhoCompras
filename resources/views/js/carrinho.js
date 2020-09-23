function carrinhoRemoverProduto(idOrder, idproduct, item) {
    $('#form-remover-product input[name="order_id"]').val(idOrder);
    $('#form-remover-product input[name="product_id"]').val(idproduct);
    $('#form-remover-product input[name="item"]').val(item);
    $('#form-remover-product').submit();
}

function carrinhoAdicionarProduto(idproduct) {
    $('#form-adicionar-product input[name="id"]').val(idproduct);
    $('#form-adicionar-product').submit();
}