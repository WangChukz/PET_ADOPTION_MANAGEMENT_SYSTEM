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
        Schema::table('adoption_applications', function (Blueprint $table) {
            $table->uuid('interview_slot_id')->nullable()->after('Trang_thai');
            $table->dateTime('han_xac_nhan_phong_van')->nullable()->after('interview_slot_id');
            $table->boolean('da_nhac_nho_phong_van')->default(false)->after('han_xac_nhan_phong_van');
            
            $table->foreign('interview_slot_id')
                  ->references('Ma_slot')
                  ->on('interview_slots')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adoption_applications', function (Blueprint $table) {
            $table->dropForeign(['interview_slot_id']);
            $table->dropColumn(['interview_slot_id', 'han_xac_nhan_phong_van', 'da_nhac_nho_phong_van']);
        });
    }
};
