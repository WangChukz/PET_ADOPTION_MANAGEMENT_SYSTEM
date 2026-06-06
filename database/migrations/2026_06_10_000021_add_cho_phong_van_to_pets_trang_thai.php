<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE pets MODIFY COLUMN Trang_thai ENUM('dang_cuu_ho', 'chua_san_sang', 'san_sang', 'cho_phong_van', 'da_nhan_nuoi', 'da_mat') DEFAULT 'chua_san_sang'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE pets MODIFY COLUMN Trang_thai ENUM('dang_cuu_ho', 'chua_san_sang', 'san_sang', 'da_nhan_nuoi', 'da_mat') DEFAULT 'chua_san_sang'");
    }
};
