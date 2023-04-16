<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['subject', 'notes', 'task_id'];

    /**
     * Relationship ship with his notes attachment.
     *
     * @var array
     */
    public function notefiles()
    {
        return $this->hasMany(NoteFile::class);
    }
}
