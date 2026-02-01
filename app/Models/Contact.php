<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'status',
        'admin_notes'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Status constants
    const STATUS_NEW = 'new';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_RESOLVED = 'resolved';

    public function getStatusBadgeAttribute()
    {
        $badges = [
            self::STATUS_NEW => '<span class="badge badge-warning">New</span>',
            self::STATUS_IN_PROGRESS => '<span class="badge badge-info">In Progress</span>',
            self::STATUS_RESOLVED => '<span class="badge badge-success">Resolved</span>',
        ];

        return $badges[$this->status] ?? '<span class="badge badge-secondary">Unknown</span>';
    }
}
