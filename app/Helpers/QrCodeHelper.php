<?php

namespace App\Helpers;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\ErrorCorrectionLevel;

class QrCodeHelper
{
    public static function generate($data)
    {
        $qrCode = new QrCode($data);
        $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::High);
        $qrCode->setSize(300);
        $qrCode->setMargin(10);

        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        return $result->getDataUri();
    }

    public static function generateSvg($data)
    {
        $qrCode = new QrCode($data);
        $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::High);
        $qrCode->setSize(300);
        $qrCode->setMargin(10);

        $writer = new \Endroid\QrCode\Writer\SvgWriter();
        $result = $writer->write($qrCode);

        return $result->getString();
    }
}
