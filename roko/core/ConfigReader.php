<?php
    namespace Roko\Core;
    use Roko\Helper\Arr;

    class ConfigReader {
        private $basePath = './';
        private static $varCache = [];
        private static $fileCache = [];

        public function __construct(string $basePath) {
            if (empty($basePath) OR !is_dir($basePath)) {
                throw new \Exception('Config base dir not found');
            }
            $this->basePath = $basePath;
        }

        public function get($varPath, $default=null) {
        if (array_key_exists($varPath, self::$varCache)) {
                return self::$varCache[$varPath];
            } else {
                $path = explode('.', $varPath);

                $configFile = $this->basePath.'/'.$path[0].'.php';

                if (!file_exists($configFile)) {
                    throw new \Exception('Config file not found for ['.$varPath.'] path');
                }

                if (array_key_exists($configFile, self::$fileCache)) {
                    $data = self::$fileCache[$configFile];
                } else {
                    $data = include $configFile;
                    self::$fileCache[$configFile] = $data;
                }

                if (count($path) == 1) {
                    return $data;
                } else {
                    array_shift($path);
                    $path = implode('.', $path);
                    $ret = is_null($default)
                           ? Arr::getArrValByVarPathStrict($data, $path)
                           : Arr::getArrValByVarPath($data, $path, $default)
                    ;
                    self::$varCache[$varPath] = $ret;
                    return $ret;
                }
            }
        }
    }
