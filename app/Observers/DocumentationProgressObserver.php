<?php

namespace App\Observers;

use App\Models\DocumentationProgress;
use App\Models\OnProgress;
use App\Models\Progress;

class DocumentationProgressObserver
{
    /**
     * Handle the DocumentationProgress "created" event.
     *
     * @param \App\Models\DocumentationProgress $documentation
     * @return void
     */
    public function created(DocumentationProgress $documentation)
    {
        $jmlh = DocumentationProgress::where('kode_on_progress', $documentation->kode_on_progress)->count();
        OnProgress::where('id', $documentation->kode_on_progress)->update(['documentation' => $jmlh]);
    }
}
