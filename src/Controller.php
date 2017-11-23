<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange;

use stee1cat\CommerceMLExchange\Model\AuthData;

/**
 * Class Controller
 * @package stee1cat\CommerceMLExchange
 */
class Controller extends AbstractController {

    public function stageCheckauth() {
        $authData = new AuthData();

        if ($this->checkAuth($authData)) {
            $this->success(session_name() . PHP_EOL . session_id());
        }
        else {
            $this->failure(sprintf('Access denied for %s.', $authData->getUsername()));
        }
    }

    public function stageInit() {
        if ($this->config->isZipSupport()) {
            $response = 'zip=yes';
        }
        else {
            $response = 'zip=no';
        }

        $response .= PHP_EOL . sprintf('file_limit=%d', $this->config->getFileSizeLimit());

        $this->message($response);
        $this->logger->info('< SUCCESS ' . $response);

        if (isset($_GET['version'])) {
            $_SESSION['version'] = $_GET['version'];
        }
    }

    public function stageUpload() {
        if (!isset($_GET['filename'])) {
            $this->failure('Empty filename');
        }

        if (!$this->validateFilename($_GET['filename'])) {
            $this->failure('Incorrect file name');
        }

        if (!$this->prepareUploadPath()) {
            $this->failure('Failed to prepare directory');
        }

        if ($this->writeFile()) {
            $this->success();
        }
    }

    public function stageImport() {
        if (!isset($_GET['filename'])) {
            $this->failure('Empty filename');
        }

        if (!$this->validateFilename($_GET['filename'])) {
            $this->failure('Incorrect file name');
        }

        $filePath = $this->getFilePath($_GET['filename']);
        if (!file_exists($filePath)) {
            $this->failure('File not exists');
        }

        $this->success();
    }

    protected function prepareUploadPath() {
        $mode = 0777;
        $uploadPath = rtrim($this->config->getUploadPath(), '/\\');

        if (!is_dir($uploadPath)) {
            return mkdir($uploadPath, $mode);
        }

        if (is_writable($uploadPath)) {
            return chmod($uploadPath, $mode);
        }

        return true;
    }

    /**
     * @param AuthData $authData
     *
     * @return boolean
     *
     */
    protected function checkAuth(AuthData $authData) {
        $usernameIsValid = $this->config->getUsername() === $authData->getUsername();
        $passwordIsValid = $this->config->getPassword() === $authData->getPassword();

        return $usernameIsValid && $passwordIsValid;
    }

    protected function getFilePath($filename) {
        return $this->config->getUploadPath() . DIRECTORY_SEPARATOR . basename($filename);
    }

    protected function writeFile() {
        $filePath = $this->getFilePath($_GET['filename']);

        $handle = fopen($filePath, 'ab');
        if (!$handle) {
            $this->failure('Error opening file');

            return false;
        }

        $data = file_get_contents('php://input');
        $result = fwrite($handle, $data);
        fclose($handle);

        $size = strlen($data);
        if ($result !== $size) {
            $this->failure('Wrong data size written');

            return false;
        }

        return true;
    }

    /**
     * @param string $filename
     *
     * @return bool
     */
    protected function validateFilename($filename) {
        return !!preg_match('/^[0-9a-zA-Z_\-.\/]+$/', $filename);
    }

}