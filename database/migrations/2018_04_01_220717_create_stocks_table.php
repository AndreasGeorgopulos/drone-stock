<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
			$table->increments('id')->comment('Azonosító');
            $table->string('name')->comment('V-Stock neve');
            $table->string('clip_length', 10)->comment('Hossz');
			$table->string('aspect_ratio', 10)->comment('Képarány');
			$table->string('thumbnail_file_name', 255)->nullable()->comment('Thumbnail képfile');
			$table->integer('category_id')->comment('Kategória azonosító');
            $table->tinyInteger('active')->default(1)->comment('Aktív');
            $table->timestamps();
            $table->softDeletes();
        });
	
		Schema::create('stock_translates', function (Blueprint $table) {
			$table->increments('id')->comment('Azonosító');
			$table->integer('stock_id')->comment('Külső kulcs: stocks.id');
			$table->string('language_code')->comment('Nyelv');
			$table->string('slug')->comment('Link')->nullable();
			$table->string('meta_title')->comment('Meta Megnevezés')->nullable();
			$table->string('meta_description')->comment('Meta Leírás')->nullable();
			$table->string('meta_keywords')->comment('Meta Kulcsszavak')->nullable();
			$table->text('lead')->comment('Bevezető')->nullable();
			$table->text('body')->comment('Tartalom')->nullable();
			$table->tinyInteger('active')->default(1)->comment('Aktív');
			$table->timestamps();
			$table->softDeletes();
		});
	
		Schema::create('stock_sizes', function (Blueprint $table) {
			$table->increments('id')->comment('Azonosító');
			$table->integer('stock_id')->comment('Külső kulcs: stocks.id');
			$table->string('name', 100)->comment('Név (4K, HD, etc.)');
			$table->string('size', 30)->comment('Videó méret');
			$table->string('fps', 10)->comment('Fps');
			$table->string('type', 10)->comment('Típus');
			$table->string('file_name', 255)->nullable()->comment('Filenév');
			$table->integer('file_size')->nullable()->comment('File méret');
			$table->tinyInteger('active')->default(1)->comment('Aktív');
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
        Schema::dropIfExists('stocks');
		Schema::dropIfExists('stock_translates');
		Schema::dropIfExists('stock_sizes');
    }
}
