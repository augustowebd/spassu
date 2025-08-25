<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property mixed $codAs
 * @property mixed $descricao
 * @method static find(int $id)
 * @method static where(array $array)
 */
class Assunto extends Model
{
    use HasFactory;

    protected $table = 'assuntos';
    protected $primaryKey = 'codAs';
    public $timestamps = false;
    protected $fillable = [
        'descricao',
    ];

    public function livros(): BelongsToMany
    {
        return $this->belongsToMany(
            related: Livro::class,
            table: 'livro_assunto',
            foreignPivotKey: 'assunto_codAs',
            relatedPivotKey: 'livro_codl',
        );
    }
}
