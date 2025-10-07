<?php

namespace App\Console\Commands;

use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class MarkOverdueTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark all tasks with past due dates as overdue';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Marking overdue tasks...');
        
        $now = Carbon::now()->toDateString();

        $count = Task::query()
            ->whereDate('due_date', '<', $now)
            ->whereNotIn('status', [
                TaskStatus::COMPLETED->value,
                TaskStatus::CANCELLED->value,
                TaskStatus::OVERDUE->value,
            ])
            ->update([
                'status' => TaskStatus::OVERDUE->value,
            ]);

        $this->info("{$count} tasks marked as overdue.");
    }
}
