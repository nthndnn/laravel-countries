<?php

use Illuminate\Database\Connection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCountryCurrencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country_currency', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->index()->constrained();
            $table->foreignId('currency_id')->index()->constrained();
            $table->timestamps();

            /** @var Connection $connection */
            $connection = DB::connection();
            if ($connection->getDriverName() === 'postgres') {
                $table->index(['country_id', 'currency_id']);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('country_currency');
    }
};
