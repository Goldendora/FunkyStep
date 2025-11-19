<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI;

class ChatbotController extends Controller
{
    public function ask(Request $request)
    {
        $question = $request->input('question');

        $client = OpenAI::factory()
            ->withApiKey(config('openai.api_key'))
            ->make();

        $response = $client->chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'Eres un asesor experto en zapatillas Funkystep.'
                ],
                [
                    'role' => 'user',
                    'content' => $question
                ]
            ]
        ]);

        return response()->json([
            'answer' => $response->choices[0]->message->content
        ]);
    }
}
