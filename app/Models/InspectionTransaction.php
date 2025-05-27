<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InspectionTransaction extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'barcode',
        'tire_type_id',
        'decision',
        'is_repaired',
        'building_date',
        'machine',
        'operator_name',
        'operator_code',
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
        'deleted_at' => 'datetime',
        'building_date' => 'datetime',
        'is_repaired' => 'boolean'
    ];

    /**
     * Get the tire type that belongs to the inspection transaction.
     */
    public function tireType()
    {
        return $this->belongsTo(TireType::class);
    }

    /**
     * Get the observations for the inspection transaction.
     */
    public function observations()
    {
        return $this->belongsToMany(Observation::class, 'inspection_transaction_observations')
                    ->withTimestamps();
    }

    /**
     * Get the repair transaction for the inspection transaction.
     */
    public function repairTransaction()
    {
        return $this->hasOne(RepairTransaction::class);
    }

    /**
     * Get the user that created the inspection transaction.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user that updated the inspection transaction.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the user that deleted the inspection transaction.
     */
    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
