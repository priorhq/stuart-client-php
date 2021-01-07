<?php

namespace Stuart\Cache;

use Psr\SimpleCache\CacheInterface;
use Stuart\Infrastructure\StuartAccessToken;

class DiskCache implements CacheInterface
{
    private $fileName;

    /**
     * DiskCache constructor.
     */
    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    private function getContent()
    {
        if (file_exists($this->fileName)) {
            return file_get_contents($this->fileName);
        } else {
            return "";
        }
    }

    /**
     * @inheritDoc
     */
    public function get($key, $default = null)
    {
        $content = $this->getContent();
        if ($content && strlen($content) > 0) {
            $objectWithTokens = json_decode($content);
            $asArray = json_decode(json_encode($objectWithTokens), true);
            $token = $asArray[$key];
            if ($token) {
                return new StuartAccessToken($token);
            }
        }
        return null;
    }

    /**
     * @inheritDoc
     */
    public function set($key, $value, $ttl = null)
    {
        $arrToWrite = null;
        $content = $this->getContent();
        if ($content && strlen($content) > 0) {
            $objectWithTokens = json_decode($content);
            $asArray = json_decode(json_encode($objectWithTokens), true);
            $asArray[$key] = $value;
            $arrToWrite = $asArray;
        } else {
            $arrToWrite = array($key => $value);
        }
        $file = fopen($this->fileName, "w");
        fwrite($file, json_encode($arrToWrite));
        fclose($file);
    }

    /**
     * @inheritDoc
     */
    public function delete($key)
    {
        throw new Exception('Not implemented');
    }

    /**
     * @inheritDoc
     */
    public function clear()
    {
        throw new Exception('Not implemented');
    }

    /**
     * @inheritDoc
     */
    public function getMultiple($keys, $default = null)
    {
        throw new Exception('Not implemented');
    }

    /**
     * @inheritDoc
     */
    public function setMultiple($values, $ttl = null)
    {
        throw new Exception('Not implemented');
    }

    /**
     * @inheritDoc
     */
    public function deleteMultiple($keys)
    {
        throw new Exception('Not implemented');
    }

    /**
     * @inheritDoc
     */
    public function has($key)
    {
        throw new Exception('Not implemented');
    }
}
