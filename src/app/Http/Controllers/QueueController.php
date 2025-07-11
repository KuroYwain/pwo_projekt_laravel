<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JobTask;
use App\Jobs\ProcessJobTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;


class QueueController extends Controller
{
    public function enqueue(Request $request)
    {
        $type = $request->input('type');

        switch ($type) {
            case 'create_order':
                $validated = $request->validate([
                    'type' => 'required|string',
                    'user_id' => 'required|integer',
                    'product_id' => 'required|integer',
                    'quantity' => 'required|integer|min:1',
                ]);
                break;

            case 'update_user':
                $validated = $request->validate([
                    'type' => 'required|string',
                    'user_id' => 'required|integer',
                    'name' => 'nullable|string',
                    'email' => 'nullable|email',
                ]);
                break;

            case 'send_email':
                $validated = $request->validate([
                    'type' => 'required|string',
                    'to' => 'required|email',
                    'subject' => 'required|string',
                    'body' => 'required|string',
                ]);
                break;

            default:
                return response()->json([
                    'error' => "Unsupported task type: {$type}"
                ], 422);
        }

        $taskId = (string) Str::uuid();

        $payload = array_merge($validated, [
            'task_id' => $taskId,
            'queued_at' => now()->toISOString(),
        ]);

        $queue = 'queue:client1';

        Redis::rpush($queue, json_encode($payload));

        return response()->json([
            'message' => "✅ Task '{$type}' enqueued to {$queue}.",
            'task_id' => $taskId,
            'queue' => $queue,
        ], 202);
    }

    public function status($id)
    {
        $task = JobTask::find($id);
        if (!$task) {
            return response()->json(['error' => 'Not found'], 404);
        }

        return response()->json(['status' => $task->status]);
    }
}
