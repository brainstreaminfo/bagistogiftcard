<?php

return [
    'admin' => [
        'menu' => [
            'title' => 'Carduri Cadou',
            'gift-cards' => 'Carduri Cadou',
            'payments' => 'Plăți',
            'balances' => 'Solduri',
        ],

        'acl' => [
            'title' => 'Carduri Cadou',
            'gift-cards' => 'Carduri Cadou',
            'create' => 'Creare',
            'edit' => 'Editare',
            'delete' => 'Ștergere',
            'payments' => 'Plăți',
            'balances' => 'Solduri',
        ],

        'gift-cards' => [
            'title' => 'Carduri Cadou',
            'create-btn' => 'Creează Card Cadou',
            'create-success' => 'Cardul cadou a fost creat cu succes.',
            'update-success' => 'Cardul cadou a fost actualizat cu succes.',
            'delete-success' => 'Cardul cadou a fost șters cu succes.',

            'datagrid' => [
                'id' => 'ID',
                'code' => 'Cod',
                'balance' => 'Sold',
                'recipient' => 'Destinatar',
                'status' => 'Stare',
                'active' => 'Activ',
                'inactive' => 'Inactiv',
                'created-on' => 'Creat la',
                'expires-on' => 'Expiră la',
                'edit' => 'Editare',
                'delete' => 'Ștergere',
            ],

            'form' => [
                'create-title' => 'Creează Card Cadou',
                'edit-title' => 'Editează Card Cadou',
                'code' => 'Cod',
                'amount' => 'Sold (:currency)',
                'quantity' => 'Cantitate',
                'expires-on' => 'Expiră la',
                'status' => 'Stare',
                'recipient-name' => 'Numele Destinatarului',
                'recipient-email' => 'E-mailul Destinatarului',
                'message' => 'Mesaj',
                'email-note' => 'Când este specificat un e-mail al destinatarului, fiecare card cadou este trimis prin e-mail destinatarului.',
                'save-btn' => 'Salvează Cardul Cadou',
            ],
        ],

        'payments' => [
            'title' => 'Plăți Carduri Cadou',

            'datagrid' => [
                'id' => 'ID',
                'code' => 'Cod Card Cadou',
                'transaction-id' => 'ID Tranzacție',
                'payer-email' => 'E-mailul Plătitorului',
                'amount' => 'Sumă',
                'method' => 'Metodă',
                'status' => 'Stare',
                'paid-at' => 'Plătit la',
            ],
        ],

        'balances' => [
            'title' => 'Solduri Carduri Cadou',

            'datagrid' => [
                'id' => 'ID',
                'code' => 'Cod Card Cadou',
                'total' => 'Valoare Totală',
                'used' => 'Utilizat',
                'remaining' => 'Rămas',
                'updated-at' => 'Actualizat la',
            ],
        ],

        'sales' => [
            'gift-card' => 'Card Cadou',
            'gift-card-code' => 'Cod Card Cadou',
        ],

        'configuration' => [
            'title' => 'Carduri Cadou',
            'info' => 'Configurați achiziția de carduri cadou în magazin.',

            'settings' => [
                'title' => 'Setări',
                'info' => 'Activați achiziția de carduri cadou și setați sumele pe care clienții le pot cumpăra.',
                'active' => 'Permite Achiziția de Carduri Cadou',
                'min-amount' => 'Sumă Minimă',
                'max-amount' => 'Sumă Maximă',
                'preset-amounts' => 'Sume Predefinite',
                'preset-amounts-info' => 'Sume separate prin virgulă, oferite ca opțiuni rapide, de ex. 25,50,100.',
                'validity-days' => 'Valabilitate (Zile)',
            ],
        ],
    ],

    'shop' => [
        'header-link' => 'Carduri Cadou',

        'purchase' => [
            'title' => 'Carduri Cadou',
            'description' => 'Trimiteți un card cadou prin e-mail pentru orice ocazie.',
            'choose-occasion' => 'Alegeți o Ocazie',
            'details' => 'Detaliile Cardului Cadou',
            'amount' => 'Sumă (:currency)',
            'amount-range' => 'Introduceți o sumă între :min și :max.',
            'recipient-name' => 'Numele Destinatarului',
            'recipient-email' => 'E-mailul Destinatarului',
            'sender-name' => 'Numele Dvs.',
            'sender-email' => 'E-mailul Dvs.',
            'message' => 'Mesaj Personal',
            'preview' => 'Previzualizare',
            'back' => 'Înapoi',
            'next' => 'Următorul',
            'pay' => 'Plătiți cu PayPal',
            'unavailable' => 'Momentan nu se pot cumpăra carduri cadou.',
            'currency-unsupported' => 'Cardurile cadou nu pot fi plătite în :currency.',
            'payment-failed' => 'Plata nu a putut fi finalizată. Nu ați fost taxat.',
            'session-expired' => 'Detaliile cardului cadou au expirat. Vă rugăm să completați din nou formularul.',
            'required' => 'Acest câmp este obligatoriu.',
            'invalid-email' => 'Introduceți o adresă de e-mail validă.',
            'fix-errors' => 'Corectați câmpurile evidențiate.',
        ],

        'occasions' => [
            'welcome' => 'Bun Venit',
            'birthday' => 'Zi de Naștere',
            'christmas' => 'Crăciun',
            'anniversary' => 'Aniversare',
            'pongal' => 'Pongal',
            'ramadan' => 'Ramadan',
            'diwali' => 'Diwali',
            'engagement' => 'Logodnă',
            'farewell' => 'Rămas-Bun',
            'navratri' => 'Navratri',
            'rakshabandhan' => 'Raksha Bandhan',
            'onam' => 'Onam',
            'fathers-day' => 'Ziua Tatălui',
            'mothers-day' => 'Ziua Mamei',
            'congratulations' => 'Felicitări',
            'easter' => 'Paște',
            'best-mom' => 'Cea Mai Bună Mamă',
            'best-dad' => 'Cel Mai Bun Tată',
            'bhai-dooj' => 'Bhai Dooj',
            'thank-you' => 'Mulțumesc',
            'valentines-day' => 'Ziua Îndrăgostiților',
            'good-luck' => 'Mult Noroc',
            'grandparents-day' => 'Ziua Bunicilor',
            'holi' => 'Holi',
        ],

        'greetings' => [
            'welcome' => 'Bun venit în comunitatea noastră!',
            'birthday' => 'La mulți ani! Bucură-te de ziua ta!',
            'christmas' => 'Crăciun fericit! Îți dorim bucurie și fericire!',
            'anniversary' => 'La mulți ani cu ocazia aniversării! Pentru încă mulți ani împreună!',
            'pongal' => 'Pongal fericit! Bucură-te de sărbători!',
            'ramadan' => 'Ramadan Mubarak! Să ai un post ușor și binecuvântări din belșug!',
            'diwali' => 'Diwali fericit! Fie ca viața ta să fie plină de lumină și fericire!',
            'engagement' => 'Felicitări pentru logodnă!',
            'farewell' => 'Rămas-bun și mult succes în viitor!',
            'navratri' => 'Navratri fericit! Să ai parte de sănătate și fericire!',
            'rakshabandhan' => 'Raksha Bandhan fericit! Sărbătorim legătura iubirii!',
            'onam' => 'Onam fericit! Îți dorim un an plin de bucurie și prosperitate!',
            'fathers-day' => 'La mulți ani de Ziua Tatălui! Mulțumim pentru tot!',
            'mothers-day' => 'La mulți ani de Ziua Mamei! Ești cea mai bună!',
            'congratulations' => 'Felicitări pentru realizarea ta!',
            'easter' => 'Paște fericit! Îți dorim sărbători pline de bucurie și binecuvântare!',
            'best-mom' => 'Ești cea mai bună mamă!',
            'best-dad' => 'Ești cel mai bun tată!',
            'bhai-dooj' => 'Bhai Dooj fericit! Sărbătorim legătura dintre frați!',
            'thank-you' => 'Îți mulțumim pentru tot!',
            'valentines-day' => 'La mulți ani de Ziua Îndrăgostiților! Îți trimit toată dragostea mea!',
            'good-luck' => 'Mult succes în toate proiectele tale viitoare!',
            'grandparents-day' => 'La mulți ani de Ziua Bunicilor! Vă iubim!',
            'holi' => 'Holi fericit! Fie ca viața ta să fie plină de culori!',
        ],

        'success' => [
            'title' => 'Vă Mulțumim!',
            'message' => 'Cardul dvs. cadou în valoare de :amount a fost trimis la :email.',
            'continue-shopping' => 'Continuați Cumpărăturile',
        ],

        'checkout' => [
            'title' => 'Card Cadou',
            'placeholder' => 'Introduceți codul cardului cadou',
            'apply' => 'Aplică',
            'remove' => 'Elimină',
            'applied' => 'Card Cadou (:code)',
            'remaining' => 'Sold rămas după această comandă: :amount',
            'apply-success' => 'Cardul cadou a fost aplicat cu succes.',
            'remove-success' => 'Cardul cadou a fost eliminat cu succes.',
            'invalid' => 'Acest card cadou este invalid, a expirat sau nu mai are sold.',
            'cart-not-found' => 'Coșul dvs. este gol.',
            'insufficient-balance' => 'Soldul cardului cadou s-a modificat. Vă rugăm să verificați comanda și să încercați din nou.',
        ],

        'order' => [
            'gift-card' => 'Card Cadou (:code)',
        ],
    ],

    'emails' => [
        'gift-card' => [
            'subject' => ':sender v-a trimis un card cadou',
            'greeting' => 'Bună, :name,',
            'intro' => ':sender v-a trimis un card cadou în valoare de :amount.',
            'code' => 'Codul cardului dvs. cadou',
            'expires' => 'Valabil până la :date',
            'redeem' => 'Introduceți acest cod în câmpul pentru card cadou la finalizarea comenzii pentru a-l utiliza.',
            'shop-now' => 'Cumpărați Acum',
        ],
    ],
];
