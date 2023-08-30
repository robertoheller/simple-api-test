<?php

namespace App\Observers;

use App\Models\Task;

class TaskObserver
{
    /**
     * Handle the file "saving" event.
     *
     * @param  \App\Models\Task  $chamado
     * @return void
     */
    public function saving(Task $task)
    {

        if($task->completed==1 and $task->isDirty('completed') )
            $task->completed_at = \Carbon\Carbon::now();

    }
}
