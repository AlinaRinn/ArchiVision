<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/layouts/header.php');

if (isset($_FILES['image'])) {
// Получаем нужные элементы массива "image"
    $fileTmpName = $_FILES['image']['tmp_name'];
    $errorCode = $_FILES['image']['error'];
}
else{
    echo "Поток пуст";
}

array_map('unlink', glob(dirname(__FILE__).'/upload/*'));
$name = getRandomFileName($fileTmpName);
$image = getimagesize($fileTmpName);
$extension = image_type_to_extension($image[2]);

if (!move_uploaded_file($fileTmpName, __DIR__ . '/upload/' . $name . $extension)) {
    die('При записи изображения на диск произошла ошибка.');
}
else {
    $output = 'upload/' . $name . $extension;
    echo 'Изображение успешно загружено!';
    echo "<br><br><img src='" . $output . "' alt='Error'><br><br>";
}

echo print_r($_FILES['image']);

$url = 'https://definingstylearchitecture.cognitiveservices.azure.com/customvision/v3.0/Prediction/947e6fce-51fd-4e92-9702-f9e36108f0ac/classify/iterations/Iteration7/image';

$data = $output;

$options = array(
    'http' => array(
        'header'  => "Content-type: image/*\r\n" . "Prediction-key: d00484faf804471dba0979f67be21bcf\r\n",
        'method'  => 'POST',
        'content' => $data
    )
);

$context  = stream_context_create($options);
$result = file_get_contents( $url, false, $context );
$response = json_decode($result, true);

if($response === NULL) {
    echo "<br>Некорректное изображение";
}
else {
    //print_r($response);
    $answer0 = $response['predictions'][0]['tagName'] . " с вероятностью " . $response['predictions'][0]['probability'] * 100 . " %" . "<br>";
    $answer1 = $response['predictions'][1]['tagName'] . " с вероятностью " . $response['predictions'][1]['probability'] * 100 . " %" . "<br>";
    $answer2 = $response['predictions'][2]['tagName'] . " с вероятностью " . $response['predictions'][2]['probability'] * 100 . " %" . "<br>";
    echo "Архитектурные стили:<br><br>" . $answer0 . "<br>" . $answer1 . "<br>" . $answer2;
}

function getRandomFileName($path)
{
    $path = $path ? $path . '/' : '';
    do {
        $name = md5(microtime() . rand(0, 9999));
        $file = $path . $name;
    } while (file_exists($file));

    return $name;
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/layouts/footer.php');
