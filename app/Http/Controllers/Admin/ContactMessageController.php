<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(Request $request): View
    {
        $query = ContactMessage::query();

        if ($request->query('status') === 'unread') {
            $query->unread();
        } elseif ($request->query('status') === 'read') {
            $query->where('is_read', true);
        }

        $messages = $query
            ->orderBy('is_read')
            ->orderByDesc('created_at')
            ->paginate((int) project('pagination_size', 15))
            ->withQueryString();

        $unreadCount = ContactMessage::unread()->count();

        return view('admin.messages.index', compact('messages', 'unreadCount'));
    }

    public function show(ContactMessage $message): View
    {
        if (! $message->is_read) {
            $message->markAsRead();
        }

        return view('admin.messages.show', compact('message'));
    }

    public function toggleRead(ContactMessage $message): RedirectResponse
    {
        $message->toggleRead();

        $status = $message->is_read ? 'read' : 'unread';

        return back()->with('toast_success', "Message marked as {$status}.");
    }

    public function destroy(ContactMessage $message): RedirectResponse
    {
        $message->delete();

        return redirect()
            ->route('admin.messages.index')
            ->with('toast_success', 'Message deleted.');
    }
}
