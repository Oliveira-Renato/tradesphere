<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class StockController
{
    /**
     * Retorna a lista de produtos com saldo de estoque.
     */
    public function index()
    {
        $products = Product::with(['inventory', 'tenant'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Se a requisição vier do Inertia (Frontend Vue 3)
        if (request()->header('X-Inertia')) {
            return Inertia::render('Welcome', [
                'user' => 'Renato',
                'products' => $products,
            ]);
        }

        // Retorno em JSON puro para consumo via API
        return response()->json($products);
    }

    /**
     * Realiza a baixa de estoque com concorrência segura (Pessimistic Lock)
     */
    public function reduce(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $updatedInventory = DB::transaction(function () use ($validated) {
                // Bloqueia a linha da tabela no PostgreSQL até o fim da transação
                $inventory = Inventory::where('product_id', $validated['product_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($inventory->quantity < $validated['quantity']) {
                    throw new \Exception("Estoque insuficiente. Saldo atual: {$inventory->quantity}");
                }

                $inventory->decrement('quantity', $validated['quantity']);

                return $inventory;
            });

            return response()->json([
                'success' => true,
                'message' => 'Estoque atualizado com sucesso!',
                'current_quantity' => $updatedInventory->quantity,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}