<?php

// Экспорт массива в CSV
function array_to_csv ($file, $array) {
      $output = fopen($file, 'w');
      $header = array_keys($array[1]);
      fputcsv($output, $header);
      foreach($array as $values)
      {
           fputcsv($output, $values);
      }
      fclose($output);
}

/* Далее функция не моя. Взял со Stackoverflow, автор: Nona Hera.
Сссылка: http://stackoverflow.com/questions/16804069/scan-directory-and-create-thumbnail-images
Адаптировал ее под поставленные задачи, в том числе сделал пропорциональную обрезку превьюшки.
Комментарии автора оставил для наглядности.
*/

function createThumbs( $pathToImages, $pathToThumbs, $thumbWidth )
{
// Turn off all error reporting
error_reporting(0);

set_time_limit(0);
  // open the directory
  $dir = opendir( $pathToImages );

  // loop through it, looking for any/all JPG files:
  $i='1';
  while (false !== ($fname = readdir( $dir ))) {
    // parse path for the extension
    $info = pathinfo($pathToImages . $fname);
    // continue only if this is a JPEG image
        $source_file_name = basename($source_image);
        $source_image_type = substr($source_file_name, -3, 3);

        if (strtolower($info['extension']) === 'jpg')
        {
            $img = imagecreatefromjpeg("{$pathToImages}{$fname}");
        }

      // load image and get image size
      $width = imagesx( $img );
      $height = imagesy( $img );

    // this will be our cropped image

    // copy the crop area from the source image to the blank image created above

    // calculate thumbnail size
      $new_width = $thumbWidth;
      $new_height = $height * $new_width / $width;
      $new_height = intval ($new_height);

      // create a new tempopary image
      $tmp_img = imagecreatetruecolor( $new_width, $new_height );


      // copy and resize old image into new image
      imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );


    if (strtolower($info['extension']) === 'jpg')
    {
            imagejpeg($tmp_img, "{$pathToThumbs}small_$fname", 100);
    }

    imagedestroy($img);
    imagedestroy($tmp_img);
    $i++;
      }
  // close the directory
  closedir( $dir );
}

?>
