<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    // Define the table if it's different from the default table name
    // protected $table = 'assessments';

    // Define the fillable fields
    protected $fillable = ['patient_name', 'assessment_date', 'details'];
}
