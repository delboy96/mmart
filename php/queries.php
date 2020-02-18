<?php

/**
 * @param PDO $conn
 * @return array|bool
 */
function getMenus(PDO $conn): ?array
{
    $sql = "SELECT * FROM menus ORDER BY position;";
    $stmt = $conn->query($sql);
    try {
        $stmt->execute();
        $data = $stmt->fetchAll();
        return ($stmt->rowCount() > 0) ? $data : null;
    } catch (PDOException $e) {
        logger($e->getMessage());
    }
}

function getGalleryPosts(PDO $conn)
{
    $sql = "SELECT * FROM works WHERE type ='gallery';";
    $stmt = $conn->query($sql);
    try {
        $stmt->execute();
        $data = $stmt->fetchAll();
        if ($stmt->rowCount() > 0) {
            return $data;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        logger($e->getMessage());
    }
}


function getExhibitions(PDO $conn): array
{
    $sql = "SELECT * FROM works WHERE type ='exhibition';";

    $stmt = $conn->prepare($sql);

    $stmt->execute();
    $data = $stmt->fetchAll();
    return ($stmt->rowCount() > 0) ? $data : [];
}

function getExhibition(PDO $conn, int $id): ?object
{
    $sql = "SELECT * FROM works WHERE type ='exhibition' AND id = :id;";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    try {
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch();
        return ($stmt->rowCount() === 1) ? $data : null;
    } catch (PDOException $e) {
        logger($e->getMessage());
    }
}

function getExhibitionImages(PDO $conn, int $id)
{
    $sql = "SELECT *
            FROM exhibitionimgs e INNER JOIN works w
            ON e.exh_id = w.id
            WHERE e.exh_id = :id AND w.type = 'exhibition';";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    try {
        $stmt->execute();
        $data = $stmt->fetchAll();
        return ($stmt->rowCount() > 1) ? $data : [];
    } catch (PDOException $e) {
        logger($e->getMessage());
    }
}

function deleteExhibition(PDO $conn, int $id): bool
{
    $sql = "DELETE FROM works WHERE type ='exhibition' AND id = :id";
    $stmt = $conn->prepare($sql);
    try {
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() === 1;
    } catch (PDOException $e) {
        logger($e->getMessage());
        return false;
    }
}

function getProjects(PDO $conn): ?array
{
    $sql = "SELECT * FROM works WHERE type ='project';";

    $stmt = $conn->prepare($sql);

    $stmt->execute();
    $data = $stmt->fetchAll();
    return ($stmt->rowCount() > 0) ? $data : null;
}

function getProject(PDO $conn, int $id): ?object
{
    $sql = "SELECT * FROM works WHERE type ='project' AND id = :id;";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    try {
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch();
        return ($stmt->rowCount() === 1) ? $data : null;
    } catch (PDOException $e) {
        logger($e->getMessage());
    }
}

function registerUser(PDO $conn, string $username, string $email, string $password, string $token): bool
{
    $query = "INSERT INTO users (id, username, email, password,
                token, role_id, active)
                VALUES (NULL, :user, :email, :pass,
                :token, '2', 0)";
    try {

        $stmt = $conn->prepare($query);
        $stmt->bindParam(":user", $username);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":pass", $password);
        $stmt->bindParam(":token", $token);

        $stmt->execute();

        return $stmt->rowCount() === 1;
    } catch (PDOException $e) {
        logger($e->getMessage(), 'ERROR');
        return false;
    }
}

function getUserByEmail(PDO $conn, string $email): ?object
{
    $sql = "SELECT * FROM users WHERE email = :email;";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    try {
        $stmt->execute();
        $data = $stmt->fetch();
        return ($stmt->rowCount() === 1) ? $data : null;
    } catch (PDOException $e) {
        logger($e->getMessage(), 'ERROR');
    }
}

/**
 * Logovanje aktivnosti u bazu.
 *
 * @param PDO $conn
 * @param string $activity
 * @param int $userId
 * @param string $userAgent
 *
 * @return bool
 */
function logActivity(PDO $conn, string $activity, int $userId, string $userAgent): bool
{
    try {
        $sql = "INSERT INTO logs('activity', 'user_id', 'user_agent') VALUES (:activity, :id, :userAgent)";
        $prepared = $conn->prepare($sql);
        $prepared->bindParam('id', $userId);
        $prepared->bindParam('activity', $activity);
        $prepared->bindParam('userAgent', $userAgent);
        return $prepared->execute();
    } catch (PDOException $exception) {
        logger($exception->getMessage());
        return false;
    }
}

function addExhibition(PDO $conn, string $title, string $subtitle, string $body, string $image): bool
{
    $sql = 'INSERT INTO works(title, subtitle, body, image, type) VALUES(:title, :subtitle, :body, :image, "exhibition");';
    $stmt = $conn->prepare($sql);
    try {
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':subtitle', $subtitle, PDO::PARAM_STR);
        $stmt->bindParam(':body', $body, PDO::PARAM_STR);
        $stmt->bindParam(':image', $image, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount() === 1;
    } catch (PDOException $e) {
        logger($e->getMessage());
        return false;
    }
}

function addProject(PDO $conn, string $title, string $subtitle, string $body, string $image): bool
{
    $sql = 'INSERT INTO works(title, subtitle, body, image, type) VALUES(:title, :subtitle, :body, :image, "project");';
    $stmt = $conn->prepare($sql);
    try {
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':subtitle', $subtitle, PDO::PARAM_STR);
        $stmt->bindParam(':body', $body, PDO::PARAM_STR);
        $stmt->bindParam(':image', $image, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount() === 1;
    } catch (PDOException $e) {
        logger($e->getMessage());
        return false;
    }
}


function deleteProject(PDO $conn, int $id): bool
{
    $sql = 'DELETE FROM works WHERE type = "project" AND id = :id';
    $stmt = $conn->prepare($sql);
    try {
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() === 1;
    } catch (PDOException $e) {
        logger($e->getMessage());
        return false;
    }
}


