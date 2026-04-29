<?php

/**
 * @file database.php
 * @package Syspulse\Config
 *
 * @brief Configuration et initialisation de la connexion à la base de données.
 *
 * Ce fichier établit la connexion PDO à la base de données MySQL utilisée
 * par l'application Syspulse. Il doit être inclus par tout script nécessitant
 * un accès aux données.
 *
 * @author Syspulse
 * @version 1.0
 */

/** @var string $host Adresse du serveur de base de données */
$host = 'localhost';

/** @var string $dbname Nom de la base de données */
$dbname = 'bdsyspulse';

/** @var string $username Identifiant de connexion à la base de données */
$username = 'root';

/** @var string $password Mot de passe de connexion à la base de données */
$password = '';

/**
 * @var PDO $pdo Instance de connexion PDO à la base de données.
 *
 * Connexion configurée avec le charset UTF-8 pour garantir
 * la compatibilité des caractères spéciaux.
 */
$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
