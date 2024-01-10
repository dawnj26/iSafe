<?php

if (empty($_GET['filter'])) {
    die();
}
require '../config/config.php';

switch ($_GET['filter']) {
    case 'day':
        $query = "
              SELECT DAYNAME(date_of_event) AS Day, COUNT(*) AS RecordsCount
              FROM appointment
              GROUP BY DAYNAME(date_of_event)
              ORDER BY DAYOFWEEK(date_of_event);
                ";
        $result = $mainConn->query($query);
        $results = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($results);
        break;
    case 'month':
        $query = "
          SELECT YEAR(date_of_event) AS Year, MONTHNAME(date_of_event) AS Month, COUNT(*) AS RecordsCount
          FROM appointment
          GROUP BY YEAR(date_of_event), MONTH(date_of_event)
          ORDER BY Year, Month;
                ";
        $result = $mainConn->query($query);
        $results = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($results);
        break;
    case 'year':
        $query = "
            SELECT YEAR(date_of_event) AS Year, COUNT(*) AS RecordsCount
            FROM appointment
            GROUP BY YEAR(date_of_event)
            ORDER BY Year;
                ";
        $result = $mainConn->query($query);
        $results = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($results);
        break;
}
