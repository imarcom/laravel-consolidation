<?php

if (! function_exists('glob_recursive')) {
    function glob_recursive($pattern, $flags = 0)
    {
        $files = glob($pattern, $flags);

        foreach (glob(dirname($pattern) . '/*', GLOB_ONLYDIR | GLOB_NOSORT) as $dir) {
            $files = array_merge($files, glob_recursive($dir . '/' . basename($pattern), $flags));
        }

        return $files;
    }
}

if (! function_exists('make_file')) {
    function make_file($path)
    {
        if (! is_dir(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }

        touch($path);
    }
}

if (! function_exists('compatible_sha1_file')) {
    /**
     * Fix sha1_file hashing between Windows and Unix systems
     * Windows EOL = "\r\n", Unix EOL = "\n"
     */
    function compatible_sha1_file($basePath)
    {
        return sha1(preg_replace("#\r\n#", "\n", file_get_contents($basePath)));
    }
}
