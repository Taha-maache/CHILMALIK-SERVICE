<?php

require __DIR__ . '/../vendor/autoload.php';

use Dompdf\Options;
use Dompdf\Dompdf;

// Set up DomPDF options
$options = new Options();
$options->set('isFontSubsettingEnabled', true);
$options->set('defaultFont', 'arabictypesetting');
$options->setChroot(__DIR__);

// Create Dompdf instance
$dompdf = new Dompdf($options);

// Test output
echo "Dompdf is ready. Fonts will be handled via @font-face.";
