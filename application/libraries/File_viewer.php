<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('viewer/FileViewer.php');

/**
 * Author: Ray N
 * Date: 10/12/2017
 * Time: 13:07
 */
class File_viewer
{
    private $fileViewer;

    public function __construct ()
    {
        $this->fileViewer = new FileViewer();
    }

    public function viewFile ($filePath)
    {
        $this->fileViewer->viewFile($filePath);
    }

    public function viewRemoteFile ($fileUrl)
    {
        $this->fileViewer->viewRemoteFile($fileUrl);
    }

    public function downloadFile ($filePath)
    {
        $this->fileViewer->downloadFile($filePath);
    }

    public function downloadRemoteFile ($fileUrl)
    {
        $this->fileViewer->downloadRemoteFile($fileUrl);
    }
}