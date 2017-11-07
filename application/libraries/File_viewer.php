<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('viewer/FileViewer.php');

/**
 * @author Ray Naldo
 */
class File_viewer
{
    private $fileViewer;

    public function __construct ()
    {
        $this->fileViewer = new FileViewer();
    }

    public function viewFile ($filePath, $renamedFilename = null)
    {
        $shown = $this->fileViewer->viewFile($filePath, $renamedFilename);
        if (!$shown)
            show_404();
    }

    public function viewRemoteFile ($fileUrl, $renamedFilename = null)
    {
        $shown = $this->fileUrlExists($fileUrl);
        if ($shown)
            $shown = $this->fileViewer->viewRemoteFile($fileUrl, $renamedFilename);

        if (!$shown)
            show_404();
    }

    public function downloadFile ($filePath, $renamedFilename)
    {
        $shown = $this->fileViewer->downloadFile($filePath, $renamedFilename);
        if (!$shown)
            show_404();
    }

    public function downloadRemoteFile ($fileUrl, $renamedFilename)
    {
        $shown = $this->fileUrlExists($fileUrl);
        if ($shown)
            $shown = $this->fileViewer->downloadRemoteFile($fileUrl, $renamedFilename);

        if (!$shown)
            show_404();
    }

    private function fileUrlExists ($url)
    {
        $headers = get_headers($url);
        return substr($headers[0], 9, 3) == "200";
    }
}