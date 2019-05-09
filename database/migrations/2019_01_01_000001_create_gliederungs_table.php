<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGliederungsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gliederungs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('gliederung_id')->unique();
            $table->string('name');
            $table->string('str')->nullable();
            $table->string('nr')->nullable();
            $table->string('ort')->nullable();
            $table->string('plz')->nullable();
            $table->string('bez')->nullable();

            if ((\Illuminate\Support\Facades\DB::connection()->getPdo()->getAttribute(PDO::ATTR_DRIVER_NAME) == 'mysql') && version_compare(DB::connection()->getPdo()->getAttribute(PDO::ATTR_SERVER_VERSION), '5.7.8', 'ge')) {
                $table->json('template_fields')->nullable();
            } else {
                $table->text('template_fields')->nullable();
            }

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gliederungs');
    }
}
