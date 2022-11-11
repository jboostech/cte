<?php

namespace Boostech\Cte\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Classe responsável por gerenciar as NF-e's do CTE
 */
class Hctei extends Model
{
    protected $table = "boostech_cte_hctei";

    protected $fillable = [
        'cte_id',
        'infnfe_chave',
        'infnfe_pin',
        'infnfe_dprev',
        'usuario_id',
        'empresa_id',
    ];

    /**
     * Método responsável por persistir os dados das NF-e's do CTE
     */
    public static function createHctei(Hctex $hctex, Request $data)
    {
        $status = false;
        $excessao = null;
        $mensagem = null;
        $obj = null;

        try {
            DB::beginTransaction();

            $hctex = Hctex::create([
                'cte_id' =>  $hctex->id,
                'infnfe_chave' =>  $data['infnfe_chave'],
                'infnfe_pin' =>  $data['infnfe_pin'],
                'infnfe_dprev' =>  $data['infnfe_dprev'],
                'empresa_id' =>  $hctex->empresa_id,
                'usuario_id' =>  $hctex->usuario_id,
            ]);

            $status = true;
            $mensagem = "Registro criado com sucesso";
            $obj = $hctex;

            DB::commit();
        } catch (\PDOException $e) {
            $status = false;
            $mensagem = sprintf("Ocorreu um erro inesperado Método: %s", __METHOD__);
            $excessao = $e;
            DB::rollBack();
        }

        return ["status" => $status, "excessao" => $excessao, "mensagem" => $mensagem, "obj" => $obj];
    }
}
