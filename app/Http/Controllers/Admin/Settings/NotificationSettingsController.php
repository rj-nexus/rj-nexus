<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationSettingsController extends Controller
{
    public function index()
    {
        $defaults = [
            'admin_email' => rj_get_option('admin_email', config('mail.from.address', 'admin@example.com')),
            'events' => [
                'update_available' => true,
                'failed_login' => true,
                'backup_failed' => true,
                'system_error' => true,
            ],
        ];

        $rawSettings = rj_get_option('notifications_settings');
        $settings = $rawSettings ? json_decode($rawSettings, true) : $defaults;
        
        $settings['events'] = array_merge($defaults['events'], $settings['events'] ?? []);

        return view('admin.settings.notifications', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'admin_email' => 'required|email|max:255',
            'events' => 'nullable|array',
            'events.*' => 'boolean',
        ]);

        $events = [
            'update_available' => $request->boolean('events.update_available'),
            'failed_login' => $request->boolean('events.failed_login'),
            'backup_failed' => $request->boolean('events.backup_failed'),
            'system_error' => $request->boolean('events.system_error'),
        ];

        $settings = [
            'admin_email' => $validated['admin_email'],
            'events' => $events,
        ];

        rj_set_option('notifications_settings', json_encode($settings));
        rj_flush_options();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('System notification settings saved.'),
            ]);
        }

        return back()->with('success', __('System notification settings saved.'));
    }
}