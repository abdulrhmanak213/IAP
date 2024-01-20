<?php

namespace App\Observers;

use App\Models\File;
use App\Models\FileLog;

class FileObserver
{
    /**
     * Handle the File "created" event.
     */
    public function created(File $file): void
    {

    }

    /**
     * Handle the File "updated" event.
     */
    public function updated(File $file): void
    {
//        $operation = $this->getOperation($file);
//        $user = auth()->user();
//        FileLog::query()->create([
//            'user_id' => $user->id,
//            'file_id' => $file->id,
//            'operation' => $operation
//        ]);
    }

    /**
     * Handle the File "deleted" event.
     */
    public function deleted(File $file): void
    {
        //
    }

    /**
     * Handle the File "restored" event.
     */
    public function restored(File $file): void
    {
        //
    }

    /**
     * Handle the File "force deleted" event.
     */
    public function forceDeleted(File $file): void
    {
        //
    }


    private function getOperation($file)
    {
        if ($file->media->first()->update_at == now())
            return 'update';
        elseif ($file->status == 0)
            return 'check-out';
        else {
            return 'check-in';
        }
    }
}
