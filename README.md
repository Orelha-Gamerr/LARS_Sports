# LARS Sports

Sistema de agendamento e gestão de quadras esportivas.

## Estrutura do Projeto

```
lars-sports/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── QuadraController.php
│   │   │   │   ├── ReservaController.php
│   │   │   │   └── RelatorioController.php
│   │   │   ├── ClienteController.php
│   │   │   └── HomeController.php
│   ├── Models/
│   │   ├── Cliente.php
│   │   ├── Quadra.php
│   │   ├── Reserva.php
│   │   └── Pagamento.php
│   └── Policies/
│       └── QuadraPolicy.php
├── database/
│   ├── migrations/
│   │   ├── 2025_05_28_000001_create_clientes_table.php
│   │   ├── 2025_05_28_000002_create_quadras_table.php
│   │   ├── 2025_05_28_000003_create_reservas_table.php
│   │   └── 2025_05_28_000004_create_pagamentos_table.php
│   └── seeders/
│       ├── ClienteSeeder.php
│       ├── QuadraSeeder.php
│       └── ReservaSeeder.php
├── resources/
│   ├── views/
│   │   ├── auth/
│   │   │   ├── login.blade.php
│   │   │   └── register.blade.php
│   │   ├── admin/
│   │   │   ├── quadras/
│   │   │   │   ├── index.blade.php
│   │   │   │   ├── create.blade.php
│   │   │   │   └── edit.blade.php
│   │   │   ├── reservas/
│   │   │   │   ├── index.blade.php
│   │   │   │   └── relatorios.blade.php
│   │   │   └── dashboard.blade.php
│   │   ├── cliente/
│   │   │   ├── reservas.blade.php
│   │   │   └── perfil.blade.php
│   │   └── layouts/
│   │       └── app.blade.php
├── routes/
│   └── web.php
└── tests/
```

## Models e Relacionamentos

* **Cliente**: nome, CPF, telefone, e-mail; relaciona-se com várias reservas.
* **Quadra**: descrição, tipo de esporte, preço por hora, horário de funcionamento, ativo; relaciona-se com várias reservas.
* **Reserva**: data, hora de início, duração, cliente_id, quadra_id, pagamento_id.
* **Pagamento**: tipo (cartão, dinheiro ou Pix), valor; relacionado a uma reserva.

## Rotas Principais

### Rotas Públicas

* `/` → Home

### Rotas Cliente (Autenticadas)

* `/minhas-reservas` → Ver reservas do cliente
* `/perfil` → Visualizar e atualizar perfil

### Rotas Administrador (Autenticadas)

* `/admin/quadras` → CRUD de quadras
* `/admin/reservas` → Listar reservas
* `/admin/relatorios` → Gerar relatórios mensais

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
