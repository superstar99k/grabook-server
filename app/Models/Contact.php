<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $company
 * @property string $name
 * @property string $email
 * @property string $message
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 */
class Contact extends EloquentModel
{
    use HasFactory;

    /**
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'company' => 'string',
        'name' => 'string',
        'email' => 'string',
        'message' => 'string',
        'created_at' => 'immutable_datetime',
        'updated_at' => 'immutable_datetime',
    ];
}
