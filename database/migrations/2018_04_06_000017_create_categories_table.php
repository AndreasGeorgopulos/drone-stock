<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id')->comment('Egyedi azonosító');
            $table->string('name', 100);
			$table->string('index_image', 255)->comment('Index kép')->nullable();
            $table->tinyInteger('active')->default(1);
            $table->timestamps();
			$table->softDeletes();
        });
	
		Schema::create('category_translates', function (Blueprint $table) {
			$table->increments('id')->comment('Egyedi azonosító');
			$table->integer('category_id')->comment('Kategória azonosító');
			$table->string('language_code', 10)->comment('Nyelv');
			$table->string('slug', 255)->comment('Link')->nullable();
			$table->string('meta_title', 255)->comment('Meta Megnevezés')->nullable();
			$table->text('meta_description')->comment('Meta Leírás')->nullable();
			$table->text('meta_keywords')->comment('Meta Kulcsszavak')->nullable();
			$table->tinyInteger('active')->comment('Aktív');
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
        Schema::dropIfExists('categories');
		Schema::dropIfExists('category_translates');
    }
}
