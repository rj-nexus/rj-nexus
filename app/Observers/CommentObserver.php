<?php

namespace App\Observers;

use App\Models\Comment;
use App\Models\Notification;
use App\Models\User;
use App\Models\NotificationSetting;
use Illuminate\Support\Facades\Log;

class CommentObserver
{
    public function created(Comment $comment): void
    {
        // Spam və ya zibil şərhlər üçün bildiriş göndərmirik
        if (in_array($comment->status, ['spam', 'trash'])) {
            return;
        }

        // YENİ: Həm admin, həm də super-admin-ləri tapırıq
        $admins = User::whereIn('role', ['admin', 'super-admin'])->get();
        
        if ($admins->isEmpty()) {
            Log::warning('CommentObserver: Heç bir admin tapılmadı.');
            return;
        }

        foreach ($admins as $admin) {
            // YENİ: Əgər şərhi yazan özüdürsə, ona bildiriş getməsin
            if ($admin->id === $comment->user_id) {
                continue;
            }

            // YENİ: İstifadəçinin bu bildirişi istəyib-istəmədiyini yoxlayırıq
            if (class_exists(NotificationSetting::class)) {
                $isEnabled = NotificationSetting::isEnabled($admin, 'new_comment', 'database');
                if (!$isEnabled) {
                    Log::info("CommentObserver: Admin {$admin->id} şərh bildirişlərini söndürüb.");
                    continue;
                }
            }

            Notification::create([
                'user_id' => $admin->id,
                'type' => 'comment',
                'title' => __('New Comment Received'),
                'message' => __(':author commented on: :post', [
                    'author' => $comment->author_name,
                    'post' => $comment->post?->title ?? __('Unknown Post')
                ]),
                'icon' => 'chat', 
                'color' => '#8b5cf6',
                'action_url' => route('admin.comments.show', $comment->id),
                'action_label' => __('View Comment'),
            ]);

            Log::info("CommentObserver: Admin {$admin->id} üçün yeni şərh bildirişi yaradıldı.");
        }
    }
}