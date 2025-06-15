<?php

namespace App\Services\Client;

use App\Events\MessageDeleted;
use App\Events\MessageSent;
use App\Models\PremiereRoom;
use App\Models\PremiereRoomMessage;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChatService
{
    /**
     * Gửi tin nhắn
     */
    public function sendMessage(
        string $roomCode,
        int $userId,
        string $message,
        string $type = 'text',
        array $metadata = []
    ): PremiereRoomMessage {
        try {
            DB::beginTransaction();

            // Validate room exists and user has access
            $room = PremiereRoom::where('code', $roomCode)->firstOrFail();
            $user = User::findOrFail($userId);

            if (!$room->canAccess($user)) {
                throw new \Exception('Không có quyền truy cập phòng này');
            }

            // Validate message
            $this->validateMessage($message, $type);

            // Create message
            $messageModel = PremiereRoomMessage::create([
                'premiere_room_code' => $roomCode,
                'user_id' => $userId,
                'message' => trim($message),
                'type' => $type,
                'metadata' => $metadata,
            ]);

            // Load relationships
            $messageModel->load('user');

            // Broadcast event
            event(new MessageSent($messageModel));

            // Update cache
            $this->updateMessageCache($roomCode, $messageModel);

            DB::commit();
            return $messageModel;
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Failed to send message', [
                'room_code' => $roomCode,
                'user_id' => $userId,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Lấy tin nhắn trong phòng
     */
    public function getMessages(string $roomCode)
    {

        return PremiereRoomMessage::byRoom($roomCode)
            ->notDeleted()
            ->with(['user'])
            ->oldest()
            ->get();
    }

    /**
     * Xóa tin nhắn
     */
    public function deleteMessage(
        int $messageId,
        int $userId,
    ): bool {
        try {
            $message = PremiereRoomMessage::findOrFail($messageId);

            $success = $message->softDeleteMessage();

            if ($success) {
                // Clear cache
                $this->clearMessageCache($message->premiere_room_code);

                broadcast(new MessageDeleted($message));
            }

            return $success;
        } catch (\Exception $e) {
            Log::error('Failed to delete message', [
                'message_id' => $messageId,
                'user_id' => $userId,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Gửi tin nhắn hệ thống
     */
    public function sendSystemMessage(
        string $roomCode,
        string $message,
        array $metadata = []
    ): PremiereRoomMessage {
        // System messages don't need user validation
        $messageModel = PremiereRoomMessage::create([
            'premiere_room_code' => $roomCode,
            'user_id' => 1, // System user ID (có thể tạo user hệ thống)
            'message' => $message,
            'type' => 'system',
            'metadata' => $metadata,
        ]);

        $messageModel->load('user');

        // Broadcast system message
        broadcast(new MessageSent($messageModel));

        // Update cache
        $this->updateMessageCache($roomCode, $messageModel);

        return $messageModel;
    }


    /**
     * Validate tin nhắn
     */
    private function validateMessage(string $message, string $type): void
    {
        $message = trim($message);

        if (empty($message)) {
            throw new \Exception('Tin nhắn không được để trống');
        }

        if (strlen($message) > 500) {
            throw new \Exception('Tin nhắn không được vượt quá 500 ký tự');
        }

        if (!in_array($type, ['text', 'system', 'emoji'])) {
            throw new \Exception('Loại tin nhắn không hợp lệ');
        }

        // Add more validation rules as needed
        if ($this->containsInappropriateContent($message)) {
            throw new \Exception('Tin nhắn chứa nội dung không phù hợp');
        }
    }

    /**
     * Kiểm tra nội dung không phù hợp (cơ bản)
     */
    private function containsInappropriateContent(string $message): bool
    {
        // Implement your content filtering logic here
        $bannedWords = ['spam', 'scam']; // Add your banned words

        foreach ($bannedWords as $word) {
            if (stripos($message, $word) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Cập nhật cache tin nhắn
     */
    private function updateMessageCache(string $roomCode, PremiereRoomMessage $message): void
    {
        $cacheKey = "room_messages:{$roomCode}:latest:50";
        Cache::forget($cacheKey);

        // Clear stats cache
        Cache::forget("room_stats:{$roomCode}");
    }

    /**
     * Xóa cache tin nhắn
     */
    private function clearMessageCache(string $roomCode): void
    {
        $patterns = [
            "room_messages:{$roomCode}:*",
            "room_stats:{$roomCode}",
        ];

        foreach ($patterns as $pattern) {
            Cache::forget($pattern);
        }
    }
}
