<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VwLivroAssunto extends Model
{
    protected $table = 'vw_livros_por_assunto';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];
}
