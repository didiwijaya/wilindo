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
            $table->char('code', 4)->unique();
            $table->char('province_code', 2);
            $table->string('name', 255);
            
            $table->foreign('province_code')
                ->references('code')
                ->on(config('wilindo.prefix') . 'provinces')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    public function getTableName()
    {
        return config('wilindo.prefix') . 'cities';
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->getTableName());
    }
};
