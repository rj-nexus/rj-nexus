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
        'source',
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
            $existing->name = $name ?: $existing->name;
            $existing->status = 'active';
            $existing->unsubscribed_at = null;
            $existing->save();
            return $existing;
        }

        $subscriber = new static([
            'email'  => $email,
            'name'   => $name,
            'source' => $source,
        ]);

        $subscriber->status = 'active';
        $subscriber->ip_address = request()->ip();
        $subscriber->user_agent = substr((string) request()->userAgent(), 0, 255);
        $subscriber->confirmed_at = now();
        $subscriber->save();

        return $subscriber;
    }

    public function unsubscribe(): void
    {
        $this->status = 'unsubscribed';
        $this->unsubscribed_at = now();
        $this->save();
    }
}
