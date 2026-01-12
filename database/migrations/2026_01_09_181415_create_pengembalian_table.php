<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->id('id_pengembalian'); // Primary Key

            $table->unsignedBigInteger('pemesanan_id'); // Foreign Key

            $table->date('tanggal_kembali');
            $table->string('kondisi_mobil', 100);
            $table->text('catatan')->nullable();
            $table->enum('status_pengembalian', ['pending', 'selesai', 'bermasalah'])
                  ->default('pending');

            $table->timestamps();

            // Foreign Key Constraint
            $table->foreign('pemesanan_id')
                  ->references('id')
                  ->on('pemesanan')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalian');
    }
};
