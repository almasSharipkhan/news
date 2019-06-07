<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';

    protected $primaryKey = 'news_id';

    protected $fillable = [
        'news_name',
        'news_text',
        'author_id',
    ];

    public $timestamps = true;

    public function scopeGetAllNewsByAuthorId($query, $author_id)
    {
        return $query->where('author_id', $author_id);
    }

    public function scopeGetNewsByNewsName($query, $news_name)
    {
        return $query->where('news_name', $news_name);
    }

    public function scopeGetNewsByNewsNameAndAuthorId($query, $news_name, $author_id)
    {
        return $query->where([
            ['news_name', $news_name],
            ['author_id', $author_id],
        ]);
    }

    public function author()
    {
        return $this->hasOne('App\Author', 'author_id', 'author_id');
    }

    public function newsHeadings()
    {
        return $this->hasMany(NewsHeading::class, 'news_id', 'news_id');
    }
}