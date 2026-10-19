<?php

return [
    'admin' => [
        'menu' => [
            'title' => 'Cartes cadeaux',
            'gift-cards' => 'Cartes cadeaux',
            'payments' => 'Paiements',
            'balances' => 'Soldes',
        ],

        'acl' => [
            'title' => 'Cartes cadeaux',
            'gift-cards' => 'Cartes cadeaux',
            'create' => 'Créer',
            'edit' => 'Modifier',
            'delete' => 'Supprimer',
            'payments' => 'Paiements',
            'balances' => 'Soldes',
        ],

        'gift-cards' => [
            'title' => 'Cartes cadeaux',
            'create-btn' => 'Créer une carte cadeau',
            'create-success' => 'Carte cadeau créée avec succès.',
            'update-success' => 'Carte cadeau mise à jour avec succès.',
            'delete-success' => 'Carte cadeau supprimée avec succès.',

            'datagrid' => [
                'id' => 'ID',
                'code' => 'Code',
                'balance' => 'Solde',
                'recipient' => 'Destinataire',
                'status' => 'Statut',
                'active' => 'Active',
                'inactive' => 'Inactive',
                'created-on' => 'Créée le',
                'expires-on' => 'Expire le',
                'edit' => 'Modifier',
                'delete' => 'Supprimer',
            ],

            'form' => [
                'create-title' => 'Créer une carte cadeau',
                'edit-title' => 'Modifier la carte cadeau',
                'code' => 'Code',
                'amount' => 'Solde (:currency)',
                'quantity' => 'Quantité',
                'expires-on' => 'Expire le',
                'status' => 'Statut',
                'recipient-name' => 'Nom du destinataire',
                'recipient-email' => 'E-mail du destinataire',
                'message' => 'Message',
                'email-note' => 'Si un e-mail de destinataire est indiqué, chaque carte cadeau lui est envoyée par e-mail.',
                'save-btn' => 'Enregistrer la carte cadeau',
            ],
        ],

        'payments' => [
            'title' => 'Paiements des cartes cadeaux',

            'datagrid' => [
                'id' => 'ID',
                'code' => 'Code de la carte cadeau',
                'transaction-id' => 'ID de transaction',
                'payer-email' => 'E-mail du payeur',
                'amount' => 'Montant',
                'method' => 'Méthode',
                'status' => 'Statut',
                'paid-at' => 'Payé le',
            ],
        ],

        'balances' => [
            'title' => 'Soldes des cartes cadeaux',

            'datagrid' => [
                'id' => 'ID',
                'code' => 'Code de la carte cadeau',
                'total' => 'Valeur totale',
                'used' => 'Utilisé',
                'remaining' => 'Restant',
                'updated-at' => 'Mis à jour le',
            ],
        ],

        'sales' => [
            'gift-card' => 'Carte cadeau',
            'gift-card-code' => 'Code de la carte cadeau',
        ],

        'configuration' => [
            'title' => 'Cartes cadeaux',
            'info' => 'Configurez l\'achat de cartes cadeaux sur la boutique.',

            'settings' => [
                'title' => 'Paramètres',
                'info' => 'Activez l\'achat de cartes cadeaux et définissez les montants que les clients peuvent acheter.',
                'active' => 'Autoriser l\'achat de cartes cadeaux',
                'min-amount' => 'Montant minimum',
                'max-amount' => 'Montant maximum',
                'preset-amounts' => 'Montants prédéfinis',
                'preset-amounts-info' => 'Montants séparés par des virgules proposés comme choix rapides, par ex. 25,50,100.',
                'validity-days' => 'Validité (jours)',
            ],
        ],
    ],

    'shop' => [
        'header-link' => 'Cartes cadeaux',

        'purchase' => [
            'title' => 'Cartes cadeaux',
            'description' => 'Envoyez une carte cadeau par e-mail pour toutes les occasions.',
            'choose-occasion' => 'Choisissez une occasion',
            'details' => 'Détails de la carte cadeau',
            'amount' => 'Montant (:currency)',
            'amount-range' => 'Saisissez un montant compris entre :min et :max.',
            'recipient-name' => 'Nom du destinataire',
            'recipient-email' => 'E-mail du destinataire',
            'sender-name' => 'Votre nom',
            'sender-email' => 'Votre e-mail',
            'message' => 'Message personnel',
            'preview' => 'Aperçu',
            'back' => 'Retour',
            'next' => 'Suivant',
            'pay' => 'Payer avec PayPal',
            'unavailable' => 'Les cartes cadeaux ne peuvent pas être achetées pour le moment.',
            'currency-unsupported' => 'Les cartes cadeaux ne peuvent pas être payées en :currency.',
            'payment-failed' => 'Le paiement n\'a pas pu être finalisé. Aucun montant ne vous a été débité.',
            'session-expired' => 'Les détails de votre carte cadeau ont expiré. Veuillez remplir à nouveau le formulaire.',
            'required' => 'Ce champ est obligatoire.',
            'invalid-email' => 'Veuillez saisir une adresse e-mail valide.',
            'fix-errors' => 'Veuillez corriger les champs signalés.',
        ],

        'occasions' => [
            'welcome' => 'Bienvenue',
            'birthday' => 'Anniversaire',
            'christmas' => 'Noël',
            'anniversary' => 'Anniversaire de mariage',
            'pongal' => 'Pongal',
            'ramadan' => 'Ramadan',
            'diwali' => 'Diwali',
            'engagement' => 'Fiançailles',
            'farewell' => 'Départ',
            'navratri' => 'Navratri',
            'rakshabandhan' => 'Raksha Bandhan',
            'onam' => 'Onam',
            'fathers-day' => 'Fête des pères',
            'mothers-day' => 'Fête des mères',
            'congratulations' => 'Félicitations',
            'easter' => 'Pâques',
            'best-mom' => 'Meilleure maman',
            'best-dad' => 'Meilleur papa',
            'bhai-dooj' => 'Bhai Dooj',
            'thank-you' => 'Merci',
            'valentines-day' => 'Saint-Valentin',
            'good-luck' => 'Bonne chance',
            'grandparents-day' => 'Fête des grands-parents',
            'holi' => 'Holi',
        ],

        'greetings' => [
            'welcome' => 'Bienvenue dans notre communauté !',
            'birthday' => 'Joyeux anniversaire ! Profite bien de ta journée !',
            'christmas' => 'Joyeux Noël ! Je te souhaite joie et bonheur !',
            'anniversary' => 'Joyeux anniversaire de mariage ! À encore de nombreuses années ensemble !',
            'pongal' => 'Joyeux Pongal ! Profite bien de la période des fêtes !',
            'ramadan' => 'Ramadan Moubarak ! Que ton jeûne soit facile et tes bénédictions nombreuses !',
            'diwali' => 'Joyeux Diwali ! Que ta vie soit remplie de lumière et de bonheur !',
            'engagement' => 'Félicitations pour tes fiançailles !',
            'farewell' => 'Au revoir et meilleurs vœux pour l\'avenir !',
            'navratri' => 'Joyeux Navratri ! Que la santé et le bonheur t\'accompagnent !',
            'rakshabandhan' => 'Joyeux Raksha Bandhan ! Célébrons ce lien d\'amour !',
            'onam' => 'Joyeux Onam ! Je te souhaite une année joyeuse et prospère !',
            'fathers-day' => 'Bonne fête des pères ! Merci pour tout !',
            'mothers-day' => 'Bonne fête des mères ! Tu es la meilleure !',
            'congratulations' => 'Félicitations pour ta réussite !',
            'easter' => 'Joyeuses Pâques ! Je te souhaite de belles fêtes pleines de joie !',
            'best-mom' => 'Tu es la meilleure des mamans !',
            'best-dad' => 'Tu es le meilleur des papas !',
            'bhai-dooj' => 'Joyeux Bhai Dooj ! Célébrons le lien entre frères et sœurs !',
            'thank-you' => 'Merci pour tout !',
            'valentines-day' => 'Joyeuse Saint-Valentin ! Je t\'envoie tout mon amour !',
            'good-luck' => 'Bonne chance pour tous tes projets futurs !',
            'grandparents-day' => 'Bonne fête des grands-parents ! Nous vous aimons !',
            'holi' => 'Joyeuse Holi ! Que ta vie soit pleine de couleurs !',
        ],

        'success' => [
            'title' => 'Merci !',
            'message' => 'Votre carte cadeau d\'une valeur de :amount a été envoyée à :email.',
            'continue-shopping' => 'Continuer vos achats',
        ],

        'checkout' => [
            'title' => 'Carte cadeau',
            'placeholder' => 'Saisissez le code de la carte cadeau',
            'apply' => 'Appliquer',
            'remove' => 'Retirer',
            'applied' => 'Carte cadeau (:code)',
            'remaining' => 'Solde restant après cette commande : :amount',
            'apply-success' => 'Carte cadeau appliquée avec succès.',
            'remove-success' => 'Carte cadeau retirée avec succès.',
            'invalid' => 'Cette carte cadeau est invalide, expirée ou n\'a plus de solde.',
            'cart-not-found' => 'Votre panier est vide.',
            'insufficient-balance' => 'Le solde de la carte cadeau a changé. Veuillez vérifier votre commande et réessayer.',
        ],

        'order' => [
            'gift-card' => 'Carte cadeau (:code)',
        ],
    ],

    'emails' => [
        'gift-card' => [
            'subject' => ':sender vous a envoyé une carte cadeau',
            'greeting' => 'Bonjour :name,',
            'intro' => ':sender vous a envoyé une carte cadeau d\'une valeur de :amount.',
            'code' => 'Votre code de carte cadeau',
            'expires' => 'Valable jusqu\'au :date',
            'redeem' => 'Saisissez ce code dans le champ carte cadeau lors du paiement pour l\'utiliser.',
            'shop-now' => 'Acheter maintenant',
        ],
    ],
];
