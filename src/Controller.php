<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace stee1cat\CommerceMLExchange;

/**
 * Class Controller
 * @package stee1cat\CommerceMLExchange
 */
class Controller extends AbstractController {

    public function stageCheckauth() {
        $username = $_SERVER['PHP_AUTH_USER'];
        $password = $_SERVER['PHP_AUTH_PW'];

        if ($this->checkAuth($username, $password)) {
            $this->success(session_name() . PHP_EOL . session_id());
        }
        else {
            $this->failure(sprintf('Access denied for %s.', $username));
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

        if (!preg_match('/^[0-9a-zA-Z_\-.\/]+$/', $_GET['filename'])) {
            $this->failure('Incorrect file name');
        }

        if (!$this->prepareUploadPath()) {
            $this->failure('Failed to prepare directory');
        }

        $this->writeFile();

        $this->success();
    }

    public function stageImport() {
        if (!isset($_GET['filename'])) {
            $this->failure('Empty filename');
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
     * @param string $username
     * @param string $password
     *
     * @return boolean
     */
    protected function checkAuth($username, $password) {
        return $this->config->getUsername() === $username && $this->config->getPassword() === $password;
    }

    private function writeFile() {
        $filename = $this->config->getUploadPath() . DIRECTORY_SEPARATOR . basename($_GET['filename']);

        $handle = fopen($filename, 'ab');
        if (!$handle) {
            $this->failure('Error opening file');
        }

        $data = file_get_contents('php://input');
        $result = fwrite($handle, $data);
        fclose($handle);

        $size = strlen($data);
        if ($result !== $size) {
            $this->failure('Wrong data size written');
        }
    }

}