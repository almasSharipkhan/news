<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Heading extends Model
{
    protected $table = 'headings';

    protected $primaryKey = 'heading_id';

    protected $fillable = [
        'heading_name',
        'parent_heading_id',
    ];

    public $timestamps = false;

    public function scopeGetHeadingByHeadingName($query, $heading_name)
    {
        return $query->where('heading_name', $heading_name);
    }

    public function scopeGetHeadingByParentHeadingId($query, $parent_heading_id)
    {
        return $query->where('parent_heading_id', $parent_heading_id);
    }

    public function newsHeadings()
    {
        return $this->hasMany(NewsHeading::class, 'heading_id', 'heading_id');
    }
}