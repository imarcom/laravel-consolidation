<?php

namespace Imarcom\Consolidation;

use Illuminate\Support\Collection;

class ConsolidationCollection extends Collection
{

    /**
     * @param string $overrideDirectory
     * @return ConsolidationCollection
     */
    public function globFiles(string $overrideDirectory)
    {
        return (new static(glob_recursive(rtrim($overrideDirectory, '/') . '/*')))
            ->map(function ($file) {
                return str_replace(base_path(), '', $file);
            })
            ->filter(function ($file) {
                return is_file(base_path($file));
            });
    }

    /**
     * @return ConsolidationCollection
     */
    public function filterExisting()
    {
        return $this->filter(function (Consolidation $consolidation) {
            return $consolidation->exist();
        });
    }

    public function mapConsolidation($originalDirectory, $overrideDirectory)
    {
        return $this->map(function ($file) use ($originalDirectory, $overrideDirectory) {
            return new Consolidation(
                str_replace($overrideDirectory, $originalDirectory, $file),
                $file,
                rtrim(config('consolidation.output'), '/') . '/' . ltrim($file, '/')
            );
        });
    }

    public function addConsolidationFile(string $originalFile,string $overrideFile){
        $this->push(new Consolidation(
            $originalFile,
            $overrideFile,
            rtrim(config('consolidation.output'), '/') . '/' . ltrim($overrideFile, '/')
        ));

        return $this;
    }

    public function validateHash()
    {
        $this->each(function (Consolidation $consolidation) {
            $consolidation->validateHash();
        });

        return $this;
    }
}
