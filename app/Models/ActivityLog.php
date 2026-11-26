<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    use HasFactory;

    public const ACTOR_ADMIN = 'admin';
    public const ACTOR_STAFF = 'staff';
    public const ACTOR_QR_GUEST = 'qr_guest';
    public const ACTOR_SYSTEM = 'system';

    public const ACTOR_TYPES = [
        self::ACTOR_ADMIN,
        self::ACTOR_STAFF,
        self::ACTOR_QR_GUEST,
        self::ACTOR_SYSTEM,
    ];

    protected $fillable = [
        'user_id',
        'actor_type',
        'event',
        'subject_type',
        'subject_id',
        'description',
        'properties',
    ];

    protected function casts(): array
    {
        return [
            'properties' => 'array',
        ];
    }

    public static function record(
        ?Model $subject,
        string $event,
        string $description,
        array $properties = [],
        ?string $actorType = null,
        ?int $userId = null,
    ): self {
        $authUser = auth()->user();

        if ($actorType === null) {
            if ($authUser instanceof User) {
                $actorType = $authUser->isAdmin() ? self::ACTOR_ADMIN : self::ACTOR_STAFF;
            } else {
                $actorType = self::ACTOR_SYSTEM;
            }
        }

        return self::create([
            'user_id' => $userId ?? ($actorType === self::ACTOR_QR_GUEST || $actorType === self::ACTOR_SYSTEM ? null : auth()->id()),
            'actor_type' => $actorType,
            'event' => $event,
            'subject_type' => $subject?->getMorphClass(),
            'subject_id' => $subject?->getKey(),
            'description' => $description,
            'properties' => empty($properties) ? null : $properties,
        ]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }
}
