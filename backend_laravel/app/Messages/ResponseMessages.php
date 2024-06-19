<?php

namespace App\Messages;

class ResponseMessages
{
    public static function messages()
    {
        return [
            'INTERNAL_ERROR' => 'An error occurred while processing your request.',
            'RETRIEVE_ERROR' => 'An error occurred while retrieving the data.',
            'CREATE_ERROR' => 'An error occurred while creating the data.',
            'UPDATE_ERROR' => 'An error occurred while updating the data.',
            'DELETE_ERROR' => 'An error occurred while deleting the data.',
            'SUCCESS' => 'Operation completed successfully.',
        ];
    }

    public static function getMessage($key)
    {
        $messages = self::messages();
        return $messages[$key] ?? 'An unexpected error occurred.';
    }
}
