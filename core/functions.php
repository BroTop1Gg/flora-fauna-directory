<?php

declare(strict_types=1);

/**
 * Model Layer / Database Abstraction Functions.
 * Handles all PDO-based interactions with the database.
 */

/**
 * Establishes a connection to the MySQL database.
 * 
 * @return PDO
 * @throws PDOException if connection fails.
 */
function get_db_connection(): PDO
{
    // Retrieve configuration strictly from the environment.
    $host = $_ENV['DB_HOST'];
    $db   = $_ENV['DB_NAME'];
    $user = $_ENV['DB_USER'];
    $pass = $_ENV['DB_PASS'];
    $charset = $_ENV['DB_CHARSET'];

    /**
     * DSN (Data Source Name)
     * A string that contains the information required to connect to the database.
     */
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    /**
     * PDO Options
     * - ATTR_ERRMODE: Throws an Exception on SQL errors (critical for debugging).
     * - ATTR_DEFAULT_FETCH_MODE: Automatically returns results as Associative Arrays.
     * - ATTR_EMULATE_PREPARES: Disables emulation to use native MySQL prepared statements (security).
     */
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    return new PDO($dsn, $user, $pass, $options);
}

/**
 * Fetches all items for the main navigation menu.
 * 
 * @param PDO $connection
 * @return array
 */
function get_navigation_menu(PDO $connection): array
{
    $query = "SELECT title, url FROM menu ORDER BY id ASC";
    $statement = $connection->query($query);
    return $statement->fetchAll();
}

/**
 * Fetches all categories for grouping entries.
 * 
 * @param PDO $connection
 * @return array
 */
function get_active_categories(PDO $connection): array
{
    $query = "SELECT id, name FROM categories ORDER BY name ASC";
    $statement = $connection->query($query);
    return $statement->fetchAll();
}

/**
 * Fetches an administrative user by their username.
 * 
 * @param PDO $connection
 * @param string $username
 * @return array|null
 */
function get_admin_by_username(PDO $connection, string $username): ?array
{
    $query = "SELECT id, username, password_hash FROM administrators WHERE username = :username LIMIT 1";
    $statement = $connection->prepare($query);
    $statement->execute(['username' => $username]);
    
    $user = $statement->fetch();
    return $user ?: null;
}
