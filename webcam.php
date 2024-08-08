<?php
// Load the OpenCV PHP extension
if (!extension_loaded('opencv')) {
    die('OpenCV extension not loaded');
}

// Define the paths to the model and prototxt files
$modelFile = __DIR__ . '/models/es10_300x300_ssd_iter_140000.caffemodel';
$protoFile = __DIR__ . '/models/deploy.prototxt';

// Load the pre-trained model
$net = cv\Dnn\readNetFromCaffe($protoFile, $modelFile);

// Load an image (you can replace this with capturing a frame from a webcam)
$image = cv\imread(__DIR__ . '/path_to_your_image.jpg');

// Prepare the image for the model
$blob = cv\Dnn\blobFromImage($image, 0.007843, new cv\Size(300, 300), new cv\Scalar(127.5, 127.5, 127.5), false, false);

// Set the input for the neural network
$net->setInput($blob);

// Perform the forward pass to get the detection results
$detections = $net->forward();

// Process the detection results
$rows = $image->rows;
$cols = $image->cols;

for ($i = 0; $i < $detections->shape[2]; $i++) {
    $confidence = $detections->at([0, 0, $i, 2]);

    // Only consider detections with confidence above a certain threshold
    if ($confidence > 0.5) {
        $x1 = intval($detections->at([0, 0, $i, 3]) * $cols);
        $y1 = intval($detections->at([0, 0, $i, 4]) * $rows);
        $x2 = intval($detections->at([0, 0, $i, 5]) * $cols);
        $y2 = intval($detections->at([0, 0, $i, 6]) * $rows);

        // Draw a rectangle around the detected face
        cv\rectangle($image, new cv\Point($x1, $y1), new cv\Point($x2, $y2), new cv\Scalar(0, 255, 0), 2);
    }
}

// Save or display the resulting image
cv\imwrite(__DIR__ . '/result.jpg', $image);
