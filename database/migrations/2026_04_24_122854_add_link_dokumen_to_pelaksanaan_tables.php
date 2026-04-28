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
        Schema::table('pelaksanaan_pendidikan', function (Blueprint $table) {
            $table->string('link_dokumen')->nullable()->after('status');
        });
        
        Schema::table('pelaksanaan_penelitian', function (Blueprint $table) {
            $table->string('link_dokumen')->nullable()->after('status');
        });
        
        Schema::table('pelaksanaan_pengabdian', function (Blueprint $table) {
            $table->string('link_dokumen')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelaksanaan_pendidikan', function (Blueprint $table) {
            $table->dropColumn('link_dokumen');
        });
        
        Schema::table('pelaksanaan_penelitian', function (Blueprint $table) {
            $table->dropColumn('link_dokumen');
        });
        
        Schema::table('pelaksanaan_pengabdian', function (Blueprint $table) {
            $table->dropColumn('link_dokumen');
        });
    }
};
