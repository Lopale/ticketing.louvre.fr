Développez un back-end pour un client

150 heures

Énoncé

Ce projet doit être réalisé avec le suivi de votre mentor. Prenez contact avec lui pour en savoir plus.
Contexte

Le musée du Louvre vous a missionné pour un projet ambitieux : créer un nouveau système de réservation et de gestion des tickets en ligne pour diminuer les longues files d’attente et tirer parti de l’usage croissant des smartphones.

Cahier des charges

L’interface doit être accessible aussi bien sur ordinateur de bureau que tablettes et smartphones, et utiliser pour cela un design responsive.

L’interface doit être fonctionnelle, claire et rapide avant tout. Le client ne souhaite pas surcharger le site d’informations peu utiles : l’objectif est de permettre aux visiteurs d’acheter un billet rapidement.

Il existe 2 types de billets : le billet « Journée » et le billet « Demi-journée » (il ne permet de rentrer qu’à partir de 14h00). Le musée est ouvert tous les jours sauf le mardi (et fermé les 1er mai, 1er novembre et 25 décembre).

Le musée propose plusieurs types de tarifs :

Un tarif « normal » à partir de 12 ans à 16 €
Un tarif « enfant » à partir de 4 ans et jusqu’à 12 ans, à 8 € (l’entrée est gratuite pour les enfants de moins de 4 ans)
Un tarif « senior » à partir de 60 ans pour 12  €
Un tarif « réduit » de 10 € accordé dans certaines conditions (étudiant, employé du musée, d’un service du Ministère de la Culture, militaire…)
Pour commander, on doit sélectionner :

Le jour de la visite
Le type de billet (Journée, Demi-journée…). On peut commander un billet pour le jour même mais on ne peut plus commander de billet « Journée » une fois 14h00 passées.
Le nombre de billets souhaités
Le client précise qu’il n’est pas possible de réserver pour les jours passés (!), les dimanches, les jours fériés et les jours où plus de 1000 billets ont été vendus en tout pour ne pas dépasser la capacité du musée.

Pour chaque billet, l’utilisateur doit indiquer son nom, son prénom, son pays et sa date de naissance. Elle déterminera le tarif du billet.

Si la personne dispose du tarif réduit, elle doit simplement cocher la case « Tarif réduit ». Le site doit indiquer qu’il sera nécessaire de présenter sa carte d’étudiant, militaire ou équivalent lors de l’entrée pour prouver qu’on bénéficie bien du tarif réduit.

Le site récupèrera par ailleurs l’e-mail du visiteur afin de lui envoyer les billets. Il ne nécessitera pas de créer un compte pour commander.

Le visiteur doit pouvoir payer avec la solution Stripe par carte bancaire.

Le site doit gérer le retour du paiement. En cas d’erreur, il invite à recommencer l’opération. Si tout s’est bien passé, la commande est enregistrée et les billets sont envoyés au visiteur.

Vous utiliserez les environnements de test fournis par Stripe pour simuler la transaction, afin de ne pas avoir besoin de rentrer votre propre carte bleue.

La création d'un back-office pour lister les clients et commandes n'est pas demandée. Seule l'interface client est nécessaire ici.
Le billet

Un email de confirmation sera envoyé à l’utilisateur et fera foi de billet.

Le mail doit indiquer:

Le nom et le logo du musée
La date de la réservation
Le tarif
Le nom de chaque visiteur
Le code de la réservation (un ensemble de lettres et de chiffres) 
Livrables attendus

Document de présentation de la solution pour le client, incluant la note de cadrage (PDF)
Code source complet du projet versionné avec Git, développé avec le framework PHP Symfony
Quelques (4-5) tests unitaires et fonctionnels que l’on peut exécuter
Compétences à valider

Elaborer les différents éléments d’un projet
Prendre en main le framework Symfony
Créer un site Internet, de sa conception à sa livraison








Symfony Standard Edition
========================

Welcome to the Symfony Standard Edition - a fully-functional Symfony
application that you can use as the skeleton for your new applications.

For details on how to download and get started with Symfony, see the
[Installation][1] chapter of the Symfony Documentation.

What's inside?
--------------

The Symfony Standard Edition is configured with the following defaults:

  * An AppBundle you can use to start coding;

  * Twig as the only configured template engine;

  * Doctrine ORM/DBAL;

  * Swiftmailer;

  * Annotations enabled for everything.

It comes pre-configured with the following bundles:

  * **FrameworkBundle** - The core Symfony framework bundle

  * [**SensioFrameworkExtraBundle**][6] - Adds several enhancements, including
    template and routing annotation capability

  * [**DoctrineBundle**][7] - Adds support for the Doctrine ORM

  * [**TwigBundle**][8] - Adds support for the Twig templating engine

  * [**SecurityBundle**][9] - Adds security by integrating Symfony's security
    component

  * [**SwiftmailerBundle**][10] - Adds support for Swiftmailer, a library for
    sending emails

  * [**MonologBundle**][11] - Adds support for Monolog, a logging library

  * **WebProfilerBundle** (in dev/test env) - Adds profiling functionality and
    the web debug toolbar

  * **SensioDistributionBundle** (in dev/test env) - Adds functionality for
    configuring and working with Symfony distributions

  * [**SensioGeneratorBundle**][13] (in dev env) - Adds code generation
    capabilities

  * [**WebServerBundle**][14] (in dev env) - Adds commands for running applications
    using the PHP built-in web server

  * **DebugBundle** (in dev/test env) - Adds Debug and VarDumper component
    integration

All libraries and bundles included in the Symfony Standard Edition are
released under the MIT or BSD license.

Enjoy!

[1]:  https://symfony.com/doc/3.3/setup.html
[6]:  https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/index.html
[7]:  https://symfony.com/doc/3.3/doctrine.html
[8]:  https://symfony.com/doc/3.3/templating.html
[9]:  https://symfony.com/doc/3.3/security.html
[10]: https://symfony.com/doc/3.3/email.html
[11]: https://symfony.com/doc/3.3/logging.html
[13]: https://symfony.com/doc/current/bundles/SensioGeneratorBundle/index.html
[14]: https://symfony.com/doc/current/setup/built_in_web_server.html
# ticketing.louvre.fr
