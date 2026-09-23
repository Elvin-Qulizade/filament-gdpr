<?php

// translations for ElvinQulizade/Gdpr — French
return [

    'plugin' => [
        'name' => 'Confidentialité',
        'navigation_group' => 'RGPD',
    ],

    'policy' => [
        'label' => 'Politique de conservation',
        'plural_label' => 'Politiques de conservation',
        'navigation_label' => 'Conservation',
    ],

    'runs' => [
        'title' => 'Traitements de confidentialité',
        'navigation_label' => 'Traitements de confidentialité',
        'empty' => 'Aucun journal de traitement pour le moment.',
        'retry' => 'Réexécuter la politique',
        'retry_failed' => 'Réexécuter les politiques en échec',
        'success' => 'Politique exécutée avec succès.',
    ],

    'dsar' => [
        'title' => 'Demande de la personne concernée',
        'navigation_label' => 'Personne concernée',
        'email' => 'E-mail de la personne concernée',
        'submit' => 'Générer l’exportation',
        'generating' => 'Génération de l’exportation…',
        'success' => 'L’exportation des données personnelles a été générée.',
        'invalid_association' => 'Impossible de protéger les données.',
        'export_your_data' => 'Exporter vos données',
        'exported' => 'Données personnelles exportées',
    ],

    'anonymization' => [
        'static_placeholder' => 'Expurgé',
    ],

    'widgets' => [
        'enabled_policies' => 'Politiques actives',
        'total_deleted' => 'Enregistrements supprimés',
        'total_anonymized' => 'Enregistrements anonymisés',
        'exports' => 'Exportations de données',
    ],

    'enums' => [
        'retention_actions' => [
            'anonymize' => 'Anonymiser',
            'delete' => 'Supprimer',
        ],
        'period_units' => [
            'days' => 'jours',
            'months' => 'mois',
            'years' => 'ans',
        ],
        'strategies' => [
            'null' => 'Définir à null',
            'random' => 'Valeur aléatoire',
            'mask' => 'Masquer',
            'static' => 'Valeur statique',
        ],
        'run_statuses' => [
            'running' => 'En cours',
            'succeeded' => 'Réussi',
            'failed' => 'Échec',
        ],
        'export_statuses' => [
            'processing' => 'Traitement',
            'completed' => 'Terminé',
            'failed' => 'Échec',
        ],
    ],

    'fields' => [
        'name' => 'Nom',
        'model_class' => 'Modèle cible',
        'retention_column' => 'Colonne de conservation',
        'retention_period' => 'Durée de conservation',
        'period_unit' => 'Unité de période',
        'action' => 'Action',
        'anonymize_fields' => 'Champs à anonymiser',
        'anonymize_values' => 'Valeurs statiques',
        'enabled' => 'Activée',
        'records_processed' => 'Traités',
        'records_deleted' => 'Supprimés',
        'records_anonymized' => 'Anonymisés',
        'status' => 'Statut',
        'started_at' => 'Débuté à',
        'finished_at' => 'Terminé à',
        'error' => 'Erreur',
        'data_subject' => 'Personne concernée',
        'path' => 'Chemin',
        'size' => 'Taille',
        'created_at' => 'Créé le',
        'policy' => 'Politique',
    ],

];
