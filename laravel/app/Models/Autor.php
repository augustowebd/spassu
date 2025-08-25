<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static where(array $array)
 * @property mixed $codAu
 * @property mixed $nome
 */
class Autor extends Model
{
    use HasFactory;

    protected $table = 'autores';
    protected $primaryKey = 'codAu';
    public $timestamps = false;
    protected $fillable = [
        'nome',
    ];

    public function livros(): BelongsToMany
    {
        return $this->belongsToMany(
            related: Livro::class,
            table: 'livro_autor',
            foreignPivotKey: 'autor_codAu',
            relatedPivotKey: 'livro_codl'
        );
    }
}
