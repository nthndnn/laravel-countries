<?php

use Illuminate\Database\Connection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name_official');
            $table->string('name_common');
            $table->foreignId('continent_id')->constrained();
            $table->json('capital')->nullable();
            $table->string('region');
            $table->string('subregion')->nullable();
            $table->string('alpha_2_code', 2)->unique();
            $table->string('alpha_3_code', 3)->unique();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->boolean('independent')->nullable();
            $table->boolean('un_member');
            $table->timestamps();

            /** @var Connection $connection */
            $connection = DB::connection();
            if ($connection->getDriverName() === 'postgres') {
                $table->index(['continent_id']);
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
        Schema::dropIfExists('countries');
    }
}
