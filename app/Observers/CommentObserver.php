<?php

namespace App\Observers;

use App\Models\Comment;
use App\Models\Notification;
use App\Models\User;

class CommentObserver
{
    /**
     * Şərh yaradıldıqdan dərhal sonra işə düşür.
     */
    public function created(Comment $comment): void
    {
        // Spam və ya zibil şərhlər üçün bildiriş göndərmirik
        if (in_array($comment->status, ['spam', 'trash'])) {
            return;
        }

        // Bildirişi kimə göndərəcəyik? Bütün Adminlərə.
        // Qeyd: Əgər sisteminizdə rol (role) fərqlidirsə, User modelinə uyğun dəyişin.
        $admins = User::where('role', 'admin')->get(); 
        
        // Əgər admin tapılmasa, heç nə etmə
        if ($admins->isEmpty()) {
            return;
        }

        foreach ($admins as $admin) {
            // Şərhi yazan özüdürsə, ona bildiriş getməsin
            if ($admin->id === $comment->user_id) {
                continue;
            }

            // Bildiriş parametrlərini yoxlayaq (istifadəçi bu bildirişi istəyirmi?)
            // Əgər NotificationSetting modeliniz varsa, onu yoxlaya bilərsiniz.
            // Hazırda birbaşa yaradırıq.

            Notification::create([
                'user_id' => $admin->id,
                'type' => 'comment',
                'title' => __('New Comment Received'),
                'message' => __(':author commented on: :post', [
                    'author' => $comment->author_name,
                    'post' => $comment->post?->title ?? 'Unknown Post'
                ]),
                'icon' => 'chat', // Admin paneldəki ikon
                'color' => 'blue',
                'action_url' => route('admin.comments.show', $comment->id), // Klikləyəndə hara getsin
                'action_label' => __('View Comment'),
            ]);
        }
    }
}