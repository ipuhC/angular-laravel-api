<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request, $targetUserId)
    {
        $currentUserId = $request->input('currentUserId');

        $currentUser = User::find($currentUserId);
        $targetUser = User::find($targetUserId);

        if (!$currentUser || !$targetUser) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $currentUser->subscriptions()->attach($targetUserId);

        return response()->json(['message' => 'Suscripción exitosa']);
    }

    public function unsubscribe(Request $request, $targetUserId)
    {
        $subscriberId = $request->input('subscriberId');

        $subscriber = User::find($subscriberId);
        $targetUser = User::find($targetUserId);

        if (!$subscriber || !$targetUser) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $subscriber->subscriptions()->detach($targetUserId);

        return response()->json(['message' => 'Cancelación de suscripción exitosa']);
    }

    public function getSubscribers($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $subscribers = $user->subscriptions; // Asume que tienes una relación 'subscriptions' definida en el modelo User

        return response()->json(['subscribers' => $subscribers]);
    }
}
