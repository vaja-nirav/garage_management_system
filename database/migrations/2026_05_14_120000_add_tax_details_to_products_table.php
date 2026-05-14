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
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'tax_type')) {
                $table->string('tax_type')->default('exclusive')->after('tax_rate');
            }
            if (!Schema::hasColumn('products', 'hsn_code')) {
                $table->string('hsn_code')->nullable()->after('barcode');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['tax_type', 'hsn_code']);
        });
    }
};
