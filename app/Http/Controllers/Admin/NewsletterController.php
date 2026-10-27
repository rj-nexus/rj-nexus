<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendNewsletterEmail;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function index(Request $request)
    {
        $query = NewsletterSubscriber::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $subscribers = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        $totalCount = NewsletterSubscriber::count();
        $activeCount = NewsletterSubscriber::active()->count();
        $unsubCount = NewsletterSubscriber::unsubscribed()->count();

        return view('admin.newsletter.index', compact('subscribers', 'totalCount', 'activeCount', 'unsubCount'));
    }

    public function destroy(NewsletterSubscriber $subscriber)
    {
        $subscriber->delete();
        return back()->with('success', __('Subscriber deleted successfully.'));
    }

    public function sendBulk(Request $request)
    {
        $data = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'body'    => ['required', 'string'],
        ]);

        $activeSubscribers = NewsletterSubscriber::active()->get();
        $count = $activeSubscribers->count();

        if ($count === 0) {
            return back()->with('error', __('There are no active subscribers to send emails to.'));
        }

        foreach ($activeSubscribers as $subscriber) {
            SendNewsletterEmail::dispatch($subscriber, $data['subject'], $data['body']);
        }

        return back()->with('success', __('Emails have been queued for sending to :count subscribers.', ['count' => $count]));
    }
}
