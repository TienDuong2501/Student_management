<?php

namespace App\Observers;

use App\Models\HomeWork;
use App\Models\DoneHomeWork;
use Illuminate\Support\Facades\Storage;

class HomeworkObserver
{
    /**
     * Handle the home work "created" event.
     *
     * @param  \App\HomeWork  $homeWork
     * @return void
     */
    public function created(HomeWork $homeWork)
    {
        //
    }

    /**
     * Handle the home work "updated" event.
     *
     * @param  \App\HomeWork  $homeWork
     * @return void
     */
    public function updated(HomeWork $homeWork)
    {
        //
    }

    /**
     * Handle the home work "deleted" event.
     *
     * @param  \App\HomeWork  $homeWork
     * @return void
     */
    public function deleted(HomeWork $homeWork)
    {
        foreach ($homeWork->answers as $answer) {
            Storage::disk('public')->delete($answer->saved_path);
        }

        $delete = DoneHomeWork::where('home_work_id', $homeWork->id)->delete();
        if ($delete) {
            return true;
        }

        return false;
    }

    /**
     * Handle the home work "restored" event.
     *
     * @param  \App\HomeWork  $homeWork
     * @return void
     */
    public function restored(HomeWork $homeWork)
    {
        //
    }

    /**
     * Handle the home work "force deleted" event.
     *
     * @param  \App\HomeWork  $homeWork
     * @return void
     */
    public function forceDeleted(HomeWork $homeWork)
    {
        //
    }
}
