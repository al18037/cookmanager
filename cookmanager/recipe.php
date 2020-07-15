<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>レシピ</title>
  </head>
  <body>
    <?php
      $user = "hogeUser";
      $pass = "hogePass";
      try {
        if (empty($_GET['id'])) throw new Exception('ID不正');
        $id = (int) $_GET['id'];
        $dbh = new PDO('mysql:host=localhost;dbname=db1;charset=utf8', $user, $pass);
        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM shokuzai WHERE id = ?";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $dbh = null;
      } catch (Exception $e) {
        echo "error: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
        die();
      }

      $shokuzai_name = $result['shokuzai_name'];

      // $username = "root";
      // $passname = "";
      try {
        $dbh = new PDO('mysql:host=160.16.141.77:61000;dbname=cooksample;charset=utf8', $user, $pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM recipe";
        $stmt = $dbh->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
          if (strpos($result['recipe_title'], $shokuzai_name) !== false) {
            echo $result['recipe_title'];
            echo "<br>\n";
            echo "<a href=" . $result['recipe_url'] . ">レシピを見る</a>\n";
            echo "<br>\n";
            echo "<a href=" . $result['recipe_image_url'] . ">写真を見る</a>\n";
            echo "<br>\n";
            $a = "1";
            break;
          }
        }
        if (empty($a)) {
          print_r($shokuzai_name . "を含むレシピを検索できませんでした。");
        }
      } catch (Exception $e) {
        echo "error: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
        die();
      }

    ?>

  </body>
</html>