<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pelanggan_id');
            $table->decimal('total', 12, 2);
            $table->decimal('lat', 18, 15);
            $table->decimal('long', 18, 15);
            $table->text('alamat');
            $table->decimal('ongkir', 12, 2);
            $table->enum('status', ['dikemas', 'dikirim', 'selesai']);
            $table->enum('status_pembayaran', ['pending', 'paid', 'failed']);
            $table->string('payment_method', 100);
            $table->timestamps();

            $table->foreign('pelanggan_id')
                  ->references('id')->on('pelanggans')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
