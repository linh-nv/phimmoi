<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendMessageRequest;
use App\Services\Client\ChatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    protected ChatService $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    /**
     * Gửi tin nhắn
     */
    public function sendMessage(Request $request): JsonResponse
    {
        try {
            $message = $this->chatService->sendMessage(
                roomCode: $request->room_code,
                userId: (int)Auth::id(),
                message: $request->message,
                type: $request->type ?? 'text',
                metadata: $request->metadata ?? []
            );

            return response()->json([
                'success' => true,
                'message' => 'Tin nhắn đã được gửi thành công',
                'data' => $message
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException ? 404 : 400);
        }
    }

    /**
     * Lấy tin nhắn trong phòng
     */
    public function getMessages(string $roomCode): JsonResponse
    {
        try {
            $messages = $this->chatService->getMessages(
                roomCode: $roomCode,
            );

            return response()->json([
                'success' => true,
                'data' => $messages,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Xóa tin nhắn
     */
    public function deleteMessage(int $messageId): JsonResponse
    {
        try {
            $success = $this->chatService->deleteMessage(
                messageId: $messageId,
                userId: Auth::id(),
            );

            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tin nhắn đã được xóa thành công'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa tin nhắn'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException ? 404 : 403);
        }
    }
}
