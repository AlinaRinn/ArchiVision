<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/layouts/header.php');

$strURL = htmlspecialchars($_POST["URL"]);

$url = 'https://definingstylearchitecture.cognitiveservices.azure.com/customvision/v3.0/Prediction/947e6fce-51fd-4e92-9702-f9e36108f0ac/classify/iterations/Iteration7/url';

$data = '{Url:"' . $strURL . '"}';

$options = array(
    'http' => array(
        'header'  => "Content-type: application/json\r\n" . "Prediction-key: d00484faf804471dba0979f67be21bcf\r\n",
        'method'  => 'POST',
        'content' => $data
    )
);

$context  = stream_context_create($options);
$result = file_get_contents( $url, false, $context );
$response = json_decode($result, true);

if($response === NULL) {
    echo "<br>Неверный URL изображения";
}
else {
    //print_r($response);
    $answer0 = $response['predictions'][0]['tagName'] . " с вероятностью " . $response['predictions'][0]['probability'] * 100 . " %" . "<br>";
    $answer1 = $response['predictions'][1]['tagName'] . " с вероятностью " . $response['predictions'][1]['probability'] * 100 . " %" . "<br>";
    $answer2 = $response['predictions'][2]['tagName'] . " с вероятностью " . $response['predictions'][2]['probability'] * 100 . " %" . "<br>";
    echo "Архитектурные стили:<br><br>" . $answer0 . "<br>" . $answer1 . "<br>" . $answer2;
}


require_once($_SERVER['DOCUMENT_ROOT'] . '/layouts/footer.php');