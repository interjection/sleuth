<?php

namespace InfinityNext\Sleuth\Detectives;

use InfinityNext\Sleuth\Contracts\DetectiveContract;
use InfinityNext\Sleuth\Traits\DetectiveTrait;
use ZipArchive;

class epubDetective implements DetectiveContract
{
    use DetectiveTrait;

    /**
     * Checks if this file is a valid EPUB.
     *
     * @return boolean|null
     */
    protected function leadEPUB()
    {
        $epub = new ZipArchive();

        if ($epub->open($this->file, ZipArchive::CHECKCONS) !== true)
        {
            return null;
        }

        // Try reading the container file
        $container = $epub->getFromName("META-INF/container.xml");

        if (!$container)
        {
            return null;
        }

        // Parse the container and find the rootfile
        $containerXML  = simplexml_load_string($container);
        $rootFilePath  = $containerXML->rootfiles->rootfile[0]['full-path'];
        // Try reading the rootfile
        $rootFile      = $epub->getFromName($rootFilePath);

        if (!$rootFile)
        {
            return null;
        }

        // Parse the rootfile
        $rootFileXML      = simplexml_load_string($rootFile);
        // Determine if the manifest has child elements
        $rootFileManifest = $rootFileXML->manifest->children();

        if (!$rootFileManifest)
        {
            return null;
        }

        // Populate metadata with Dublin Core elements
        $this->metadata = (array) $rootFileXML->metadata->children('dc', true);

        return $this->closeCase("epub", "application/epub+zip", $this->metadata);
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
        return (function_exists('simplexml_load_string') ? true : false) && (class_exists('ZipArchive') ? true : false);
    }
}
