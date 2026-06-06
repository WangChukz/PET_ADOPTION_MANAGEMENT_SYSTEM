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
        Schema::create('adoption_answers', function (Blueprint $table) {
            $table->uuid('Ma_tra_loi')->primary();
            $table->uuid('Ma_don');
            $table->uuid('Ma_cau_hoi');
            $table->text('Noi_dung_tra_loi')->nullable();
            $table->json('Lua_chon_da_chon')->nullable();
            
            $table->timestampTz('Ngay_tao')->useCurrent();
            $table->timestampTz('Ngay_cap_nhat')->useCurrent()->useCurrentOnUpdate();

            // Foreign keys
            $table->foreign('Ma_don')->references('Ma_don')->on('adoption_applications')->onDelete('cascade');
            $table->foreign('Ma_cau_hoi')->references('Ma_cau_hoi')->on('adoption_questions')->onDelete('cascade');

            // Unique constraint: Mỗi đơn chỉ được có 1 dòng cho mỗi câu hỏi
            $table->unique(['Ma_don', 'Ma_cau_hoi']);
            
            // Index for fast lookups
            $table->index('Ma_don', 'idx_answers_ma_don');
            $table->index('Ma_cau_hoi', 'idx_answers_ma_cau_hoi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adoption_answers');
    }
};
