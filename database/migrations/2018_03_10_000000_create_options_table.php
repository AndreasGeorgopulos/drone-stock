<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lq_options', function (Blueprint $table) {
            $table->increments('id')->comment('Egyedi azonosító')->unique();
            $table->string('lq_key')->comment('Kulcs');
            $table->text('lq_value')->comment('Érték');
			$table->string('notice')->nullable()->comment('Megjegyzés');
			$table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lq_options');
    }
}
