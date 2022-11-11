<?php

namespace Boostech\Cte\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Classe responsável por gerenciar o cabeçalho do CT-e
 */
class Hctex extends Model
{
    protected $table = "boostech_cte_hctex";

    protected $fillable = [
        'ide_cct',
        'ide_cfop',
        'ide_natop',
        'ide_mod',
        'ide_serie',
        'ide_nct',
        'ide_dhemit',
        'ide_tpamb',
        'ide_cmunini',
        'ide_xmunini',
        'ide_ufini',
        'ide_cmunfim',
        'ide_xmunfim',
        'ide_uffim',
        'compl_xobs',
        'emit_cnpj',
        'emit_ie',
        'emit_xnome',
        'rem_cnpj',
        'rem_ie',
        'rem_xnome',
        'dest_cnpj',
        'dest_ie',
        'dest_xnome',
        'vprest_vtprest',
        'vprest_vrec',
        'infprot_chcte',
        'infprot_cstat',
        'infprot_xmotivo',
        'usuario_id',
        'empresa_id',
    ];

    /**
     * Método responsável por persistir os dados do cabeçalho da CT-e
     */
    public static function createHctex(int $empresa_id, int $usuario_id, Request $data)
    {
        $status = false;
        $excessao = null;
        $mensagem = null;
        $obj = null;

        try {
            DB::beginTransaction();

            $hctex = Hctex::create([
                'ide_cct' =>  $data['ide_cct'],
                'ide_cfop' =>  $data['ide_cfop'],
                'ide_natop' =>  $data['ide_natop'],
                'ide_mod' =>  $data['ide_mod'],
                'ide_serie' =>  $data['ide_serie'],
                'ide_nct' =>  $data['ide_nct'],
                'ide_dhemit' =>  $data['ide_dhemit'],
                'ide_tpamb' =>  $data['ide_tpamb'],
                'ide_cmunini' =>  $data['ide_cmunini'],
                'ide_xmunini' =>  $data['ide_xmunini'],
                'ide_ufini' =>  $data['ide_ufini'],
                'ide_cmunfim' =>  $data['ide_cmunfim'],
                'ide_xmunfim' =>  $data['ide_xmunfim'],
                'ide_uffim' =>  $data['ide_uffim'],
                'compl_xobs' =>  $data['compl_xobs'],
                'emit_cnpj' =>  $data['emit_cnpj'],
                'emit_ie' =>  $data['emit_ie'],
                'emit_xnome' =>  $data['emit_xnome'],
                'rem_cnpj' =>  $data['rem_cnpj'],
                'rem_ie' =>  $data['rem_ie'],
                'rem_xnome' =>  $data['rem_xnome'],
                'dest_cnpj' =>  $data['dest_cnpj'],
                'dest_ie' =>  $data['dest_ie'],
                'dest_xnome' =>  $data['dest_xnome'],
                'vprest_vtprest' =>  $data['vprest_vtprest'],
                'vprest_vrec' =>  $data['vprest_vrec'],
                'infprot_chcte' =>  $data['infprot_chcte'],
                'infprot_cstat' =>  $data['infprot_cstat'],
                'infprot_xmotivo' =>  $data['infprot_xmotivo'],
                'empresa_id' =>  $empresa_id,
                'usuario_id' =>  $usuario_id,
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

    /**
     * Método responsável por importar um arquivo XML
     *
     * @param integer $empresa_id ID da empresa responsável por armazenar os dados da CT-e, caso não possua, informar 1
     * @param integer $usuario_id ID do usuário responsável por armazenar os dados da CT-e, caso não possua, informar 1
     * @param string $arquivo Diretório, nome e extensão do arquivo XML, por exemplo, /home/joao/Documents/dump/xml/arquivo.xml
     * @return array Retorna um array com a seguinte estrutura:
     *                      status: True informa que a operação foi bem sucedida
     *                      excessao: Retorna a excessão caso algum problema tenha ocorrido
     *                      mensagem: Descreve o status da operação
     */
    public static function importarXML(int $empresa_id, int $usuario_id, string $arquivo)
    {
        $status = false;
        $excessao = null;
        $mensagem = null;

        try {
            $xmldata = simplexml_load_file($arquivo);

            $hctex = DB::select("select count(*) as total from boostech_cte_hctex where empresa_id = ? and infprot_chcte = ?;", [$empresa_id, (string)$xmldata->children()->protCTe->infProt->chCTe]);

            if ($hctex[0]->total == 0) {
                DB::beginTransaction();

                $data = new Request();
                $data->setMethod('POST');
                $data->replace([
                    'ide_cuf' => (string)$xmldata->children()->CTe->infCte->ide->cUF,
                    'ide_cct' => (string)$xmldata->children()->CTe->infCte->ide->cCT,
                    'ide_cfop' => (string)$xmldata->children()->CTe->infCte->ide->CFOP,
                    'ide_natop' => (string)$xmldata->children()->CTe->infCte->ide->natOp,
                    'ide_mod' => (string)$xmldata->children()->CTe->infCte->ide->mod,
                    'ide_serie' => (string)$xmldata->children()->CTe->infCte->ide->serie,
                    'ide_nct' => (string)$xmldata->children()->CTe->infCte->ide->nCT,
                    'ide_dhemit' => (string)$xmldata->children()->CTe->infCte->ide->dhEmi,
                    'ide_tpamb' => (string)$xmldata->children()->CTe->infCte->ide->tpAmb,
                    'ide_cmunini' => (string)$xmldata->children()->CTe->infCte->ide->cMunIni,
                    'ide_xmunini' => (string)$xmldata->children()->CTe->infCte->ide->xMunIni,
                    'ide_ufini' => (string)$xmldata->children()->CTe->infCte->ide->UFIni,
                    'ide_cmunfim' => (string)$xmldata->children()->CTe->infCte->ide->cMunFim,
                    'ide_xmunfim' => (string)$xmldata->children()->CTe->infCte->ide->xMunFim,
                    'ide_uffim' => (string)$xmldata->children()->CTe->infCte->ide->UFFim,

                    'compl_xobs' => (string)$xmldata->children()->CTe->infCte->compl->xObs,

                    'emit_cnpj' => (string)$xmldata->children()->CTe->infCte->emit->CNPJ,
                    'emit_ie' => (string)$xmldata->children()->CTe->infCte->emit->IE,
                    'emit_xnome' => (string)$xmldata->children()->CTe->infCte->emit->xNome,

                    'rem_cnpj' => (string)$xmldata->children()->CTe->infCte->rem->CNPJ,
                    'rem_ie' => (string)$xmldata->children()->CTe->infCte->rem->IE,
                    'rem_xnome' => (string)$xmldata->children()->CTe->infCte->rem->xNome,

                    'dest_cnpj' => (string)$xmldata->children()->CTe->infCte->dest->CNPJ,
                    'dest_ie' => (string)$xmldata->children()->CTe->infCte->dest->IE,
                    'dest_xnome' => (string)$xmldata->children()->CTe->infCte->dest->xNome,

                    'vprest_vtprest' => (string)$xmldata->children()->CTe->infCte->vPrest->vTPrest,
                    'vprest_vrec' => (string)$xmldata->children()->CTe->infCte->vPrest->vRec,

                    'infprot_chcte' =>  (string)$xmldata->children()->protCTe->infProt->chCTe,
                    'infprot_cstat' =>  (string)$xmldata->children()->protCTe->infProt->cStat,
                    'infprot_xmotivo' =>  (string)$xmldata->children()->protCTe->infProt->xMotivo,

                    'usuario_id' => $usuario_id,
                    'empresa_id' => $empresa_id,
                ]);

                $retorno = Hctex::createHctex($empresa_id, $usuario_id, $data);

                if ($retorno['status']) {
                    foreach ($xmldata->children()->CTe->infCte->infDoc as $infDoc) {
                        $data_item = new Request();
                        $data_item->setMethod('POST');
                        $data_item->replace([
                            'infnfe_chave' => (string)$infDoc->infNFe->chave,
                            'infnfe_pin' => (string)$infDoc->infNFe->PIN,
                            'infnfe_dprev' => (string)$infDoc->infNFe->dPrev,
                        ]);

                        $retorno_item = Hctei::createHctei($retorno["obj"], $data_item);

                        if (!$retorno_item['status']) {
                            $retorno['status'] = $retorno_item['status'];
                            $retorno['mensagem'] = $retorno_item['mensagem'];
                            $retorno['excessao'] = $retorno_item['excessao'];

                            break;
                        }
                    }
                }

                $status = true;
                $mensagem = "XML importado com sucesso";

                if (!$retorno['status']) {
                    $status = $retorno['status'];
                    $mensagem = $retorno['mensagem'];
                    $excessao = $retorno['excessao'];
                }

                DB::commit();
            } else {
                $status = false;
                $mensagem = sprintf("CT-e já existe na base Chave: %s", (string)$xmldata->children()->protCTe->infProt->chCTe);
                $excessao = null;
            }
        } catch (\Throwable $th) {
            DB::rollBack();

            $status = false;
            $mensagem = sprintf("Ocorreu um erro inesperado Método: %s", __METHOD__);
            $excessao = $th;
        }

        return ["status" => $status, "excessao" => $excessao, "mensagem" => $mensagem];
    }
}
