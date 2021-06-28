<?php

$url = 'https://definingstylearchitecture.cognitiveservices.azure.com/customvision/v3.0/Prediction/947e6fce-51fd-4e92-9702-f9e36108f0ac/classify/iterations/Iteration7/url';

$data = '{Url:"https://lh3.googleusercontent.com/proxy/gRh1pf2XVVk5EwzGA8a2h9I9nXPpFd59bkynpBCXyv42YkAXsXMbuH6d0RHna98xj9Rox1RqhFedhuayIpOjPRSYas1B6mJQHfVWhjlRABdwTT7L83xgfkflQfk62AjpyiX77g8"}';

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
echo "<pre>" . print_r($response) . "</pre>";
$answer0 = $response['predictions'][0]['tagName'] . "   " . $response['predictions'][0]['probability'] . "<br>";
$answer1 = $response['predictions'][1]['tagName'] . "   " . $response['predictions'][1]['probability'] . "<br>";
$answer2 = $response['predictions'][2]['tagName'] . "   " . $response['predictions'][2]['probability'] . "<br>";
echo $answer0 . $answer1 . $answer2;