<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Author extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $table = 'authors';

    protected $primaryKey = 'author_id';

    protected $fillable = [
        'author_name',
        'author_surname',
    ];

    public $timestamps = false;

    public function registerAllMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(60)
            ->height(60);
    }

    public function scopeGetAuthorByAuthorNameAndAuthorSurname($query, $author_name, $author_surname)
    {
        return $query->where([
            ['author_name', $author_name],
            ['author_surname', $author_surname],
        ]);
    }

    public function news()
    {
        return $this->belongsToMany(News::class, 'news','author_id', 'author_id');
    }
}