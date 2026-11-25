<?php

namespace App\Observers;

use App\Models\Comment;
use App\Models\Notification;
use App\Models\User;
use App\Models\NotificationSetting;

class CommentObserver
{
    public function created(Comment $comment): void
    {
        if (in_array($comment->status, ['spam', 'trash'])) {
            return;
        }

        $admins = User::where('role', 'admin')->get();
        
        if ($admins->isEmpty()) {
            return;
        }

        foreach ($admins as $admin) {
            if ($admin->id === $comment->user_id) {
                continue;
            }

            // Əgər NotificationSetting modelin varsa, istifadəçinin bu bildirişi istəyib-istəmədiyini yoxlayaq
            if (class_exists(NotificationSetting::class)) {
                $isEnabled = NotificationSetting::isEnabled($admin, 'comment', 'database');
                if (!$isEnabled) {
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
                'color' => 'blue',
                'action_url' => route('admin.comments.show', $comment->id),
                'action_label' => __('View Comment'),
            ]);
        }
    }
}