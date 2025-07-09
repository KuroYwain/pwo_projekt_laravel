<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JobTask;
use App\Jobs\ProcessJobTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class QueueController extends Controller
{
    public function enqueue(/*Request $request*/)
    {
        dd(Redis::set('test_key', 'Hello from Azure Redis with SSL'));

        $task = JobTask::create([
            'name' => $request->input('name', 'default'),
            'status' => 'pending',
        ]);

        ProcessJobTask::dispatch($task->id);

        return response()->json(['id' => $task->id]);
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
