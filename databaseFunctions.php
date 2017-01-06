<?php
/**
 * Funktionen myDBConnect kopplar upp webbapplikationen mot MySQL med angivna konstanter.
 * Om uppkopplingen misslyckas kastas ett undantag. Om allt fungerar returneras databaskopplingen.
 *
 * @return resource Kopplingen till MySQL mot given databas.
 */
function myDBConnect() {
  define("DB_HOST", "localhost");
  define("DB_USERNAME", "mysqluser");
  define("DB_PASSWORD", "mysqlpassword");
  define("DB", "ISGB24");

  return new PDO(
    'mysql:host=' . DB_HOST . ';dbname=' . DB,
    DB_USERNAME,
    DB_PASSWORD,
    array(
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
    )
  );
}

/**
 * Funktionen myDBQuery exekverar en SQL fråga mot en given databas.
 * Om SQL frågan misslyckas kastas ett undantag. Om allt fungerar returneras en tabell med efterfrågad data.
 *
 * @param resurce $db Databaskoppling
 * @param string $query SQL frågan i klartext
 * @param vararg $args Parametrar till SQL-frågan
 * @return mixed Array (vektor) med utsökt data. Om frågan inte är av en typ
 *         som returnerar data (exempelvis INSERT och DELETE), returneras
 *         istället antalet påverkade rader (d.v.s. antalet rader som lades
 *         till eller togs bort).
 */
function myDBQuery($db, $query, ...$args) {
  try {
    $db->beginTransaction();
    if (count($args) == 0) {
      $result = $db->query($query)->fetchAll();
    } else {
      $stmt = $db->prepare($query);
      $stmt->execute($args);
      
      // Fetch the results if any,
      // otherwise set result to be
      // the number of affected rows.
      if ($stmt->columnCount() > 0)
        $result = $stmt->fetchAll();
      else
        $result = $stmt->rowCount();
    }

    $db->commit();
    return $result;
  } catch (PDOException $e) {
    $db->rollBack();
    throw $e;
  }
}