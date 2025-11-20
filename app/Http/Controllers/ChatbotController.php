<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;
use App\Models\Product;

class ChatbotController extends Controller
{
    public function ask(Request $request)
    {
        $question = $request->input('question');

        // 1️⃣ Obtener catálogo
        $products = Product::where('is_active', true)
            ->select('name', 'brand', 'category', 'price', 'stock')
            ->get()
            ->toArray();

        // 2️⃣ Crear cliente
        $client = \OpenAI::factory()
            ->withApiKey(env('OPENAI_API_KEY'))
            ->make();

        // 3️⃣ Instrucciones estrictas (no inventar productos)
        $systemPrompt = <<<EOT
            Eres un asesor del e-commerce Funkystep.
            Debes responder **solo con información del catálogo proporcionado**.
            Si un usuario pregunta por un producto que **NO está en el catálogo**, responde exactamente:
            "Lo siento, ese producto no está disponible en Funkystep.",e interactua con el usuario para ayudarle a encontrar alternativas, juega unicamnete con la informacion de la base de datos.

            No inventes zapatillas, colores, tallas ni marcas que no aparezcan en la lista.
            EOT;

        // 4️⃣ Llamada al modelo
        $response = $client->chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                ['role' => 'system', 'content' => $systemPrompt],
                [
                    'role' => 'user',
                    'content' =>
                        "Pregunta del usuario: {$question}\n" .
                        "Catálogo disponible: " . json_encode($products, JSON_PRETTY_PRINT)
                ],
            ],
        ]);

        return response()->json([
            'answer' => $response->choices[0]->message->content
        ]);
    }
}
