<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pagamento #{{ $pagamento->id }}</title>

    <style>
        body { font-family: sans-serif; padding: 20px; }
        h1 { font-size: 22px; margin-bottom: 10px; }
        h2 { font-size: 18px; margin-top: 25px; }
        .box { padding: 12px; border: 1px solid #ccc; margin-top: 10px; }
        .label { font-weight: bold; }
    </style>
</head>
<body>

    <h1>Extrato de Pagamento</h1>
    <p><strong>Empresa:</strong> {{ $empresa->nome }}</p>
    <p><strong>Data:</strong> {{ now()->format('d/m/Y H:i') }}</p>

    <h2>Informações do Pagamento</h2>
    <div class="box">
        <p><span class="label">ID:</span> {{ $pagamento->id }}</p>
        <p><span class="label">Valor:</span> R$ {{ number_format($pagamento->valor, 2, ',', '.') }}</p>
        <p><span class="label">Método:</span> {{ ucfirst(str_replace('_', ' ', $pagamento->metodo)) }}</p>
        <p><span class="label">Status:</span> {{ ucfirst($pagamento->status) }}</p>
        <p><span class="label">Código da Transação:</span> {{ $pagamento->codigo_transacao ?? '—' }}</p>
    </div>

    <h2>Dados da Reserva</h2>
    <div class="box">
        <p><span class="label">Cliente:</span> {{ $pagamento->reserva->cliente->user->name }}</p>
        <p><span class="label">Quadra:</span> {{ $pagamento->reserva->quadra->nome }}</p>

        <p><span class="label">Data da Reserva:</span>
            {{ \Carbon\Carbon::parse($pagamento->reserva->data_reserva)->format('d/m/Y') }}
        </p>

        <p><span class="label">Horário:</span>
            {{ \Carbon\Carbon::parse($pagamento->reserva->horario->horario_inicio)->format('H:i') }}
            às
            {{ \Carbon\Carbon::parse($pagamento->reserva->horario->horario_fim)->format('H:i') }}
        </p>
    </div>


</body>
</html>
