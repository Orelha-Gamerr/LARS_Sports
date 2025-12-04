<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #4a5568;
        }
        .header h1 {
            color: #2d3748;
            margin: 0 0 5px 0;
            font-size: 24px;
        }
        .header .empresa {
            color: #4a5568;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .header .data {
            color: #718096;
            font-size: 11px;
        }
        .summary {
            margin: 20px 0;
            padding: 15px;
            background: #f7fafc;
            border-radius: 6px;
            border-left: 4px solid #4299e1;
        }
        .summary h3 {
            margin-top: 0;
            color: #2d3748;
            font-size: 14px;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 10px;
        }
        .summary-item {
            text-align: center;
            padding: 10px;
            background: white;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .summary-value {
            font-size: 20px;
            font-weight: bold;
            color: #2d3748;
            display: block;
        }
        .summary-label {
            font-size: 11px;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 11px;
        }
        table th {
            background-color: #4a5568;
            color: white;
            padding: 10px 8px;
            text-align: left;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.5px;
        }
        table td {
            padding: 10px 8px;
            border: 1px solid #e2e8f0;
            vertical-align: top;
        }
        table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .status {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .status-disponivel {
            background-color: #c6f6d5;
            color: #22543d;
        }
        .status-indisponivel {
            background-color: #fed7d7;
            color: #742a2a;
        }
        .tipo {
            display: inline-block;
            padding: 4px 10px;
            background-color: #e2e8f0;
            color: #4a5568;
            border-radius: 4px;
            font-size: 10px;
            text-transform: capitalize;
        }
        .valor {
            font-weight: bold;
            color: #2d3748;
        }
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            color: #718096;
            font-size: 10px;
        }
        .no-data {
            text-align: center;
            padding: 30px;
            color: #718096;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="empresa">{{ $empresa->nome }}</div>
        <h1>{{ $title }}</h1>
        <div class="data">Gerado em: {{ $date }}</div>
    </div>

    <div class="summary">
        <h3>Resumo Geral</h3>
        <div class="summary-grid">
            <div class="summary-item">
                <span class="summary-value">{{ $totalQuadras }}</span>
                <span class="summary-label">Total de Quadras</span>
            </div>
            <div class="summary-item">
                <span class="summary-value">{{ $disponiveis }}</span>
                <span class="summary-label">Disponíveis</span>
            </div>
            <div class="summary-item">
                <span class="summary-value">{{ $indisponiveis }}</span>
                <span class="summary-label">Indisponíveis</span>
            </div>
        </div>
    </div>

    @if($quadras->count() > 0)
    <table>
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th>Nome</th>
                <th>Tipo</th>
                <th>Preço/Hora</th>
                <th>Capacidade</th>
                <th>Status</th>
                <th>Descrição</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quadras as $quadra)
            <tr>
                <td>#{{ $quadra->id }}</td>
                <td><strong>{{ $quadra->nome }}</strong></td>
                <td><span class="tipo">{{ $quadra->tipo }}</span></td>
                <td class="valor">R$ {{ number_format($quadra->preco_hora, 2, ',', '.') }}</td>
                <td>{{ $quadra->capacidade }} pessoas</td>
                <td>
                    <span class="status status-{{ $quadra->disponivel ? 'disponivel' : 'indisponivel' }}">
                        {{ $quadra->disponivel ? 'Disponível' : 'Indisponível' }}
                    </span>
                </td>
                <td>{{ $quadra->descricao ?? 'Não informada' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="no-data">
        Nenhuma quadra cadastrada para esta empresa.
    </div>
    @endif

    <div class="footer">
        <p>Documento gerado automaticamente pelo sistema Lars Sports</p>
    </div>
</body>
</html>