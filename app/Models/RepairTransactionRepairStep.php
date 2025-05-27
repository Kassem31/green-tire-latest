<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepairTransactionRepairStep extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'repair_transaction_repair_steps';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'repair_transaction_id',
        'repair_step_id',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    /**
     * Get the repair transaction that owns the repair step relationship.
     */
    public function repairTransaction()
    {
        return $this->belongsTo(RepairTransaction::class);
    }

    /**
     * Get the repair step for this relationship.
     */
    public function repairStep()
    {
        return $this->belongsTo(RepairStep::class);
    }

    /**
     * Get the user that created the record.
     */
    public function creator()
    {
        return $this->belongsTo(AbpUser::class, 'created_by');
    }

    /**
     * Get the user that updated the record.
     */
    public function updater()
    {
        return $this->belongsTo(AbpUser::class, 'updated_by');
    }

    /**
     * Get the user that deleted the record.
     */
    public function deleter()
    {
        return $this->belongsTo(AbpUser::class, 'deleted_by');
    }
}
