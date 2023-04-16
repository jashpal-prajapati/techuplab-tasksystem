<?php
/**
 * Services
 * PHP version 8.2
 *
 * @category App\Http\Services
 * @package  Task System
 * @author   Jashpal <prajapati_jashpal18@yahoo.com>
 * @license  <prajapati_jashpal18@yahoo.com> N/A
 * @link     Jashpal <prajapati_jashpal18@yahoo.com>
 */

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Note;
use App\Models\NoteFile;
use Illuminate\Support\Facades\File;

/**
 * Services
 * PHP version 8.2
 *
 * @category App\Http\Services
 * @package  Task System
 * @author   Jashpal <prajapati_jashpal18@yahoo.com>
 * @license  <prajapati_jashpal18@yahoo.com> N/A
 * @link     Jashpal <prajapati_jashpal18@yahoo.com>
 */

class TaskService
{
    /**
     * Get task list
     *
     * @param Request $request
     * @author Jashpal <prajapati_jashpal18@yahoo.com>
     * @return void
     */
    public function index(Request $request)
    {
        $task = Task::with('notes', 'notes.notefiles')
                ->when($request->status, function($q) use($request) {
                    $q->where('status', $request->status);
                })
                ->when($request->due_date, function($q) use($request){
                    $q->whereDate('due_date', $request->due_date);
                })
                ->when($request->priority, function($q) use($request){
                    $q->where('priority', $request->priority);
                })
                ->when($request->notes, function($q) use($request){
                    $q->whereHas('notes');
                })
                ->orderBy('priority')
                ->get();
        return $task;
    }

    /**
     * Creating task
     *
     * @param Request $request
     * @author Jashpal <prajapati_jashpal18@yahoo.com>
     * @return \Illuminate\Http\Response
     */
    public function storeTask(Request $request)
    {
        $taskData = $request->all();
        //Create Task
        $res = Task::create($taskData);
        $data['status'] = false;
        $data['message'] = 'task not created succesfully !!'; 
        $data['error'] = '';
        if($res) {
            $nres = $this->storeTaskNote($res->id, $request);
            $data['status'] = true;
            $data['message'] = 'task created succesfully !!';
            $data['error'] = (!$nres['status']) ? $nres['msg'] : '';
            return $data;
        }
        return $data;
    }

    /**
     * Creating notes
     *
     * @param int $taskId
     * @param Request $request
     * @author Jashpal <prajapati_jashpal18@yahoo.com>
     * @return \Illuminate\Http\Response
     */
    private function storeTaskNote($taskId,  $request)
    {
        $data = $request->all();
        if($data['notes']){
            try {                
                foreach ($data['notes'] as $note) {
                    $notesData['subject'] = $note['note_subject'];
                    $notesData['notes'] = $note['note_description'];
                    $notesData['task_id'] = $taskId;
                    //Create Note
                    $nres = Note::create($notesData);
                    
                    if($nres && $note['note_attachment']) {
                        $destPath = public_path('uploads/notes');
                        //create directory if not exits
                        if (!File::isDirectory($destPath)) {
                            File::makeDirectory($destPath, 0777, true, true);
                        }
                        $noteAttachment = $note['note_attachment'];
                        foreach ($noteAttachment as $attach) {
                            $filePath = date('YmdHisv') . "." . $attach->getClientOriginalExtension();
                            //Upload files
                            if ($attach->move($destPath, $filePath)) {
                                $nAttachData['file_name'] =  $filePath;
                                $nAttachData['file_path'] = 'uploads/notes';
                                $nAttachData['note_id'] =  $nres->id;
                                //Create Note Attachment
                                $nAttres = NoteFile::create($nAttachData);
                            }
                        }
                    }
                }
                return ['status' => true, 'msg' => 'note created !!'];
            } catch (Exception $e) {
                return ['status' => false, 'msg' => $e->getMessage()];
            }
        }
        return ['status' => false, 'msg' => 'something went wrong while create note !!'];
    }
}
