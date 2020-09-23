<?php

namespace App\Http\Controllers;

use App\Address;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.cadastro');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $test = User::getByUser($request->email,$request->cpf);
        if (!empty($test)) {
            $request->session()->flash('mensagem-falha', 'Usuario já cadastrado');
            return redirect()->route('user.create');
        }else
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->cpf = $request->cpf;
        $user->password = Hash::make($request->password);
        $user->save();


        $addrress = new Address();
        $addrress->street = $request->logradouro;
        $addrress->number = $request->numero;
        $addrress->complement = $request->complemento;
        $addrress->neighborhood = $request->bairro;
        $addrress->state = $request->estado;
        $addrress->city = $request->cidade;
        $addrress->user_id = $user->id;
        $addrress->save();

       return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
