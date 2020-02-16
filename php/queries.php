<?php

/**
 * @param  PDO  $conn
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
        echo $e->getMessage();
    }
}

//function slug_exists(PDO $conn, string $pageN)
//{
//    $sql = "SELECT m.name FROM menus m
//    WHERE m.name = '" . $pageN . "'";
//    $stmt = $conn->query($sql);
//    try {
//        $stmt->execute();
//        $data = $stmt->fetch();
//        if ($stmt->rowCount() == 1) {
//            return $data;
//        } else {
//            return false;
//        }
//    } catch (PDOException $e) {
//        echo $e->getMessage();
//    }
//}

function getPosts(PDO $conn)
{
    $sql = "SELECT * FROM posts;";
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
        echo $e->getMessage();
    }
}

function getGaleryPosts(PDO $conn)
{
    $sql = "SELECT * FROM galeryposts;";
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
        echo $e->getMessage();
    }
}


function getPostImages(PDO $conn, int $id)
{
    $sql = 'SELECT p.id, p.title, p.body, p.time, p.user_id, p.image, i.path FROM posts p INNER JOIN post_image k ON p.id = k.post_id INNER JOIN images i ON k.image_id = i.id WHERE p.id = :id';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    try {
        $stmt->execute();
        $data = $stmt->fetch();
        return ($stmt->rowCount() > 0) ? $data : false;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function getPost(PDO $conn, int $id)
{
    $sql = "SELECT * FROM posts WHERE id = :id;";
    $stmt = $conn->prepare($sql);
    try {
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch();
        return ($stmt->rowCount() === 1) ? $data : false;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function getExhibitions(PDO $conn): array
{
    $sql = "SELECT * FROM exhibitionsposts;";

    $stmt = $conn->prepare($sql);

    $stmt->execute();
    $data = $stmt->fetchAll();
    return ($stmt->rowCount() > 0) ? $data : [];
}

function getExhibition(PDO $conn, int $id): ?object
{
    $sql = "SELECT * FROM exhibitionsposts WHERE id = :id;";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    try {
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch();
        return ($stmt->rowCount() === 1) ? $data : null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function getExhibitionImages(PDO $conn, int $id)
{
    $sql = "SELECT * FROM exhibitionimages WHERE exh_id = :id;";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    try {
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetchAll();
        return ($stmt->rowCount() > 1) ? $data : null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function deleteExhibition(PDO $conn, int $id): bool
{
    $sql = 'DELETE FROM exhibitionsposts WHERE id = :id';
    $stmt = $conn->prepare($sql);
    try {
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() === 1;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}

function getProjects(PDO $conn): ?array
{
    $sql = "SELECT * FROM projectsposts;";

    $stmt = $conn->prepare($sql);

    $stmt->execute();
    $data = $stmt->fetchAll();
    return ($stmt->rowCount() > 0) ? $data : null;
}

function getProject(PDO $conn, int $id)
{
    $sql = "SELECT * FROM projectsposts WHERE id = :id;";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    try {
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch();
        return ($stmt->rowCount() === 1) ? $data : false;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}


/**
 * Logovanje aktivnosti u bazu.
 *
 * @param  PDO  $conn
 * @param  string  $activity
 * @param  int  $userId
 * @param  string  $userAgent
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
        echo $exception->getMessage();
        return false;
    }
}

function addExhibition(PDO $conn, string $title, string $subtitle, string $body, string $image): bool
{
    $sql = 'INSERT INTO exhibitionsposts(title, subtitle, body, image) VALUES(:title, :subtitle, :body, :image);';
    $stmt = $conn->prepare($sql);
    try {
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':subtitle', $subtitle, PDO::PARAM_STR);
        $stmt->bindParam(':body', $body, PDO::PARAM_STR);
        $stmt->bindParam(':image', $image, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount() === 1;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}

function userLoggedIn() {
    return (isset($_SESSION['user'])); 
}

function adminLoggedIn() {
    return ((userLoggedIn()) && ($_SESSION['user']->role_id === 1));
}
  
function dd($element) {
    echo '<pre>';
    print_r($element);
    echo '</pre>';
}

function auth() {
    return $_SESSION['user'];
}

// function getArticles($conn) {
//   $sql = "SELECT * FROM articles";

//   $stmt = $conn->prepare($sql);

//   $stmt->execute();
//   $data = $stmt->fetchAll();
//   return ($stmt->rowCount() > 0) ?  $data : false;
// }

// function getArticle($conn,$id) {
//   $sql = "SELECT * FROM articles WHERE id = :id;";
//   $stmt = $conn->prepare($sql);
//   try {
//     $stmt->execute([ ':id' => $id]);
//     $data = $stmt->fetch();
//     return ($stmt->rowCount() === 1) ?  $data : false;
//   } catch (PDOException $e) {
//     echo $e->getMessage();
//   }
// }

