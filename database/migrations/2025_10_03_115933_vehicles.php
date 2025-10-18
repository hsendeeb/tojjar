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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId("company_id");
            $table->foreignId("model_id");
            $table->string("year");
            $table->foreignId("category_id");
            $table->unsignedBigInteger("price");
            $table->unsignedBigInteger("mileage");
            $table->foreignId("body_id");
            $table->foreignId("fuel_id");
            $table->foreignId("color_id");
            $table->foreignId("gearbox_id");
            $table->foreignId("condition_id");
            $table->foreign("model_id")->references("id")->on("car_models");
            $table->foreign("company_id")->references("id")->on("companies");
            $table->foreign("body_id")->references("id")->on("body_types");
            $table->foreign("fuel_id")->references("id")->on("fuel_types");
            $table->foreign("color_id")->references("id")->on("colors");
            $table->foreign("gearbox_id")->references("id")->on("gearboxes");
            $table->foreign("condition_id")->references("id")->on("conditions");
            $table->foreign("category_id")->references("id")->on("categories");
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
