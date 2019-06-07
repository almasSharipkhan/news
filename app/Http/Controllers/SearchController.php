<?php

namespace App\Http\Controllers;

use App\NewsHeading;
use Illuminate\Http\Request;
use App\Author;
use App\News;
use App\Heading;

class SearchController extends Controller
{
    //выдача всех новостей конкретного автора
    public function searchAllNewsOfAuthor(Request $request)
    {
        $data = $request->json()->all();

        $author = Author::getAuthorByAuthorNameAndAuthorSurname($data['author_name'], $data['author_surname'])->get();
        $newses = News::getAllNewsByAuthorId($author[0]->author_id)->get();

        $responseNews = $this->getDataOfNews($newses);
        return response()->json($responseNews);
    }

    //выдача списка всех новостей, которые относятся к указанной рубрике
    public function searchNewsByHeading(Request $request)
    {
        $data = $request->json()->all();

        $heading = Heading::getHeadingByHeadingName($data['heading_name'])->get();

        $news_headings = $heading[0]->newsHeadings;

        $newses = [];
        foreach ($news_headings as $news_heading) {
            $news = $news_heading->news;
            $newses[] = $news;
        }

        $responseNews = $this->getDataOfNews($newses);

        return response()->json($responseNews);
    }

    //выдача списка авторов
    public function searchAllAuthors()
    {
        $authors = Author::all();

        $responseAuthors = [];
        foreach ($authors as $author) {
            $responseAuthors[] = $author->author_surname . ' ' . $author->author_name;
        }

        return response()->json($responseAuthors);
    }


    //выдача информации о статьях по их идентификаторам
    public function searchNewsByNewsId(Request $request)
    {
        $data = $request->json()->all();

        $news = News::find($data['news_id']);

        $responseData = $this->getSingleDataOfNews($news);
        return response()->json($responseData);
    }

    public function getChildrenData($myData)
    {
        $thisData = [];
        $childrenHeadings = $myData['childrenHeadings'];
        foreach ($childrenHeadings as $childrenHeading) {
            $news_headings = $childrenHeading->newsHeadings;

            $newses = [];
            foreach ($news_headings as $news_heading) {
                $news = $news_heading->news;
                $newses[] = $news;
            }

            $thisData['responseX'] = $this->getDataOfNews($newses);

            $childrenChildrenHeadings = Heading::getHeadingByParentHeadingId($childrenHeading->heading_id)->get();

            $responseNewses = [];
            if ($childrenChildrenHeadings == null) {
                $responseNewsChildren = [];
                $anotherData['childrenHeadings'] = $childrenChildrenHeadings;
                $childrenResponseNews = $this->getChildrenData($anotherData);
                $responseNewses = array_merge($responseNewses, $childrenResponseNews['childrenHeadings']);
                $thisData['responseX'] = $responseNewses;
            }

        }

        return $thisData;
    }


    public function recursive($childrenHeadings)
    {

    }

    public function searchNewsByHeadingAndItsChildrenHeadings(Request $request)
    {
        $data = $request->json()->all();

        $heading = Heading::getHeadingByHeadingName($data['heading_name'])->get();

        $news_headings = $heading[0]->newsHeadings;

        $newses = [];
        foreach ($news_headings as $news_heading) {
            $news = $news_heading->news;
            $newses[] = $news;
        }

        $responseNews = $this->getDataOfNews($newses);

        $responseNewses = [];

        $responseNewses = array_merge($responseNewses, $responseNews);

        $childrenHeadings = Heading::getHeadingByParentHeadingId($heading[0]->heading_id)->get();

        $anotherData['childrenHeadings'] = $childrenHeadings;

        if ($anotherData['childrenHeadings'] != null) {
            $childrenResponseNews = $this->getChildrenData($anotherData);
            $responseNewses = array_merge($responseNewses, $childrenResponseNews['childrenHeadings']);
        }

        return response()->json($childrenHeadings);
    }

    public function searchNewsByName(Request $request)
    {
        $data = $request->json()->all();

        $news = News::getNewsByNewsName($data)->get();

        $responseData['news_name'] = $news[0]->news_name;
        $responseData['news_text'] = $news[0]->news_text;
        $author = Author::find($news[0]->author_id);
        $authorFullName = $author->author_surname . ' ' . $author->author_name;
        $responseData['author_full_name'] = $authorFullName;

        $news_headings = $news[0]->newsHeadings;
        $heading_ids = [];
        foreach ($news_headings as $news_heading) {
            $heading_id = $news_heading->heading_id;

            $heading = Heading::find($heading_id);
            $heading_ids[] = $heading->heading_name;

        }

        $responseData['headings'] = $heading_ids;

        return response()->json($responseData);
    }


    public function getDataOfNews($newses)
    {
        $responseNews = [];
        foreach ($newses as $news) {
            $responseData = $this->getSingleDataOfNews($news);
            $responseNews[] = $responseData;
        }

        return $responseNews;
    }

    public function getSingleDataOfNews($news)
    {
        $responseData['news_name'] = $news->news_name;
        $responseData['news_text'] = $news->news_text;
        $author = Author::find($news->author_id);
        $authorFullName = $author->author_surname . ' ' . $author->author_name;
        $responseData['author_full_name'] = $authorFullName;

        $news_headings = $news->newsHeadings;
        $heading_ids = [];
        foreach ($news_headings as $news_heading) {
            $heading_id = $news_heading->heading_id;

            $heading = Heading::find($heading_id);
            $heading_ids[] = $heading->heading_name;

        }
        $responseData['headings'] = $heading_ids;
        return $responseData;
    }
}
