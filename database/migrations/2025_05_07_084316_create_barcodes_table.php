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
        Schema::create('barcodes', function (Blueprint $table) {
            $table->id();
            $table->string('barcode', 255)->unique()->index();
            $table->string('machine', 255)->nullable();
            $table->string('operator_name', 255)->nullable();
            $table->string('operator_code', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->bigInteger('deleted_by')->nullable();
        });

        // Drop procedure if exists
        DB::unprepared("
            IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[sp_ValidateBarcodeAndGetOperatorInfo]') AND type in (N'P', N'PC'))
                DROP PROCEDURE [dbo].[sp_ValidateBarcodeAndGetOperatorInfo]
        ");

        // Create stored procedure for barcode validation
        DB::unprepared("
            CREATE PROCEDURE [dbo].[sp_ValidateBarcodeAndGetOperatorInfo]
                @p_barcode NVARCHAR(255)
            AS
            BEGIN
                -- Set NOCOUNT ON to prevent extra result sets
                SET NOCOUNT ON;

                -- Declare variables to store results
                DECLARE @v_exists BIT = 0;
                DECLARE @v_machine NVARCHAR(255);
                DECLARE @v_operator_name NVARCHAR(255);
                DECLARE @v_operator_code NVARCHAR(255);

                -- First check if barcode exists in barcodes table
                SELECT TOP 1
                    @v_exists = 1,
                    @v_machine = machine,
                    @v_operator_name = operator_name,
                    @v_operator_code = operator_code
                FROM
                    barcodes
                WHERE
                    barcode = @p_barcode
                    AND is_active = 1
                    AND deleted_at IS NULL;

                -- If not found in barcodes table, check inspection_transactions as fallback
                IF @v_exists = 0
                BEGIN
                    SELECT TOP 1
                        @v_exists = 1,
                        @v_machine = machine,
                        @v_operator_name = operator_name,
                        @v_operator_code = operator_code
                    FROM
                        inspection_transactions
                    WHERE
                        barcode = @p_barcode
                        AND deleted_at IS NULL;
                END

                -- Return results
                SELECT
                    CASE WHEN @v_exists = 1 THEN 1 ELSE 0 END AS barcode_exists,
                    @v_machine AS machine,
                    @v_operator_name AS operator_name,
                    @v_operator_code AS operator_code;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the stored procedure
        DB::unprepared("
            IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[sp_ValidateBarcodeAndGetOperatorInfo]') AND type in (N'P', N'PC'))
                DROP PROCEDURE [dbo].[sp_ValidateBarcodeAndGetOperatorInfo]
        ");

        // Drop the table
        Schema::dropIfExists('barcodes');
    }
};
