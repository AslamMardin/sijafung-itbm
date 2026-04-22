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
        // Drop bukti_dokumen from pelaksanaan_pendidikan
        if (Schema::hasColumn('pelaksanaan_pendidikan', 'bukti_dokumen')) {
            Schema::table('pelaksanaan_pendidikan', function (Blueprint $table) {
                $table->dropColumn('bukti_dokumen');
            });
        }

        // Drop bukti_dokumen from pelaksanaan_penelitian
        if (Schema::hasColumn('pelaksanaan_penelitian', 'bukti_dokumen')) {
            Schema::table('pelaksanaan_penelitian', function (Blueprint $table) {
                $table->dropColumn('bukti_dokumen');
            });
        }

        // Drop bukti_dokumen from pelaksanaan_pengabdian
        if (Schema::hasColumn('pelaksanaan_pengabdian', 'bukti_dokumen')) {
            Schema::table('pelaksanaan_pengabdian', function (Blueprint $table) {
                $table->dropColumn('bukti_dokumen');
            });
        }

        // Drop bukti_dokumen from kegiatan_tri_dharma
        if (Schema::hasColumn('kegiatan_tri_dharma', 'bukti_dokumen')) {
            Schema::table('kegiatan_tri_dharma', function (Blueprint $table) {
                $table->dropColumn('bukti_dokumen');
            });
        }

        // Also drop link_dokumen if exists
        if (Schema::hasColumn('pelaksanaan_pendidikan', 'link_dokumen')) {
            Schema::table('pelaksanaan_pendidikan', function (Blueprint $table) {
                $table->dropColumn('link_dokumen');
            });
        }

        if (Schema::hasColumn('pelaksanaan_penelitian', 'link_dokumen')) {
            Schema::table('pelaksanaan_penelitian', function (Blueprint $table) {
                $table->dropColumn('link_dokumen');
            });
        }

        if (Schema::hasColumn('pelaksanaan_pengabdian', 'link_dokumen')) {
            Schema::table('pelaksanaan_pengabdian', function (Blueprint $table) {
                $table->dropColumn('link_dokumen');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add columns back if needed
        Schema::table('pelaksanaan_pendidikan', function (Blueprint $table) {
            $table->string('bukti_dokumen')->nullable();
            $table->string('link_dokumen')->nullable();
        });

        Schema::table('pelaksanaan_penelitian', function (Blueprint $table) {
            $table->string('bukti_dokumen')->nullable();
            $table->string('link_dokumen')->nullable();
        });

        Schema::table('pelaksanaan_pengabdian', function (Blueprint $table) {
            $table->string('bukti_dokumen')->nullable();
            $table->string('link_dokumen')->nullable();
        });

        Schema::table('kegiatan_tri_dharma', function (Blueprint $table) {
            $table->string('bukti_dokumen')->nullable();
        });
    }
};
