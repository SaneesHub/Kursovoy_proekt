<?php

namespace App\Http\Controllers;

use App\Models\UserRequest;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function createRequest(Request $request)
    {
        // Проверяем авторизацию
        if (!auth()->check()) {
            return response()->json(['error' => 'Требуется авторизация'], 401);
        }

        $user = auth()->user();

        try {
            // Создаем запрос с ВСЕМИ обязательными полями
            $userRequest = UserRequest::create([
                'id_user' => $user->id_user,  // Добавляем id пользователя
                'id_role' => $user->id_role,  // Добавляем роль пользователя
                'type_request' => 'Обращение в поддержку',
                'date_request' => now(),
                'status_review' => false
            ]);

            // Создаем первое сообщение
            $message = Message::create([
                'id_user' => $user->id_user,
                'id_role' => $user->id_role,
                'id_request' => $userRequest->id_request,
                'content' => $request->input('message', 'Новое обращение'),
                'date_sending' => now()
            ]);

            return response()->json([
                'success' => true,
                'request_id' => $userRequest->id_request,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            \Log::error('Ошибка создания запроса: '.$e->getMessage());
            return response()->json([
                'error' => 'Ошибка при создании запроса',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function getMessages($request_id)
    {
        $messages = Message::where('id_request', $request_id)
            ->with('sender')
            ->orderBy('date_sending')
            ->get();

        return response()->json($messages);
    }

    public function sendMessage(Request $request, $request_id)
    {
        \Log::info('Попытка отправки сообщения', [
            'user' => auth()->id(),
            'data' => $request->all(),
            'headers' => $request->headers->all()
        ]);

        try {
            $message = Message::create([
                'id_user' => auth()->id(),
                'id_role' => auth()->user()->id_role,
                'id_request' => $request_id,
                'content' => $request->input('content'),
                'date_sending' => now()
            ]);

            \Log::info('Сообщение создано', ['message_id' => $message->id_message]);

            return response()->json($message);

        } catch (\Exception $e) {
            \Log::error('Ошибка отправки', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function listRequests()
    {
        $requests = UserRequest::with(['user', 'messages'])
            ->where('status_review', false)
            ->get();

        return view('support.requests', compact('requests'));
    }
}