<?php
// app/Models/Document.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'name',
        'template_path',
        'generated_path',
        'status'
    ];
}