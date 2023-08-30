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
        Schema::create($this->getTableName(), function (Blueprint $table) {
            $table->id();
            $table->char('code', 7)->unique();
            $table->char('city_code', 4);
            $table->string('name', 255);

            $table->foreign('city_code')
                ->references('code')
                ->on(config('wilindo.prefix') . 'cities')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    public function getTableName()
    {
        return config('wilindo.prefix') . 'districts';
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->getTableName());
    }
};
