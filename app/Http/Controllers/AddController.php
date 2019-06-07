<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Author;
use App\Heading;
use App\News;
use App\NewsHeading;

class AddController extends Controller
{
    public function addAuthor(Request $request)
    {
        $data = $request->json()->all();
        $author = new Author();
        $author->author_name = $data['author_name'];
        $author->author_surname = $data['author_surname'];
        if (isset($data['author_avatar'])) {
            $author->addMediaFromRequest('author_avatar')->toMediaCollection('avatars');
        }
        $author->save();

        return response()->json('success');
    }

    public function addHeading(Request $request)
    {
        $data = $request->json()->all();
        $heading = new Heading();
        $heading->heading_name = $data['heading_name'];
        if (isset($data['parent_heading_id'])) {
            $heading->parent_heading_id = $data['parent_heading_id'];
        } else {
            $heading->parent_heading_id = 0;
        }
        $heading->save();

        return response()->json('success');
    }

    public function addNews(Request $request)
    {
        $data = $request->json()->all();
        $news = new News();
        $news->news_name = $data['news_name'];
        $news->news_text = $data['news_text'];
        $news->author_id = $data['author_id'];
        $news->save();

        $headings_ids = $data['headings'];
        foreach ($headings_ids as $heading_id) {
            $news_heading = new NewsHeading();
            $newsS = News::getNewsByNewsNameAndAuthorId($data['news_name'], $data['author_id'])->get();
            $news_id = $newsS[0]->news_id;
            $news_heading->news_id = $news_id;
            $news_heading->heading_id = $heading_id;
            $news_heading->save();
        }

        return response()->json('success');
    }
}
