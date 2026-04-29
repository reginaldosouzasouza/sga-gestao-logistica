<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use DB;

class PerfilController extends Controller
{

    public function permissoes($perfil_id)
    {

        $perfil = DB::table('perfis')->where('id',$perfil_id)->first();

        $permissoes = DB::table('permissoes')
            ->orderBy('modulo')
            ->get();

        $permissoesPerfil = DB::table('perfil_permissoes')
            ->where('perfil_id',$perfil_id)
            ->pluck('permissao_id')
            ->toArray();

        return view('perfis.permissoes',compact(
            'perfil',
            'permissoes',
            'permissoesPerfil'
        ));
    }


    public function salvarPermissoes(Request $request,$perfil_id)
    {

        DB::table('perfil_permissoes')
            ->where('perfil_id',$perfil_id)
            ->delete();

        if($request->permissoes){

            foreach($request->permissoes as $permissao){

                DB::table('perfil_permissoes')->insert([
                    'perfil_id'=>$perfil_id,
                    'permissao_id'=>$permissao
                ]);

            }

        }

        return redirect()->back()->with('success','Permissões atualizadas.');
    }

}