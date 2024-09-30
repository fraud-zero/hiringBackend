<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('placements', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->enum('platform', ['app', 'web']);
            $table->integer('total');
            $table->integer('invalid_total');
            $table->decimal('invalid_total_percent', 5, 1);
            $table->integer('pixel_stuffing');
            $table->decimal('pixel_stuffing_percent', 5, 1);
            $table->integer('viewable');
            $table->decimal('viewable_percent', 5, 1);
            $table->integer('non_viewable');
            $table->decimal('non_viewable_percent', 5, 1);
            $table->integer('mfa_site_symptoms');
            $table->decimal('mfa_site_symptoms_percent', 5, 1);
            $table->integer('other_invalid');
            $table->decimal('other_invalid_percent', 5, 1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('placements');
    }
};
