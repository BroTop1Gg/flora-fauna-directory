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
    $host = $_ENV['DB_HOST'] ?? $_SERVER['DB_HOST'] ?? '';
    $db = $_ENV['DB_NAME'] ?? $_SERVER['DB_NAME'] ?? '';
    $user = $_ENV['DB_USER'] ?? $_SERVER['DB_USER'] ?? '';
    $pass = $_ENV['DB_PASS'] ?? $_SERVER['DB_PASS'] ?? '';
    $charset = $_ENV['DB_CHARSET'] ?? $_SERVER['DB_CHARSET'] ?? 'utf8mb4';

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
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
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

/**
 * Fetches all directory entries with their associated category name.
 * 
 * @param PDO $connection
 * @param int|null $limit Optional pagination limit.
 * @return array
 */
function get_all_entries(PDO $connection, ?int $limit = null): array
{
    $query = "SELECT e.*, c.name as category_name 
              FROM entries e 
              JOIN categories c ON e.category_id = c.id 
              ORDER BY e.created_at DESC";

    if ($limit !== null) {
        $query .= " LIMIT " . (int) $limit;
    }

    $statement = $connection->query($query);
    return $statement->fetchAll();
}

/**
 * Fetches a single directory entry by its ID.
 * 
 * @param PDO $connection
 * @param int $id
 * @return array|null
 */
function get_entry_by_id(PDO $connection, int $id): ?array
{
    $query = "SELECT e.*, c.name as category_name 
              FROM entries e 
              JOIN categories c ON e.category_id = c.id 
              WHERE e.id = :id 
              LIMIT 1";

    $statement = $connection->prepare($query);
    $statement->execute(['id' => $id]);

    $entry = $statement->fetch();
    return $entry ?: null;
}

/**
 * Fetches all entries belonging to a specific category.
 * 
 * @param PDO $connection
 * @param int $category_id
 * @return array
 */
function get_entries_by_category(PDO $connection, int $category_id): array
{
    $query = "SELECT e.*, c.name as category_name 
              FROM entries e 
              JOIN categories c ON e.category_id = c.id 
              WHERE e.category_id = :category_id 
              ORDER BY e.created_at DESC";

    $statement = $connection->prepare($query);
    $statement->execute(['category_id' => $category_id]);

    return $statement->fetchAll();
}

/**
 * Fetches a single category by its ID.
 * 
 * @param PDO $connection
 * @param int $id
 * @return array|null
 */
function get_category_by_id(PDO $connection, int $id): ?array
{
    $query = "SELECT * FROM categories WHERE id = :id LIMIT 1";
    $statement = $connection->prepare($query);
    $statement->execute(['id' => $id]);

    $category = $statement->fetch();
    return $category ?: null;
}

/**
 * Creates a new directory entry.
 * 
 * @param PDO $connection
 * @param array $data
 * @return bool
 */
function create_entry(PDO $connection, array $data): bool
{
    $query = "INSERT INTO entries (category_id, title, content, image_path) 
              VALUES (:category_id, :title, :content, :image_path)";

    $statement = $connection->prepare($query);
    return $statement->execute([
        'category_id' => $data['category_id'],
        'title' => $data['title'],
        'content' => $data['content'],
        'image_path' => $data['image_path']
    ]);
}

/**
 * Updates an existing directory entry.
 * 
 * @param PDO $connection
 * @param int $id
 * @param array $data
 * @return bool
 */
function update_entry(PDO $connection, int $id, array $data): bool
{
    $query = "UPDATE entries SET 
              category_id = :category_id, 
              title = :title, 
              content = :content, 
              image_path = :image_path 
              WHERE id = :id";

    $statement = $connection->prepare($query);
    return $statement->execute([
        'id' => $id,
        'category_id' => $data['category_id'],
        'title' => $data['title'],
        'content' => $data['content'],
        'image_path' => $data['image_path']
    ]);
}

/**
 * Deletes an entry and its associated image if it exists.
 * 
 * @param PDO $connection
 * @param int $id
 * @return bool
 */
function delete_entry(PDO $connection, int $id): bool
{
    // First, get image path to delete the file
    $query = "SELECT image_path FROM entries WHERE id = :id LIMIT 1";
    $statement = $connection->prepare($query);
    $statement->execute(['id' => $id]);
    $entry = $statement->fetch();

    if ($entry && !empty($entry['image_path'])) {
        $full_path = __DIR__ . '/../img/' . $entry['image_path'];
        if (file_exists($full_path)) {
            unlink($full_path);
        }
    }

    $query = "DELETE FROM entries WHERE id = :id";
    $statement = $connection->prepare($query);
    return $statement->execute(['id' => $id]);
}

/**
 * Handles file upload for entry images.
 * 
 * @param array $file The $_FILES['image'] array.
 * @return string|null The unique filename or null on failure.
 */
function handle_image_upload(array $file): ?string
{
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $file_info = getimagesize($file['tmp_name']);

    if (!$file_info || !in_array($file_info['mime'], $allowed_types)) {
        return null;
    }

    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = bin2hex(random_bytes(8)) . '_' . time() . '.' . $extension;
    $target_path = __DIR__ . '/../img/' . $filename;

    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        return $filename;
    }

    return null;
}
