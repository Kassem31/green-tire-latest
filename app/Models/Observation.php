<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Observation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'Observations';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_ar',
        'name_en',
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
     * Get the inspection transaction observations for the observation.
     */
    public function inspectionTransactionObservations()
    {
        return $this->hasMany(InspectionTransactionObservation::class);
    }

    /**
     * Get the inspection transactions for the observation.
     */
    public function inspectionTransactions()
    {
        return $this->belongsToMany(InspectionTransaction::class, 'inspection_transaction_observations', 'observation_id', 'inspection_transaction_id');
    }

    /**
     * Get the user that created the observation.
     */
    public function creator()
    {
        return $this->belongsTo(AbpUser::class, 'created_by');
    }

    /**
     * Get the user that updated the observation.
     */
    public function updater()
    {
        return $this->belongsTo(AbpUser::class, 'updated_by');
    }

    /**
     * Get the user that deleted the observation.
     */
    public function deleter()
    {
        return $this->belongsTo(AbpUser::class, 'deleted_by');
    }
}
