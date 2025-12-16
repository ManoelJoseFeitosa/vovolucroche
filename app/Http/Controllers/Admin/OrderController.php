<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; // Importante
use App\Mail\OrderShippedMail; // Importante

class OrderController extends Controller
{
    /**
     * Lista todos os pedidos
     */
    public function index()
    {
        // Pedidos mais recentes primeiro
        $orders = Order::latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Mostra detalhes de um pedido específico
     */
    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Marca pedido como enviado e dispara e-mail
     */
    public function markAsShipped(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        // Atualiza status
        $order->status = 'shipped';
        
        // Se você tiver uma coluna tracking_code na tabela orders, descomente abaixo:
        // $order->tracking_code = $request->tracking_code;
        
        $order->save();

        // Envia o e-mail de aviso
        if($order->customer_email) {
            try {
                Mail::to($order->customer_email)->send(new OrderShippedMail($order, $request->tracking_code));
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Pedido salvo, mas erro ao enviar e-mail: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Pedido marcado como enviado e cliente notificado!');
    }
}
