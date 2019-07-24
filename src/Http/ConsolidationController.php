<?php

namespace Imarcom\Consolidation\Http;

use Imarcom\Consolidation\ConsolidationCollection;

class ConsolidationController
{

    public function index()
    {
        $consolidationCollection = new ConsolidationCollection();

        foreach (config('consolidation.directories_to_compare',[]) as $originalDirectory => $overrideDirectory) {
            $consolidationCollection = (new ConsolidationCollection())
                ->globFiles(base_path($overrideDirectory))
                ->mapConsolidation($originalDirectory, $overrideDirectory)
                ->filterExisting()
                ->validateHash()
                ->merge($consolidationCollection);
        }

        foreach (config('consolidation.files_to_compare',[]) as $originalFile => $overrideFile) {
            $consolidationCollection = (new ConsolidationCollection())
                ->addConsolidationFile($originalFile, $overrideFile)
                ->filterExisting()
                ->validateHash()
                ->merge($consolidationCollection);
        }

        return view('consolidation::index', [
            'consolidationCollection' => $consolidationCollection->sortBy('overrideRelativePath')
        ]);
    }

    public function accept()
    {
        file_put_contents(base_path(request('path')), request('hash'));

        return redirect()->back();
    }

}
