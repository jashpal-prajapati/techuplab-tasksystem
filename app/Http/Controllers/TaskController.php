<?php

/**
 * Controller
 * PHP version 8.2
 *
 * @category App\Http\Controllers
 * @package  Task System
 * @author   Jashpal <prajapati_jashpal18@yahoo.com>
 * @license  <prajapati_jashpal18@yahoo.com> N/A
 * @link     Jashpal <prajapati_jashpal18@yahoo.com>
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\TaskService;
use Illuminate\Http\Request;
use App\Models\Task;
use Validator;
use Auth;

/**
 * Controller
 * PHP version 8.2
 *
 * @category App\Http\Controllers
 * @package  Task System
 * @author   Jashpal <prajapati_jashpal18@yahoo.com>
 * @license  <prajapati_jashpal18@yahoo.com> N/A
 * @link     Jashpal <prajapati_jashpal18@yahoo.com>
 */

class TaskController extends Controller
{
    protected $taskService;
    
    /**
     * Create a controller instance.
     *
     * @param TaskService $taskService
     * @author Jashpal <prajapati_jashpal18@yahoo.com>
     * @return void
     */
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Get task list
     *
     * @param Request $request
     * @author Jashpal <prajapati_jashpal18@yahoo.com>
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $result = $this->taskService->index($request);

        $data['status'] = true;
        $data['data'] = $result;
        $data['message'] = 'task list succesfully !!';

        return response()->json($data, 201);
    }

    /**
     * Creating task
     *
     * @param Request $request
     * @author Jashpal <prajapati_jashpal18@yahoo.com>
     * @return \Illuminate\Http\Response
     */
    public function createTask(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'start_date' => 'required|date|before_or_equal:due_date',
            'due_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:New,Incomplete,Complete',
            'priority' => 'required|in:High,Medium,Low'
        ]);

        if($validator->fails()) {
            $res = [
                'status' => false,
                'messages' => $validator->errors()
            ];
            return response()->json($res, 422);
        }
        //Task service
        $result = $this->taskService->storeTask($request);
        
        $data['status'] = false;
        $data['message'] = 'task not created succesfully !!';
        $data['error'] = ''; 
        if($result['status']) {
            $data['status'] = true;
            $data['message'] = 'task created succesfully !!';
            $data['error'] = ($result['error']) ? $result['error'] : '';
            return response()->json($data, 201);
        }
        return response()->json($data, 200);
    }
}
