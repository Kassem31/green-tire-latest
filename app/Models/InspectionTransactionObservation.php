<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InspectionTransactionObservation extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inspection_transaction_observations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'inspection_transaction_id',
        'observation_id',
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
     * Get the inspection transaction that owns the observation relationship.
     */
    public function inspectionTransaction()
    {
        return $this->belongsTo(InspectionTransaction::class);
    }

    /**
     * Get the observation for this relationship.
     */
    public function observation()
    {
        return $this->belongsTo(Observation::class);
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
