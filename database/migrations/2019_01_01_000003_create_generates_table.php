<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneratesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('generate_complete')->default(false);
            $table->integer('generate_duration_seconds')->nullable();
            $table->string('filepath')->nullable();
            $table->integer('filesize_byte')->nullable();

            if ((\Illuminate\Support\Facades\DB::connection()->getPdo()->getAttribute(PDO::ATTR_DRIVER_NAME) == 'mysql') && version_compare(DB::connection()->getPdo()->getAttribute(PDO::ATTR_SERVER_VERSION), '5.7.8', 'ge')) {
                $table->json('content')->nullable();
            } else {
                $table->text('content')->nullable();
            }

            $table->unsignedBigInteger('format_id');
            $table->foreign('format_id')->references('id')->on('formats');

            $table->unsignedBigInteger('gliederung_id');
            $table->foreign('gliederung_id')->references('id')->on('gliederungs');

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
        Schema::dropIfExists('generates');
    }
}
