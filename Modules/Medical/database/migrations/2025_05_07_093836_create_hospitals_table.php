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
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name_en');
            $table->string('name_ar');
            $table->text('address_en');
            $table->text('address_ar');
            $table->string('contact_en');
            $table->string('contact_ar');
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('working_hours_en');
            $table->string('working_hours_ar');
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->string('image')->nullable();
            $table->boolean('auto_booking')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospitals');
    }
};
