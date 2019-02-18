<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class newsController extends Controller
{

    protected $baseUrl = 'https://newsapi.org/v2/everything';
    protected $pageSize = 20;
    protected $apiKey = '66d3353cb64c4263a38f8cad4877f28f';

    public function topicSearch(Request $request) {
        $topic = '';
        $page = 1;
        $pageCount = 0;
        $posts = array();
        if($request->get('topic') && $request->get('topic') != '') {
            $topic = $request->get('topic');
            if($request->get('page') && $request->get('page') != '') {
                $page = $request->get('page');
            }
            $posts = $this->getTopicSearch($topic,$page);
            if($posts['totalResults'] > 0) {
                $pageCount = round($posts['totalResults'] / 20);
            }
        }
        return view('topicSearch')->with('topic',$topic)
                                        ->with('posts',$posts)
                                        ->with('page',$page)
                                        ->with('pageCount',$pageCount);
    }

    public function dateSearch(Request $request) {
        $fromDate = date('Y-m-d');
        $toDate = date('Y-m-d');
        $domain = '';
        $page = 1;
        $pageCount = 0;
        $posts = array();
        if($request->get('search') && $request->get('search') != '') {
            if($request->get('domain') && $request->get('domain') != '') {
                $domain = $request->get('domain');
            }
            if($request->get('fromDate') && $request->get('fromDate') != '') {
                $fromDate = $request->get('fromDate');
            }
            if($request->get('toDate') && $request->get('toDate') != '') {
                $toDate = $request->get('toDate');
            }
            if($request->get('page') && $request->get('page') != '') {
                $page = $request->get('page');
            }
            $posts = $this->getDateSearch($domain, $fromDate, $toDate, $page);
            if($posts['totalResults'] > 0) {
                $pageCount = round($posts['totalResults'] / 20);
            }
        }
        return view('dateSearch')->with('fromDate',$fromDate)
                                        ->with('toDate',$toDate)
                                        ->with('domain',$domain)
                                        ->with('posts',$posts)
                                        ->with('page',$page)
                                        ->with('pageCount',$pageCount);
    }

    protected function getTopicSearch($topic, $page) {
        $data = array(
            "q" => $topic,
            "pageSize" => $this->pageSize,
            "page" => $page,
            "apiKey" => $this->apiKey
        );
        $query_url = sprintf("%s?%s", $this->baseUrl, http_build_query($data));

        $posts = collect($this->getJson($query_url));
        return $posts;
    }

    protected function getDateSearch($source, $fromDate, $toDate, $page) {
        $data = array(
            "sources" => $source,
            "from" => $fromDate,
            "to" => $toDate,
            "pageSize" => $this->pageSize,
            "page" => $page,
            "apiKey" => $this->apiKey
        );
        $query_url = sprintf("%s?%s", $this->baseUrl, http_build_query($data));

        $posts = collect($this->getJson($query_url));
        return $posts;
    }


    protected function getJson($query_url)
    {
        header('Content-type: application/json');
        $response = file_get_contents($query_url);
        //$response = file_get_contents("https://newsapi.org/v2/everything?q=Donald Trump&pageSize=20&page=1&apiKey=66d3353cb64c4263a38f8cad4877f28f", false);
        return json_decode( $response , true);
    }

}
