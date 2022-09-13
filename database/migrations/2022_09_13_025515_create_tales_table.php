<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tales', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('description');
            $table->string('meta_title');
            $table->string('meta_description');
            $table->string('meta_keyword')->nullable();
            $table->string('keyword');
            $table->string('thumbnail')->nullable();
            $table->string('name');
            $table->string('other_name')->nullable();
            $table->string('status')->default('Đang cập nhật');
            $table->text('content')->nullable();
            $table->integer('is_home')->default(0);
            $table->integer('is_feature')->default(0);
            $table->bigInteger('category_primary_id')->unsigned()->nullable();
            $table->foreign('category_primary_id')->references('id')->on('categories')->onDelete('set null');
            $table->string('author')->default('Đang cập nhật');
            $table->integer('vỉews')->default(0);
            $table->string('source_origin')->nullable();
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
        Schema::dropIfExists('tales');
    }
}
