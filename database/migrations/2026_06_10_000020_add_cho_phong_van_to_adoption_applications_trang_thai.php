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
        DB::statement("ALTER TABLE adoption_applications MODIFY COLUMN Trang_thai ENUM('pending', 'pre_approved', 'approved', 'cho_phong_van', 'rejected', 'cancelled', 'completed') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE adoption_applications MODIFY COLUMN Trang_thai ENUM('pending', 'pre_approved', 'approved', 'rejected', 'cancelled') DEFAULT 'pending'");
    }
};
