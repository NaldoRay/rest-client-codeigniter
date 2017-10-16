<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Author: Ray N
 * Date: 10/2/2017
 * Time: 16:46
 */
class FileViewer
{
    private $tmpFile;

	public function viewImage ($imagePath, $imageNotFoundPath = null)
	{
		$shown = $this->view($imagePath);
		if (!$shown)
		{
		    if (is_null($imageNotFoundPath))
		        show_404();
		    else
			    $this->viewFile($imageNotFoundPath);
		}
	}

    public function viewRemoteImage ($imageUrl, $imageNotFoundPath = null)
    {
        $tmpFilePath = $this->createTemporaryRemoteFile($imageUrl);
        $shown = $this->view($tmpFilePath);
        if (!$shown)
        {
            if (is_null($imageNotFoundPath))
                show_404();
            else
                $this->viewFile($imageNotFoundPath);
        }
    }

    public function viewFile ($filePath, $renamedFilename = null)
	{
		$shown = $this->view($filePath, $renamedFilename);
		if (!$shown)
		{
			show_404();
		}
	}

    public function viewRemoteFile ($fileUrl, $renamedFilename = null)
    {
        $tmpFilePath = $this->createTemporaryRemoteFile($fileUrl);
        $shown = $this->view($tmpFilePath, $renamedFilename);
        if (!$shown)
        {
            show_404();
        }
    }

    public function downloadFile ($filePath, $renamedFilename = null)
	{
		$shown = $this->download($filePath, $renamedFilename);
		if (!$shown)
		{
			show_404();
		}
	}

    public function downloadRemoteFile ($fileUrl, $renamedFilename = null)
    {
        $tmpFilePath = $this->createTemporaryRemoteFile($fileUrl);
        $shown = $this->download($tmpFilePath, $renamedFilename);
        if (!$shown)
        {
            show_404();
        }
    }

    private function createTemporaryRemoteFile ($fileUrl)
    {
        $content = file_get_contents($fileUrl);
        if ($content === false)
            return null;

        // automatically deleted when the script ends
        $this->tmpFile = tmpfile();
        fwrite($this->tmpFile, $content);

        $metaDatas = stream_get_meta_data($this->tmpFile);
        return $metaDatas['uri'];
    }

    private function view ($filePath, $renamedFilename = null)
    {
        if (is_file($filePath) && file_exists ($filePath))
        {
            $info = new finfo(FILEINFO_MIME_TYPE);
            $contentType = $info->file($filePath);
            $fileSize = filesize($filePath);

            if (!empty($renamedFilename))
                header('Content-Disposition: inline; filename="'.$renamedFilename.'"');

            header('Content-type: ' . $contentType);
            header('Content-length: ' . $fileSize);
            // jangan di-cache
            header('Cache-Control: no-cache, no-store, must-revalidate');
            header('Expires: 0');

            //Baca file dan kirim ke client.
            $ret = readfile($filePath);

            return ($ret !== false);
        }
        return false;
    }

    private function download ($filePath, $renamedFilename)
    {
        if (is_file($filePath) && file_exists ($filePath))
        {
            $info = new finfo(FILEINFO_MIME_TYPE);
            $contentType = $info->file($filePath);
            $fileSize = filesize($filePath);

            header('Content-Type: ' . $contentType);
            header('Content-Disposition: attachment; filename="' . $renamedFilename . '"');
            header('Content-Length: ' . $fileSize);
            // ga perlu di-cache
            header('Cache-Control: no-cache, no-store, must-revalidate');
            header('Expires: 0');

            // matiin output buffering buat ngehindarin masalah memory pas download file besar
            //ob_end_clean();

            $result = readfile($filePath);

            return ($result !== false);
        }
        return false;
    }
}