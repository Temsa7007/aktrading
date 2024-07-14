<?php

return [
    'title'       => 'Installateur Ak Trading',
    'next'        => 'Étape suivante',
    'welcome'     => [
        'templateTitle' => 'Bienvenue',
        'title'         => 'Installateur Ak Trading',
        'message'       => 'Assistant d\'installation et de configuration facile.',
        'next'          => 'Vérifier les exigences',
    ],
    'requirement' => [
        'templateTitle' => 'Étape 1 | Exigences du serveur',
        'title'         => 'Exigences du serveur',
        'next'          => 'Vérifier les permissions',
        'version'       => 'version',
        'required'      => 'requis'
    ],
    'permission'  => [
        'templateTitle'       => 'Étape 2 | Permissions',
        'title'               => 'Permissions',
        'next'                => 'Configuration du site',
        'permission_checking' => 'Vérification des permissions'
    ],
    'license' => [
        'templateTitle'       => 'Étape 3 | Licence',
        'title'               => 'Configuration de la licence',
        'next'                => 'Configuration du site',
        'active_process'      => 'Processus d\'activation',
        'label'               => [
            'license_key' => 'Clé de licence'
        ]
    ],
    'site'        => [
        'templateTitle' => 'Étape 3 | Configuration du site',
        'title'         => 'Configuration du site',
        'next'          => 'Configuration de la base de données',
        'label'         => [
            'app_name' => 'Nom de l\'application',
            'app_url'  => 'URL de l\'application',
        ]
    ],
    'database'    => [
        'templateTitle'            => 'Étape 4 | Configuration de la base de données',
        'title'                    => 'Configuration de la base de données',
        'next'                     => 'Configuration finale',
        'fail_message'             => 'Impossible de se connecter à la base de données.',
        'fail_mysql_version'       => 'Utilisez la version 8.0 ou ultérieure de MySQL.',
        'fail_mariadb_version'     => 'Utilisez la version 10.2 ou ultérieure de MariaDB.',
        'fail_postgresql_version'  => 'Utilisez la version 9.4 ou ultérieure de PostgreSQL.',
        'fail_sqlserver_version'   => 'Utilisez la version 2008 ou ultérieure de SQL Server.',
        'fail_singlestore_version' => 'Utilisez la version 8.1 ou ultérieure de SingleStore.',
        'label'                    => [
            'database_connection' => 'Connexion à la base de données',
            'database_host'       => 'Hôte de la base de données',
            'database_port'       => 'Port de la base de données',
            'database_name'       => 'Nom de la base de données',
            'database_username'   => 'Nom d\'utilisateur de la base de données',
            'database_password'   => 'Mot de passe de la base de données',
        ]
    ],
    'final'       => [
        'templateTitle'   => 'Étape 6 | Configuration finale',
        'title'           => 'Configuration finale',
        'success_message' => 'L\'application a été installée avec succès.',
        'login_info'      => 'Informations de connexion',
        'email'           => 'Email',
        'password'        => 'Mot de passe',
        'email_info'      => 'admin@example.com',
        'password_info'   => '123456',
        'next'            => 'Terminer',
    ],
    'installed'   => [
        'success_log_message' => 'L\'installateur Ak Trading a été installé avec succès le ',
        'update_log_message'  => 'L\'installateur Ak Trading a été mis à jour avec succès le ',
    ],
];
