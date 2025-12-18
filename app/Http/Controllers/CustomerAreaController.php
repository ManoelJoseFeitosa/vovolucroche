<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class CustomerAreaController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Pedidos em andamento (Pending, Paid, Shipped)
        $activeOrders = Order::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'paid', 'shipped', 'confeccao']) // Adicione seus status aqui
            ->with('items')
            ->orderBy('created_at', 'desc')
            ->get();

        // Pedidos concluídos
        $pastOrders = Order::where('user_id', $user->id)
            ->where('status', 'completed') // Status 'completed' ou 'delivered'
            ->with(['items.product.reviews' => function($q) use($user){
                $q->where('user_id', $user->id); // Verifica se já avaliou
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('site.dashboard', compact('activeOrders', 'pastOrders'));
    }

    public function markAsReceived($id)
    {
        $order = Order::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        $order->update(['status' => 'completed']);
        return back()->with('success', 'Pedido marcado como recebido! Agora você pode avaliar.');
    }

    public function reviewProduct(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        Review::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $request->product_id],
            ['rating' => $request->rating, 'comment' => $request->comment]
        );

        return back()->with('success', 'Obrigado pela sua avaliação!');
    }

    public function buyAgain($orderId)
    {
        $order = Order::with('items')->where('user_id', Auth::id())->where('id', $orderId)->firstOrFail();
        $cart = session()->get('cart', []);

        foreach ($order->items as $item) {
            $cart[$item->product_id] = [
                "name" => $item->product_name,
                "quantity" => $item->quantity,
                "price" => $item->price,
                "image" => $item->product->image ?? '' // Assumindo relação
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Produtos adicionados ao carrinho!');
    }
}
