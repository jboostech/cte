<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateHctexTable extends Migration
{
    public function up()
    {
        DB::select("create table boostech_cte_hctex (
                    id serial,
                    ide_cct varchar(8),
                    ide_cfop varchar(4),
                    ide_natop varchar(60),
                    ide_mod varchar(2),
                    ide_serie varchar(3),
                    ide_nct varchar(9),
                    ide_dhemit timestamp,
                    ide_tpamb varchar(1),
                    ide_cmunini varchar(7),
                    ide_xmunini varchar(60),
                    ide_ufini varchar(2),
                    ide_cmunfim varchar(7),
                    ide_xmunfim varchar(60),
                    ide_uffim varchar(2),
                    compl_xobs varchar(2000),
                    emit_cnpj varchar(14),
                    emit_ie varchar(14),
                    emit_xnome varchar(60),
                    rem_cnpj varchar(14),
                    rem_ie varchar(14),
                    rem_xnome varchar(60),
                    dest_cnpj varchar(14),
                    dest_ie varchar(14),
                    dest_xnome varchar(60),
                    vprest_vtprest numeric(15,2),
                    vprest_vrec numeric(15,2),
                    infprot_chcte varchar(44),
                    infprot_cstat varchar(3),
                    infprot_xmotivo varchar(255),
                    usuario_id int,
                    empresa_id int,
                    created_at timestamp,
                    updated_at timestamp,
                    constraint pk_boostech_cte_hctex primary key (id));");
    }

    public function down()
    {
        Schema::dropIfExists('boostech_cte_hctex');
    }
}
