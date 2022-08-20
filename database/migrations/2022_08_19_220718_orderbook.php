<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orderbook', function (Blueprint $table) {
            DB::statement('CREATE TABLE IF NOT EXISTS `orderbook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zdrojova_mena` varchar(3) NOT NULL,
  `cielova_mena` varchar(3) NOT NULL,
  `cena` float NOT NULL,
  `priznak` varchar(4) NOT NULL,
  `casova_peciatka` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');
        });

        /*
        Schema::create('orderbook', function (Blueprint $table) {
            $table->id();
            $table->char('zdrojova_mena',3);
            $table->char('cielova_mena',3);
            $table->float('cena',2,3);
            $table->char('priznak',4);
            $table->dateTime('casova_peciatka');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orderbook');
    }
};
