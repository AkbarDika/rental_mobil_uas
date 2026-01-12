<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('denda', function (Blueprint $table) {
            $table->id('id_denda'); // Primary Key

            $table->unsignedBigInteger('pengembalian_id'); // Foreign Key

            $table->integer('jumlah_hari_terlambat');
            $table->decimal('tarif_denda_per_hari', 10, 2);
            $table->decimal('total_denda', 12, 2);
            $table->string('keterangan', 150)->nullable();

            $table->timestamps();

            // Foreign Key Constraint
            $table->foreign('pengembalian_id')
                  ->references('id_pengembalian')
                  ->on('pengembalian')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('denda');
    }
};

