<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;
use App\Services\TaskHandlers\UpdateUserHandler;
use App\Services\TaskHandlers\DummyHandler;
use App\Services\TaskHandlers\TaskHandlerInterface;
use Illuminate\Support\Facades\DB;

class ProcessClientQueue extends Command
{
    protected $signature = 'agent:run';
    protected $description = 'Universal agent processing tasks from multiple Redis queues';

    protected array $handlers;

    public function __construct()
    {
        parent::__construct();

        $this->handlers = [
            'update_user' => new UpdateUserHandler(),
        ];
    }

    public function handle()
    {
        $queues = ['queue:client1', 'queue:client2', 'queue:client3'];

        $this->info("Listening to queues: " . implode(', ', $queues));

        while (true) {
            $task = Redis::blpop($queues, 5); // 5s timeout

            if (!$task) {
                continue;
            }

            $queueName = $task[0];
            $json = $task[1];

            $payload = json_decode($json, true);
            $type = $payload['type'] ?? 'unknown';

            $handler = $this->handlers[$type] ?? new DummyHandler();

            try {
                $handler->handle($payload);
                $this->logTask($type, $queueName, 'success', $json);
                $this->info("✅ Task $type processed from $queueName");
            } catch (\Throwable $e) {
                $this->logTask($type, $queueName, 'failed', $json, $e->getMessage());
                $this->error("❌ Task $type failed: " . $e->getMessage());
            }
        }
    }

    protected function logTask(string $type, string $queue, string $status, string $rawPayload, ?string $error = null): void
    {
        DB::table('task_logs')->insert([
            'type' => $type,
            'queue' => $queue,
            'status' => $status,
            'payload' => $rawPayload,
            'error' => $error,
            'created_at' => now(),
        ]);
    }
}
