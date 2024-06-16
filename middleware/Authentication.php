<?php
class Authentication
{
    private static $conn;

    public static function setConnection($connection)
    {
        self::$conn = $connection;
    }

    public static function authenticate($requiredRoles)
    {
        if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
            self::requireLogin();
        }

        $username = $_SERVER['PHP_AUTH_USER'];
        $password = $_SERVER['PHP_AUTH_PW'];

        // Validate the username and password from the database
        $user = self::validateUser($username, $password);

        if ($user && in_array($user['role'], $requiredRoles)) {
            $_SESSION['user'] = $user;
            return true;
        }

        // Unauthorized if user validation fails
        self::unauthorized();
    }

    private static function requireLogin()
    {
        header('WWW-Authenticate: Basic realm="My Realm"');
        header('HTTP/1.0 401 Unauthorized');
        echo json_encode(array("message" => "Login required"));
        exit();
    }

    private static function unauthorized()
    {
        header('HTTP/1.0 401 Unauthorized');
        echo json_encode(array("message" => "Unauthorized"));
        exit();
    }

    private static function validateUser($username, $password)
    {
        // Prepare and execute the query to validate the user
        $query = "SELECT * FROM Users WHERE username = :username";
        $stmt = self::$conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the password matches the one in the database
        if ($user && $user['password'] === $password) {
            return $user;
        }

        return null;
    }
}
?>
