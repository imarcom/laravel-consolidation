<?php

namespace Imarcom\Consolidation;


class Consolidation
{

    public $overrideRelativePath;
    public $originalRelativePath;
    public $hashRelativePath;
    public $valid = false;
    public $hash;

    public function __construct(string $originalRelativePath, string $overrideRelativePath, string $hashRelativePath)
    {
        $this->originalRelativePath = trim($originalRelativePath, '/');
        $this->overrideRelativePath = trim($overrideRelativePath, '/');
        $this->hashRelativePath = $hashRelativePath;
    }

    public function exist()
    {
        return is_file(base_path($this->originalRelativePath)) && is_file(base_path($this->overrideRelativePath));
    }

    public function validateHash()
    {
        $this->hash = $this->generateHash($this->originalRelativePath, $this->overrideRelativePath);

        if (! file_exists(base_path($this->hashRelativePath))) {
            $this->touch(base_path($this->hashRelativePath));
        }

        if (trim(file_get_contents(base_path($this->hashRelativePath))) === $this->hash) {
            $this->valid = true;
        }

        return $this->valid;
    }

    private function generateHash($originalRelativePath, $overrideRelativePath)
    {
        return sha1_file(base_path($originalRelativePath)) . '+' . sha1_file(base_path($overrideRelativePath));
    }

    private function touch($path)
    {
        if (! is_dir(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }

        touch($path);
    }

}
