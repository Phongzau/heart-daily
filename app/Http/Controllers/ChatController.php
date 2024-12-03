<?php

namespace App\Http\Controllers;

use App\Services\ChatService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    protected $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function startChat(Request $request)
    {
        $customerId = $request->user()->id;
        $admin = $this->chatService->assignToAdmin($customerId);

        if (!$admin) {
            return response()->json(['message' => 'No admin available. Message added to pending queue.'], 200);
        }

        return response()->json(['message' => 'Chat assigned to admin.', 'admin' => $admin], 200);
    }

    public function processPending()
    {
        $this->chatService->processPendingMessages();

        return response()->json(['message' => 'Pending messages processed.'], 200);
    }
}
