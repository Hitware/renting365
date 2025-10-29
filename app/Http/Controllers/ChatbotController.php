<?php

namespace App\Http\Controllers;

use App\Services\SimpleChatbotService;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    protected $chatbotService;

    public function __construct(SimpleChatbotService $chatbotService)
    {
        $this->chatbotService = $chatbotService;
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $response = $this->chatbotService->getResponse($request->message);

        return response()->json($response);
    }
}
