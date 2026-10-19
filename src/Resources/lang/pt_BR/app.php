<?php

return [
    'admin' => [
        'menu' => [
            'title' => 'Vale-Presentes',
            'gift-cards' => 'Vale-Presentes',
            'payments' => 'Pagamentos',
            'balances' => 'Saldos',
        ],

        'acl' => [
            'title' => 'Vale-Presentes',
            'gift-cards' => 'Vale-Presentes',
            'create' => 'Criar',
            'edit' => 'Editar',
            'delete' => 'Excluir',
            'payments' => 'Pagamentos',
            'balances' => 'Saldos',
        ],

        'gift-cards' => [
            'title' => 'Vale-Presentes',
            'create-btn' => 'Criar Vale-Presente',
            'create-success' => 'Vale-presente criado com sucesso.',
            'update-success' => 'Vale-presente atualizado com sucesso.',
            'delete-success' => 'Vale-presente excluído com sucesso.',

            'datagrid' => [
                'id' => 'ID',
                'code' => 'Código',
                'balance' => 'Saldo',
                'recipient' => 'Destinatário',
                'status' => 'Status',
                'active' => 'Ativo',
                'inactive' => 'Inativo',
                'created-on' => 'Criado em',
                'expires-on' => 'Expira em',
                'edit' => 'Editar',
                'delete' => 'Excluir',
            ],

            'form' => [
                'create-title' => 'Criar Vale-Presente',
                'edit-title' => 'Editar Vale-Presente',
                'code' => 'Código',
                'amount' => 'Saldo (:currency)',
                'quantity' => 'Quantidade',
                'expires-on' => 'Expira em',
                'status' => 'Status',
                'recipient-name' => 'Nome do Destinatário',
                'recipient-email' => 'E-mail do Destinatário',
                'message' => 'Mensagem',
                'email-note' => 'Quando um e-mail do destinatário é informado, cada vale-presente é enviado por e-mail ao destinatário.',
                'save-btn' => 'Salvar Vale-Presente',
            ],
        ],

        'payments' => [
            'title' => 'Pagamentos de Vale-Presentes',

            'datagrid' => [
                'id' => 'ID',
                'code' => 'Código do Vale-Presente',
                'transaction-id' => 'ID da Transação',
                'payer-email' => 'E-mail do Pagador',
                'amount' => 'Valor',
                'method' => 'Método',
                'status' => 'Status',
                'paid-at' => 'Pago em',
            ],
        ],

        'balances' => [
            'title' => 'Saldos de Vale-Presentes',

            'datagrid' => [
                'id' => 'ID',
                'code' => 'Código do Vale-Presente',
                'total' => 'Valor Total',
                'used' => 'Utilizado',
                'remaining' => 'Restante',
                'updated-at' => 'Atualizado em',
            ],
        ],

        'sales' => [
            'gift-card' => 'Vale-Presente',
            'gift-card-code' => 'Código do Vale-Presente',
        ],

        'configuration' => [
            'title' => 'Vale-Presentes',
            'info' => 'Configure a compra de vale-presentes na loja.',

            'settings' => [
                'title' => 'Configurações',
                'info' => 'Habilite a compra de vale-presentes e defina os valores que os clientes podem comprar.',
                'active' => 'Permitir Compra de Vale-Presentes',
                'min-amount' => 'Valor Mínimo',
                'max-amount' => 'Valor Máximo',
                'preset-amounts' => 'Valores Predefinidos',
                'preset-amounts-info' => 'Valores separados por vírgula oferecidos como opções rápidas, ex.: 25,50,100.',
                'validity-days' => 'Validade (Dias)',
            ],
        ],
    ],

    'shop' => [
        'header-link' => 'Vale-Presentes',

        'purchase' => [
            'title' => 'Vale-Presentes',
            'description' => 'Envie um vale-presente por e-mail para qualquer ocasião.',
            'choose-occasion' => 'Escolha uma Ocasião',
            'details' => 'Detalhes do Vale-Presente',
            'amount' => 'Valor (:currency)',
            'amount-range' => 'Informe um valor entre :min e :max.',
            'recipient-name' => 'Nome do Destinatário',
            'recipient-email' => 'E-mail do Destinatário',
            'sender-name' => 'Seu Nome',
            'sender-email' => 'Seu E-mail',
            'message' => 'Mensagem Pessoal',
            'preview' => 'Pré-visualizar',
            'back' => 'Voltar',
            'next' => 'Próximo',
            'pay' => 'Pagar com PayPal',
            'unavailable' => 'No momento, não é possível comprar vale-presentes.',
            'currency-unsupported' => 'Vale-presentes não podem ser pagos em :currency.',
            'payment-failed' => 'Não foi possível concluir o pagamento. Você não foi cobrado.',
            'session-expired' => 'Os dados do seu vale-presente expiraram. Preencha o formulário novamente.',
            'required' => 'Este campo é obrigatório.',
            'invalid-email' => 'Informe um endereço de e-mail válido.',
            'fix-errors' => 'Corrija os campos destacados.',
        ],

        'occasions' => [
            'welcome' => 'Boas-Vindas',
            'birthday' => 'Aniversário',
            'christmas' => 'Natal',
            'anniversary' => 'Aniversário de Casamento',
            'pongal' => 'Pongal',
            'ramadan' => 'Ramadã',
            'diwali' => 'Diwali',
            'engagement' => 'Noivado',
            'farewell' => 'Despedida',
            'navratri' => 'Navratri',
            'rakshabandhan' => 'Raksha Bandhan',
            'onam' => 'Onam',
            'fathers-day' => 'Dia dos Pais',
            'mothers-day' => 'Dia das Mães',
            'congratulations' => 'Parabéns',
            'easter' => 'Páscoa',
            'best-mom' => 'Melhor Mãe',
            'best-dad' => 'Melhor Pai',
            'bhai-dooj' => 'Bhai Dooj',
            'thank-you' => 'Obrigado',
            'valentines-day' => 'Dia dos Namorados',
            'good-luck' => 'Boa Sorte',
            'grandparents-day' => 'Dia dos Avós',
            'holi' => 'Holi',
        ],

        'greetings' => [
            'welcome' => 'Boas-vindas à nossa comunidade!',
            'birthday' => 'Tenha um aniversário incrível! Aproveite o seu dia!',
            'christmas' => 'Feliz Natal! Desejamos a você alegria e felicidade!',
            'anniversary' => 'Feliz aniversário de casamento! Um brinde a muitos anos mais!',
            'pongal' => 'Feliz Pongal! Aproveite a temporada festiva!',
            'ramadan' => 'Ramadã Mubarak! Que seu jejum seja tranquilo e suas bênçãos, muitas!',
            'diwali' => 'Feliz Diwali! Que sua vida seja repleta de luz e felicidade!',
            'engagement' => 'Parabéns pelo noivado!',
            'farewell' => 'Adeus e muito sucesso no seu futuro!',
            'navratri' => 'Feliz Navratri! Que você seja abençoado com saúde e felicidade!',
            'rakshabandhan' => 'Feliz Raksha Bandhan! Celebrando o laço de amor!',
            'onam' => 'Feliz Onam! Desejamos a você um ano alegre e próspero!',
            'fathers-day' => 'Feliz Dia dos Pais! Obrigado por tudo!',
            'mothers-day' => 'Feliz Dia das Mães! Você é a melhor!',
            'congratulations' => 'Parabéns pela sua conquista!',
            'easter' => 'Feliz Páscoa! Desejamos a você um feriado alegre e abençoado!',
            'best-mom' => 'Você é a melhor mãe!',
            'best-dad' => 'Você é o melhor pai!',
            'bhai-dooj' => 'Feliz Bhai Dooj! Celebrando o laço entre irmãos!',
            'thank-you' => 'Obrigado por tudo!',
            'valentines-day' => 'Feliz Dia dos Namorados! Com todo o meu amor!',
            'good-luck' => 'Boa sorte em todos os seus projetos futuros!',
            'grandparents-day' => 'Feliz Dia dos Avós! Amamos vocês!',
            'holi' => 'Feliz Holi! Que sua vida seja cheia de cores!',
        ],

        'success' => [
            'title' => 'Obrigado!',
            'message' => 'Seu vale-presente no valor de :amount foi enviado para :email.',
            'continue-shopping' => 'Continuar Comprando',
        ],

        'checkout' => [
            'title' => 'Vale-Presente',
            'placeholder' => 'Digite o código do vale-presente',
            'apply' => 'Aplicar',
            'remove' => 'Remover',
            'applied' => 'Vale-Presente (:code)',
            'remaining' => 'Saldo restante após este pedido: :amount',
            'apply-success' => 'Vale-presente aplicado com sucesso.',
            'remove-success' => 'Vale-presente removido com sucesso.',
            'invalid' => 'Este vale-presente é inválido, expirou ou não tem saldo disponível.',
            'cart-not-found' => 'Seu carrinho está vazio.',
            'insufficient-balance' => 'O saldo do vale-presente foi alterado. Revise seu pedido e tente novamente.',
        ],

        'order' => [
            'gift-card' => 'Vale-Presente (:code)',
        ],
    ],

    'emails' => [
        'gift-card' => [
            'subject' => ':sender enviou um vale-presente para você',
            'greeting' => 'Olá, :name,',
            'intro' => ':sender enviou para você um vale-presente no valor de :amount.',
            'code' => 'O código do seu vale-presente',
            'expires' => 'Válido até :date',
            'redeem' => 'Digite este código no campo de vale-presente durante o checkout para resgatá-lo.',
            'shop-now' => 'Comprar Agora',
        ],
    ],
];
