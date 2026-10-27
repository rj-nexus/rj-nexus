<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsletterSubscriber extends Model
{
    protected $table = 'rj_newsletter_subscribers';

    protected $fillable = [
        'email',
        'name',
        'status',
        'source',
        'token',
        'ip_address',
        'user_agent',
        'confirmed_at',
        'unsubscribed_at',
    ];

    protected $casts = [
        'confirmed_at'    => 'datetime',
        'unsubscribed_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->token)) {
                $model->token = Str::random(64);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeUnsubscribed($query)
    {
        return $query->where('status', 'unsubscribed');
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public static function subscribe(string $email, ?string $name = null, string $source = 'widget'): self
    {
        $email = strtolower(trim($email));

        $existing = static::where('email', $email)->first();
        if ($existing) {
            $existing->update([
                'name'            => $name ?: $existing->name,
                'status'          => 'active',
                'unsubscribed_at' => null,
            ]);
            return $existing;
        }

        return static::create([
            'email'        => $email,
            'name'         => $name,
            'status'       => 'active',
            'source'       => $source,
            'ip_address'   => request()->ip(),
            'user_agent'   => substr((string) request()->userAgent(), 0, 255),
            'confirmed_at' => now(),
        ]);
    }

    public function unsubscribe(): void
    {
        $this->update([
            'status'          => 'unsubscribed',
            'unsubscribed_at' => now(),
        ]);
    }
}
