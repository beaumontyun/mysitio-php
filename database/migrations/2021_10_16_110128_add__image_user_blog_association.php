<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageUserBlogAssociation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs_images', function (Blueprint $table) {
            $table->id();
            $table->text('blogs_images')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            

        });
        Schema::create('user_blogsimg', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blogs_images_id')->constrained('blogs_images');
            $table->foreignId('users_id')->constrained('users');
            $table->foreignId('blogs_id')->constrained('blogs');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_blogsimg');
        Schema::dropIfExists('blogs_images');
    }
}
