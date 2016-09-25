<?php

namespace InfinityNext\Sleuth\Detectives;

use InfinityNext\Sleuth\Contracts\DetectiveContract;
use InfinityNext\Sleuth\Traits\DetectiveTrait;
use Smalot\PdfParser\Parser as PdfParser;

class pdfDetective implements DetectiveContract
{
    use DetectiveTrait;

    /**
     * Checks if this file is a valid PDF.
     *
     * @return boolean|null
     */
    protected function leadPDF()
    {
        $parser = new PdfParser();

        try
        {
            $pdf = $parser->parseFile($this->file);
        }
        catch (\Exception $e)
        {
            return null;
        }

        $details = $pdf->getDetails();

        foreach ($details as $property => $value)
        {
            $key = strtolower($property);

            if (is_array($value))
            {
                $value = implode(', ', $value);
            }

            $metadata[$key] = $value;
        }

        return $this->closeCase("pdf", "application/pdf", $metadata);
    }

    /**
     * Can this file type potentially cause damage or intrude on a user's privacy?
     * This means executable programs, or file formats that can contact remote servers in any way (even SVGs).
     *
     * @return boolean
     * @throws \InfinityNext\Sleuth\Exceptions\CaseNotSolved
     */
    public function isRisky()
    {
        parent::isRisky();

        return true;
    }

    /**
     * Can the system run this Detective?
     *
     * @return boolean  True if we can run, False if not.
     */
    public function on()
    {
        return @class_exists(PdfParser::class);
    }
}
