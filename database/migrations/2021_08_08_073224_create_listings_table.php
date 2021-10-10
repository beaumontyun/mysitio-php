<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
            $table->text('body');
            $table->string('title', 255);
            $table->string('description', 255);
            $table->foreignId('category_id')->constrained('categories');
            $table->boolean('sale')->default(true); // default option, user can opt-out for exchange or both
            $table->boolean('exchange')->default(false);
            $table->string('exchange_description', 255);
            $table->foreignId('condition_id')->constrained('conditions');
            $table->decimal('weight', 10, 2);
            $table->decimal('height', 10, 2);
            $table->decimal('length', 10, 2);
            $table->decimal('width', 10, 2);
            $table->decimal('price', 13, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listings');
    }
}
