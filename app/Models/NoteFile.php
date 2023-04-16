<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoteFile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['file_name', 'file_path', 'note_id'];


    /**
     * Relationship ship with his note attachment.
     *
     * @var array
     */
    public function note()
    {
        return $this->belongsTo(Note::class);
    }
}
