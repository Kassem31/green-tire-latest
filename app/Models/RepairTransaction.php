<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepairTransaction extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'inspection_transaction_id',
        'decision',
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
     * Get the inspection transaction that owns the repair transaction.
     */
    public function inspectionTransaction()
    {
        return $this->belongsTo(InspectionTransaction::class);
    }

    /**
     * Get the repair steps for the repair transaction.
     */
    public function repairSteps()
    {
        return $this->belongsToMany(RepairStep::class, 'repair_transaction_repair_steps')
                    ->withTimestamps();
    }

    /**
     * Get the user that created the repair transaction.
     */
    public function creator()
    {
        return $this->belongsTo(AbpUser::class, 'created_by');
    }

    /**
     * Get the user that updated the repair transaction.
     */
    public function updater()
    {
        return $this->belongsTo(AbpUser::class, 'updated_by');
    }

    /**
     * Get the user that deleted the repair transaction.
     */
    public function deleter()
    {
        return $this->belongsTo(AbpUser::class, 'deleted_by');
    }
}
