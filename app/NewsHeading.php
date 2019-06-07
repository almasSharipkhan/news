<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsHeading extends Model
{
    protected $table = 'news_headings';

    protected $primaryKey = 'news_heading_id';

    protected $fillable = [
        'news_id',
        'heading_id',
    ];

    public $timestamps = false;

    public function news()
    {
        return $this->belongsTo(News::class, 'news_id', 'news_id');
    }

    public function heading()
    {
        return $this->belongsTo(Heading::class, 'heading_id', 'heading_id');
    }
}