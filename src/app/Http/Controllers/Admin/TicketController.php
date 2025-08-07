<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::with(['user', 'replies']);

        // فیلترها
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // مرتب‌سازی
        $sort = $request->get('sort', 'created_at_desc');
        switch ($sort) {
            case 'created_at_asc':
                $query->oldest();
                break;
            case 'last_reply_asc':
                $query->orderBy('last_reply_at', 'asc');
                break;
            case 'last_reply_desc':
                $query->orderBy('last_reply_at', 'desc');
                break;
            case 'priority_desc':
                $query->orderByRaw("FIELD(priority, 'urgent', 'high', 'medium', 'low')");
                break;
            default:
                $query->latest();
                break;
        }

        $tickets = $query->paginate(20)->withQueryString();

        return view('admin.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['user', 'replies.user']);
        return view('admin.tickets.show', compact('ticket'));
    }

    public function reply(Request $request, Ticket $ticket)
    {
        $request->validate([
            'message' => 'required|string|min:5'
        ]);

        TicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'message' => $request->message,
            'is_admin_reply' => true
        ]);

        $ticket->markAsAnswered();

        return redirect()->route('admin.tickets.show', $ticket)
            ->with('success', 'پاسخ شما با موفقیت ارسال شد.');
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => 'required|in:open,in_progress,answered,closed'
        ]);

        $ticket->update(['status' => $request->status]);

        if ($request->status === 'closed') {
            $ticket->close();
        }

        return redirect()->route('admin.tickets.show', $ticket)
            ->with('success', 'وضعیت تیکت با موفقیت بروزرسانی شد.');
    }

    public function close(Ticket $ticket)
    {
        $ticket->close();
        return redirect()->route('admin.tickets.index')
            ->with('success', 'تیکت با موفقیت بسته شد.');
    }
}
