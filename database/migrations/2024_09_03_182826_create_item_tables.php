<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('description');
        });

        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('type');
            $table->decimal('value', total: 12, places: 3);
        });

        Schema::create('priced_things', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('priced_thing_id');
            $table->string('priced_thing_type');
            $table->integer('price_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('priced_things');
        Schema::dropIfExists('prices');
        Schema::dropIfExists('items');
    }
};
