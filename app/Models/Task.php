<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['subject', 'description', 'start_date', 'due_date', 'status', 'priority'];

    /**
     * Relationship ship with his notes.
     *
     * @var array
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}


