<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pagamento;
use App\Models\Reserva;
use Illuminate\Http\Request;

class PagamentoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        $pagamentos = Pagamento::whereHas('reserva.quadra', function($query) use ($empresa) {
            $query->where('empresa_id', $empresa->id);
        })->with('reserva.cliente.user', 'reserva.quadra')->paginate(10);

        return view('admin.pagamentos.index', compact('pagamentos', 'empresa'));
    }

    public function create()
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        $reservas = Reserva::whereHas('quadra', function($query) use ($empresa) {
            $query->where('empresa_id', $empresa->id);
        })->where('status', 'confirmado')->get();

        return view('admin.pagamentos.create', compact('reservas', 'empresa'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        $data = $request->validate([
            'reserva_id' => 'required|exists:reservas,id',
            'valor' => 'required|numeric|min:0',
            'metodo' => 'required|in:pix,cartao_credito,cartao_debito,dinheiro',
            'status' => 'required|in:pendente,pago,cancelado,estornado',
            'codigo_transacao' => 'nullable|string|max:255'
        ]);

        // Verificar se a reserva pertence à empresa
        $reserva = Reserva::findOrFail($data['reserva_id']);
        if ($reserva->quadra->empresa_id != $empresa->id) {
            abort(403, 'Reserva não pertence a esta empresa.');
        }

        Pagamento::create($data);

        return redirect()->route('admin.pagamentos.index')->with('success', 'Pagamento registrado com sucesso!');
    }

    public function show(Pagamento $pagamento)
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        if ($pagamento->reserva->quadra->empresa_id != $empresa->id) {
            abort(403, 'Acesso não autorizado.');
        }

        return view('admin.pagamentos.show', compact('pagamento'));
    }

    public function edit(Pagamento $pagamento)
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        if ($pagamento->reserva->quadra->empresa_id != $empresa->id) {
            abort(403, 'Acesso não autorizado.');
        }

        $reservas = Reserva::whereHas('quadra', function($query) use ($empresa) {
            $query->where('empresa_id', $empresa->id);
        })->where('status', 'confirmado')->get();

        return view('admin.pagamentos.edit', compact('pagamento', 'reservas'));
    }

    public function update(Request $request, Pagamento $pagamento)
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        if ($pagamento->reserva->quadra->empresa_id != $empresa->id) {
            abort(403, 'Acesso não autorizado.');
        }

        $data = $request->validate([
            'reserva_id' => 'required|exists:reservas,id',
            'valor' => 'required|numeric|min:0',
            'metodo' => 'required|in:pix,cartao_credito,cartao_debito,dinheiro',
            'status' => 'required|in:pendente,pago,cancelado,estornado',
            'codigo_transacao' => 'nullable|string|max:255'
        ]);

        // Verificar se a nova reserva pertence à empresa
        $reserva = Reserva::findOrFail($data['reserva_id']);
        if ($reserva->quadra->empresa_id != $empresa->id) {
            abort(403, 'Reserva não pertence a esta empresa.');
        }

        $pagamento->update($data);

        return redirect()->route('admin.pagamentos.index')->with('success', 'Pagamento atualizado com sucesso!');
    }

    public function destroy(Pagamento $pagamento)
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        if ($pagamento->reserva->quadra->empresa_id != $empresa->id) {
            abort(403, 'Acesso não autorizado.');
        }

        $pagamento->delete();

        return redirect()->route('admin.pagamentos.index')->with('success', 'Pagamento excluído com sucesso!');
    }

    public function search(Request $request)
    {
        $user = auth()->user();
        $empresa = $user->admin->empresa;

        $search = $request->get('search');
        $pagamentos = Pagamento::whereHas('reserva.quadra', function($query) use ($empresa) {
            $query->where('empresa_id', $empresa->id);
        })->where(function($query) use ($search) {
            $query->whereHas('reserva.cliente.user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('codigo_transacao', 'like', "%{$search}%");
        })->with('reserva.cliente.user', 'reserva.quadra')
          ->paginate(10);

        return view('admin.pagamentos.index', compact('pagamentos'));
    }
}