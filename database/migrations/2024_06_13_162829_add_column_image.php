<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

     // menambahkan kolom tabel
    public function up(): void
    {
        Schema::table('MergePL', function (Blueprint $table) {$table->string('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */

     //fungsi down balikin migrasi/rollback
    public function down(): void
    {
        //drop column table
        Schema::table('MergePL', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};
