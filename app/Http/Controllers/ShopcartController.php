<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderItem;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopcartController extends Controller
{
    function __construct()
    {
        // obriga estar logado;
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where([
            'status'  => 'RE',
            'user_id' => Auth::id()
        ])->get();
        return view('shopcart.index', ['orders' => $orders]);
    }



    public function add()
    {

        $this->middleware('VerifyCsrfToken');

        $req = Request();
        $product_id = $req->input('id');

        $product = Product::find($product_id);
        if (empty($product->id)) {
            $req->session()->flash('mensagem-falha', 'Produto não encontrado em nossa loja!');
            return redirect()->route('shopcart.index');
        }

        $user_id = Auth::id();

        $order_id = Order::consultaId([
            'user_id' => $user_id,
            'status'  => 'RE' //R eservada
        ]);

        if (empty($order_id)) {
            $order_new = Order::create([
                'user_id' => $user_id,
                'status' => 'RE'
            ]);

            $order_id = $order_new->id;
        }

        OrderItem::create([
            'order_id' => $order_id,
            'product_id' => $product_id,
            'valor' => $product->valor,
            'status' => 'RE'
        ]);

        $req->session()->flash('mensagem-sucesso', 'Produto adicionado ao carrinho com sucesso!');

        return redirect()->route('shopcart.index');
    }

    public function remover()
    {

        $this->middleware('VerifyCsrfToken');

        $req = Request();
        $order_id           = $req->input('order_id');
        $product_id          = $req->input('product_id');
        $remove_apenas_item = (bool)$req->input('item');
        $user_id          = Auth::id();

        $order_id = Order::consultaId([
            'id'      => $order_id,
            'user_id' => $user_id,
            'status'  => 'RE' // Reservada
        ]);

        if (empty($order_id)) {
            $req->session()->flash('mensagem-falha', 'Pedido não encontrado!');
            return redirect()->route('shopcart.index');
        }

        $where_product = [
            'order_id'  => $order_id,
            'product_id' => $product_id
        ];

        $product = OrderItem::where($where_product)->orderBy('id', 'desc')->first();
        if (empty($product->id)) {
            $req->session()->flash('mensagem-falha', 'Produto não encontrado no shopcart!');
            return redirect()->route('shopcart.index');
        }

        if ($remove_apenas_item) {
            $where_product['id'] = $product->id;
        }
        OrderItem::where($where_product)->delete();

        $check_order = OrderItem::where([
            'order_id' => $product->order_id
        ])->exists();

        if (!$check_order) {
            Order::where([
                'id' => $product->order_id
            ])->delete();
        }

        $req->session()->flash('mensagem-sucesso', 'Produto removido do shopcart com sucesso!');

        return redirect()->route('shopcart.index');
    }

    public function concluir()
    {
        $this->middleware('VerifyCsrfToken');

        $req = Request();
        $order_id  = $req->input('order_id');
        $idUser = Auth::id();

        $check_order = Order::where([
            'id'      => $order_id,
            'user_id' => $idUser,
            'status'  => 'RE' // Reservada
        ])->exists();

        if (!$check_order) {
            $req->session()->flash('mensagem-falha', 'Pedido não encontrado!');
            return redirect()->route('shopcart.index');
        }

        $check_products = OrderItem::where([
            'order_id' => $order_id
        ])->exists();
        if (!$check_products) {
            $req->session()->flash('mensagem-falha', 'Produtos do pedido não encontrados!');
            return redirect()->route('shopcart.index');
        }

        OrderItem::where([
            'order_id' => $order_id
        ])->update([
            'status' => 'PA'
        ]);
        Order::where([
            'id' => $order_id
        ])->update([
            'status' => 'PA'
        ]);

        $req->session()->flash('mensagem-sucesso', 'Compra concluída com sucesso!');

        return redirect()->route('shopcart.index');//shopcart.compras
    }

    public function compras()
    {

        $compras = Order::where([
            'status'  => 'PA',
            'user_id' => Auth::id()
        ])->orderBy('created_at', 'desc')->get();

        $cancelados = Order::where([
            'status'  => 'CA',
            'user_id' => Auth::id()
        ])->orderBy('updated_at', 'desc')->get();

        return view('shopcart.compras', compact('compras', 'cancelados'));
    }

    public function cancelar()
    {
        $this->middleware('VerifyCsrfToken');

        $req = Request();
        $order_id       = $req->input('order_id');
        $idsOrder_prod = $req->input('id');
        $idusuario      = Auth::id();

        if (empty($idsOrder_prod)) {
            $req->session()->flash('mensagem-falha', 'Nenhum item selecionado para cancelamento!');
            return redirect()->route('shopcart.compras');
        }

        $check_order = Order::where([
            'id'      => $order_id,
            'user_id' => $idusuario,
            'status'  => 'PA' // Pago
        ])->exists();

        if (!$check_order) {
            $req->session()->flash('mensagem-falha', 'Pedido não encontrado para cancelamento!');
            return redirect()->route('shopcart.compras');
        }

        $check_products = OrderItem::where([
            'order_id' => $order_id,
            'status'    => 'PA'
        ])->whereIn('id', $idsOrder_prod)->exists();

        if (!$check_products) {
            $req->session()->flash('mensagem-falha', 'Produtos do pedido não encontrados!');
            return redirect()->route('shopcart.compras');
        }

        OrderItem::where([
            'order_id' => $order_id,
            'status'    => 'PA'
        ])->whereIn('id', $idsOrder_prod)->update([
            'status' => 'CA'
        ]);

        $check_order_cancel = OrderItem::where([
            'order_id' => $order_id,
            'status'    => 'PA'
        ])->exists();

        if (!$check_order_cancel) {
            Order::where([
                'id' => $order_id
            ])->update([
                'status' => 'CA'
            ]);

            $req->session()->flash('mensagem-sucesso', 'Compra cancelada com sucesso!');
        } else {
            $req->session()->flash('mensagem-sucesso', 'Item(ns) da compra cancelado(s) com sucesso!');
        }

        return redirect()->route('shopcart.compras');
    }
}
