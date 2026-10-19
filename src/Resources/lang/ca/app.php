<?php

return [
    'admin' => [
        'menu' => [
            'title' => 'Targetes regal',
            'gift-cards' => 'Targetes regal',
            'payments' => 'Pagaments',
            'balances' => 'Saldos',
        ],

        'acl' => [
            'title' => 'Targetes regal',
            'gift-cards' => 'Targetes regal',
            'create' => 'Crear',
            'edit' => 'Editar',
            'delete' => 'Eliminar',
            'payments' => 'Pagaments',
            'balances' => 'Saldos',
        ],

        'gift-cards' => [
            'title' => 'Targetes regal',
            'create-btn' => 'Crea una targeta regal',
            'create-success' => 'Targeta regal creada correctament.',
            'update-success' => 'Targeta regal actualitzada correctament.',
            'delete-success' => 'Targeta regal eliminada correctament.',

            'datagrid' => [
                'id' => 'ID',
                'code' => 'Codi',
                'balance' => 'Saldo',
                'recipient' => 'Destinatari',
                'status' => 'Estat',
                'active' => 'Activa',
                'inactive' => 'Inactiva',
                'created-on' => 'Creada el',
                'expires-on' => 'Caduca el',
                'edit' => 'Editar',
                'delete' => 'Eliminar',
            ],

            'form' => [
                'create-title' => 'Crea una targeta regal',
                'edit-title' => 'Edita la targeta regal',
                'code' => 'Codi',
                'amount' => 'Saldo (:currency)',
                'quantity' => 'Quantitat',
                'expires-on' => 'Caduca el',
                'status' => 'Estat',
                'recipient-name' => 'Nom del destinatari',
                'recipient-email' => 'Correu electrònic del destinatari',
                'message' => 'Missatge',
                'email-note' => 'Si s\'indica un correu electrònic del destinatari, cada targeta regal se li enviarà per correu electrònic.',
                'save-btn' => 'Desa la targeta regal',
            ],
        ],

        'payments' => [
            'title' => 'Pagaments de targetes regal',

            'datagrid' => [
                'id' => 'ID',
                'code' => 'Codi de la targeta regal',
                'transaction-id' => 'ID de transacció',
                'payer-email' => 'Correu electrònic del pagador',
                'amount' => 'Import',
                'method' => 'Mètode',
                'status' => 'Estat',
                'paid-at' => 'Pagat el',
            ],
        ],

        'balances' => [
            'title' => 'Saldos de targetes regal',

            'datagrid' => [
                'id' => 'ID',
                'code' => 'Codi de la targeta regal',
                'total' => 'Valor total',
                'used' => 'Utilitzat',
                'remaining' => 'Restant',
                'updated-at' => 'Actualitzat el',
            ],
        ],

        'sales' => [
            'gift-card' => 'Targeta regal',
            'gift-card-code' => 'Codi de la targeta regal',
        ],

        'configuration' => [
            'title' => 'Targetes regal',
            'info' => 'Configura la compra de targetes regal a la botiga.',

            'settings' => [
                'title' => 'Configuració',
                'info' => 'Habilita la compra de targetes regal i defineix els imports que poden comprar els clients.',
                'active' => 'Permet la compra de targetes regal',
                'min-amount' => 'Import mínim',
                'max-amount' => 'Import màxim',
                'preset-amounts' => 'Imports predefinits',
                'preset-amounts-info' => 'Imports separats per comes que s\'ofereixen com a opcions ràpides, p. ex. 25,50,100.',
                'validity-days' => 'Validesa (dies)',
            ],
        ],
    ],

    'shop' => [
        'header-link' => 'Targetes regal',

        'purchase' => [
            'title' => 'Targetes regal',
            'description' => 'Envia una targeta regal per correu electrònic per a qualsevol ocasió.',
            'choose-occasion' => 'Tria una ocasió',
            'details' => 'Detalls de la targeta regal',
            'amount' => 'Import (:currency)',
            'amount-range' => 'Introdueix un import entre :min i :max.',
            'recipient-name' => 'Nom del destinatari',
            'recipient-email' => 'Correu electrònic del destinatari',
            'sender-name' => 'El teu nom',
            'sender-email' => 'El teu correu electrònic',
            'message' => 'Missatge personal',
            'preview' => 'Previsualització',
            'back' => 'Enrere',
            'next' => 'Següent',
            'pay' => 'Paga amb PayPal',
            'unavailable' => 'En aquest moment no es poden comprar targetes regal.',
            'currency-unsupported' => 'Les targetes regal no es poden pagar en :currency.',
            'payment-failed' => 'No s\'ha pogut completar el pagament. No se t\'ha fet cap càrrec.',
            'session-expired' => 'Les dades de la teva targeta regal han caducat. Torna a omplir el formulari.',
            'required' => 'Aquest camp és obligatori.',
            'invalid-email' => 'Introduïu una adreça electrònica vàlida.',
            'fix-errors' => 'Corregiu els camps destacats.',
        ],

        'occasions' => [
            'welcome' => 'Benvinguda',
            'birthday' => 'Aniversari',
            'christmas' => 'Nadal',
            'anniversary' => 'Aniversari de casament',
            'pongal' => 'Pongal',
            'ramadan' => 'Ramadà',
            'diwali' => 'Diwali',
            'engagement' => 'Compromís',
            'farewell' => 'Comiat',
            'navratri' => 'Navratri',
            'rakshabandhan' => 'Raksha Bandhan',
            'onam' => 'Onam',
            'fathers-day' => 'Dia del Pare',
            'mothers-day' => 'Dia de la Mare',
            'congratulations' => 'Felicitats',
            'easter' => 'Pasqua',
            'best-mom' => 'La millor mare',
            'best-dad' => 'El millor pare',
            'bhai-dooj' => 'Bhai Dooj',
            'thank-you' => 'Gràcies',
            'valentines-day' => 'Sant Valentí',
            'good-luck' => 'Bona sort',
            'grandparents-day' => 'Dia dels Avis',
            'holi' => 'Holi',
        ],

        'greetings' => [
            'welcome' => 'Benvingut a la nostra comunitat!',
            'birthday' => 'Que passis un aniversari fantàstic! Gaudeix del teu dia!',
            'christmas' => 'Bon Nadal! Et desitjo alegria i felicitat!',
            'anniversary' => 'Feliç aniversari! Per molts anys més!',
            'pongal' => 'Feliç Pongal! Gaudeix de les festes!',
            'ramadan' => 'Ramadà Mubarak! Que el teu dejuni sigui lleuger i les teves benediccions, moltes!',
            'diwali' => 'Feliç Diwali! Que la teva vida s\'ompli de llum i felicitat!',
            'engagement' => 'Felicitats pel teu compromís!',
            'farewell' => 'Fins aviat i molta sort en el futur!',
            'navratri' => 'Feliç Navratri! Que tinguis salut i felicitat!',
            'rakshabandhan' => 'Feliç Raksha Bandhan! Celebrem el vincle de l\'amor!',
            'onam' => 'Feliç Onam! Et desitjo un any ple d\'alegria i prosperitat!',
            'fathers-day' => 'Feliç Dia del Pare! Gràcies per tot!',
            'mothers-day' => 'Feliç Dia de la Mare! Ets la millor!',
            'congratulations' => 'Felicitats pel teu èxit!',
            'easter' => 'Bona Pasqua! Et desitjo unes festes plenes d\'alegria i benediccions!',
            'best-mom' => 'Ets la millor mare!',
            'best-dad' => 'Ets el millor pare!',
            'bhai-dooj' => 'Feliç Bhai Dooj! Celebrem el vincle entre germans!',
            'thank-you' => 'Gràcies per tot!',
            'valentines-day' => 'Feliç Sant Valentí! T\'envio tot el meu amor!',
            'good-luck' => 'Molta sort en tots els teus projectes futurs!',
            'grandparents-day' => 'Feliç Dia dels Avis! Us estimem!',
            'holi' => 'Feliç Holi! Que la teva vida s\'ompli de colors!',
        ],

        'success' => [
            'title' => 'Gràcies!',
            'message' => 'La teva targeta regal per valor de :amount s\'ha enviat a :email.',
            'continue-shopping' => 'Continua comprant',
        ],

        'checkout' => [
            'title' => 'Targeta regal',
            'placeholder' => 'Introdueix el codi de la targeta regal',
            'apply' => 'Aplica',
            'remove' => 'Elimina',
            'applied' => 'Targeta regal (:code)',
            'remaining' => 'Saldo restant després d\'aquesta comanda: :amount',
            'apply-success' => 'Targeta regal aplicada correctament.',
            'remove-success' => 'Targeta regal eliminada correctament.',
            'invalid' => 'Aquesta targeta regal no és vàlida, ha caducat o no té saldo.',
            'cart-not-found' => 'La teva cistella és buida.',
            'insufficient-balance' => 'El saldo de la targeta regal ha canviat. Revisa la comanda i torna-ho a provar.',
        ],

        'order' => [
            'gift-card' => 'Targeta regal (:code)',
        ],
    ],

    'emails' => [
        'gift-card' => [
            'subject' => ':sender t\'ha enviat una targeta regal',
            'greeting' => 'Hola, :name,',
            'intro' => ':sender t\'ha enviat una targeta regal per valor de :amount.',
            'code' => 'El teu codi de targeta regal',
            'expires' => 'Vàlida fins al :date',
            'redeem' => 'Introdueix aquest codi al camp de targeta regal en finalitzar la compra per bescanviar-la.',
            'shop-now' => 'Compra ara',
        ],
    ],
];
