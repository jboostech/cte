<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateHcteiTable extends Migration
{
    public function up()
    {
        DB::select("create table boostech_cte_hctei (
                    id serial,
                    cte_id int,
                    infnfe_chave varchar(44),
                    infnfe_pin varchar(9),
                    infnfe_dprev date,
                    usuario_id int,
                    empresa_id int,
                    created_at timestamp,
                    updated_at timestamp,
                    constraint pk_boostech_cte_hctei primary key (id),
                    constraint fk_boostech_cte_hctei_cte_id foreign key (cte_id) references boostech_cte_hctex (id));");
    }

    public function down()
    {
        Schema::dropIfExists('boostech_cte_hctei');
    }
}
