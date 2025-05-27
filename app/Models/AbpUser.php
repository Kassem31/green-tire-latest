<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AbpUser extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'abp_users';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tenant_id',
        'user_name',
        'normalized_user_name',
        'name',
        'surname',
        'email',
        'normalized_email',
        'email_confirmed',
        'password_hash',
        'security_stamp',
        'is_external',
        'phone_number',
        'phone_number_confirmed',
        'is_active',
        'two_factor_enabled',
        'lockout_end',
        'lockout_enabled',
        'access_failed_count',
        'should_change_password_on_next_login',
        'entity_version',
        'last_password_change_time',
        'extra_properties',
        'concurrency_stamp',
        'creation_time',
        'creator_id',
        'last_modification_time',
        'last_modifier_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_confirmed' => 'boolean',
        'is_external' => 'boolean',
        'phone_number_confirmed' => 'boolean',
        'is_active' => 'boolean',
        'two_factor_enabled' => 'boolean',
        'lockout_enabled' => 'boolean',
        'should_change_password_on_next_login' => 'boolean',
        'is_deleted' => 'boolean',
        'creation_time' => 'datetime',
        'last_modification_time' => 'datetime',
        'deletion_time' => 'datetime',
        'last_password_change_time' => 'datetime',
        'lockout_end' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password_hash',
        'security_stamp',
    ];
}
