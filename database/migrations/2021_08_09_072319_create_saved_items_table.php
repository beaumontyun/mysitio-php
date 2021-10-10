<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavedItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saved_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('saved_list_id')->constrained('saved_lists');
            $table->string('item_image');
            $table->string('title');
            $table->string('description');
            $table->decimal('price', 13, 2); // maximum 13 digits long, with only 2 digits within it are for decimals
            $table->foreignId('category_id')->constrained('categories');
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
        Schema::dropIfExists('saved_items');
    }
}
