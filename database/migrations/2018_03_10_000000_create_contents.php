<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->increments('id')->comment('Egyedi azonosító')->unique();
            $table->string('name', 100)->comment('Megnevezés');
            $table->string('index_image', 255)->comment('Index kép')->nullable();
			$table->integer('category_id')->comment('Kategória azonosító');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('content_translates', function (Blueprint $table) {
            $table->increments('id')->comment('Egyedi azonosító')->unique();
            $table->integer('content_id')->comment('Oldal');
			$table->string('language_code', 10)->comment('Nyelv kód');
            $table->string('slug', 255)->comment('Link')->nullable();
            $table->string('meta_title', 255)->comment('Meta Megnevezés')->nullable();
            $table->text('meta_description')->comment('Meta Leírás')->nullable();
            $table->text('meta_keywords')->comment('Meta Kulcsszavak')->nullable();
            $table->text('lead')->comment('Bevezető')->nullable();
            $table->text('body')->comment('Tartalom')->nullable();
			$table->tinyInteger('active')->comment('Aktív');
            $table->softDeletes();
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
        Schema::drop('contents');
        Schema::drop('content_translate');
    }
}
