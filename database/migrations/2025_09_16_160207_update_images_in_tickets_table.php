<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {

            //drop della colonna esistente
           $table->dropColumn('image');

            $table->string('u_images')->nullable();
            $table->string('t_images')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('image')->nullable();

            $table->dropColumn('u_images');
            $table->dropColumn('t_images');
        });
    }
};
