<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TireType extends Model
{
    use HasFactory, SoftDeletes;

    const GREEN_TIRE_ID = 2;


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
     * Get the inspection transactions for the tire type.
     */
    public function inspectionTransactions()
    {
        return $this->hasMany(InspectionTransaction::class);
    }

    /**
     * Get the user that created the tire type.
     */
    public function creator()
    {
        return $this->belongsTo(AbpUser::class, 'created_by');
    }

    /**
     * Get the user that updated the tire type.
     */
    public function updater()
    {
        return $this->belongsTo(AbpUser::class, 'updated_by');
    }

    /**
     * Get the user that deleted the tire type.
     */
    public function deleter()
    {
        return $this->belongsTo(AbpUser::class, 'deleted_by');
    }
}
