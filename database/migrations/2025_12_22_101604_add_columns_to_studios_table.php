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
    Schema::table('studios', function (Blueprint $table) {
        $table->integer('total_rows')->default(5);
        $table->integer('cols_per_block')->default(10);
    });
}

public function down(): void
{
    Schema::table('studios', function (Blueprint $table) {
        // Hapus kolom jika migration di-rollback
        $table->dropColumn(['total_rows', 'cols_per_block']);
    });
}
};
