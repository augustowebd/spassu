<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static find(int $id)
 *
 * @property int $codl
 * @property string $titulo
 * @property string $editora
 * @property string $edicao
 * @property string $anoPublicacao
 * @property float $preco
 */
class Livro extends Model
{
    use HasFactory;

    protected $table = 'livros';
    protected $primaryKey = 'codl';
    public $timestamps = false;
    protected $fillable = [
        'titulo',
        'editora',
        'edicao',
        'anoPublicacao',
        'preco',
    ];

    # N:N com Autor
    public function autores(): BelongsToMany
    {
        return $this->belongsToMany(
            related:Autor::class,
            table: 'livro_autor',
            foreignPivotKey: 'livro_codl',
            relatedPivotKey: 'autor_codAu',
        );
    }

    # N:N com Assunto
    public function assuntos(): BelongsToMany
    {
        return $this->belongsToMany(
            related:Assunto::class,
            table: 'livro_assunto',
            foreignPivotKey: 'livro_codl',
            relatedPivotKey: 'assunto_codAs'
        );
    }
}
