<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Домашнее задание 4: картинки</title>
    <style>

    table {
    border-collapse: collapse;
    width: 100%;
}
    th, td {
      padding: 15px;
      text-align: center;
      border-bottom: 1px solid #ddd;
    }
      tr:hover {background-color: #e3f0f4}
    </style>
  </head>

  <body>

<?php

error_reporting (E_ALL);

include 'functions.php';

// Собираем данные об изображениях в массив.
  $path_img = 'img/';
  $img = "1";
  $to_csv = array();

  while (file_exists($path_img . $img . ".jpg")) {
  $stat = array();
  $stat[] = stat($path_img . $img . ".jpg");
  $to_csv[$img]['name'] = "$img.jpg";

  $size_bytes = $stat["0"]["size"] / '1024';
  $size_kb = round ($size_bytes, 2);
  $to_csv[$img]['size'] = strval($size_kb);

  $date_unix = $stat["0"]["mtime"];
  $date = date('d.m.Y H:i:s', $date_unix);
  $to_csv[$img]['date'] = $date;

  $img++;
}

// Преобразовываем массив и экспортируем его в CSV.
array_to_csv ('file.csv', $to_csv);

// Создаем превьюшки изображений.
createThumbs("img/","img_thumbnail/",120);

// Создаем таблицу.
echo "<html><body><table>";

echo "<tr>";
echo "<td><b>" . "Превью" . "</b></td>";
echo "<td><b>" . "Название" . "</b></td>";
echo "<td><b>" . "Размер (Кб)" . "</b></td>";
echo "<td><b>" . "Дата последнего изменения" . "</b></td>";
echo "</tr>";

$f = fopen('file.csv', "r");

/* Читаем первую строчку, для того, чтобы перенести "курсор". Заголовки
уже жестко скодированы - выводить ее не нужно. */
$line = fgetcsv($f);

// Читаем из CSV данные и заполняем их в таблицу.
$img = "1";
while (($line = fgetcsv($f)) !== false) {
  echo "<tr>";
  echo '<td><a href="' . "img/$img.jpg" . '"><img src="' . "img_thumbnail/small_$img.jpg" . '"></a></td>';
  foreach ($line as $cell) {
    echo "<td>" . htmlspecialchars($cell) . "</td>";
  }
  echo "</tr>\n";
  $img++;
}

fclose($f);

echo "</table></body></html>";
echo '</br>';
echo '<b>Просмотреть файл CSV: <a href="' . "file.csv" . '">file.csv</a></b>';

?>

</body>
