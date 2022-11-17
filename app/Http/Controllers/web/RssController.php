<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Story;
use App\Models\Chapter;
use App\Models\Category;
use Carbon\Carbon;

class RssController extends Controller
{
    public function index()
    {
        $data['categories'] = Category::all();
        return view('web.rss.index', $data);
    }

    function home()
    {
        $posts = Story::where(['status' => 1, ['updated_at', '<=', Story::raw('NOW()')]])->orderBy('updated_at', 'DESC')->limit(6)->get();
        // dd($posts);
        $rss = '<?xml version="1.0" encoding="utf-8" ?>';
$rss .= '<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/"
    xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:atom="http://www.w3.org/2005/Atom" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
    xmlns:slash="http://purl.org/rss/1.0/modules/slash/">';
    $rss .= '<channel>';
        $rss .= '<title>' . env('SITE_NAME') . '</title>';
        $rss .= '<copyright>' . env('SITE_NAME') . '</copyright>';
        $rss .= '
        <link>' . url('/') . '</link>';
        $rss .= '<description></description>';
        $rss .= '<language>vi-vn</language>';
        $rss .= '<pubDate>' . date("D, d M Y H:i:s O") . '</pubDate>';
        $rss .= '<lastBuildDate>' . date("D, d M Y H:i:s O") . '</lastBuildDate>';
        $rss .= '<docs>' . url('rss-feed') . '</docs>';
        $rss .= '<managingEditor></managingEditor>';
        $rss .= '<webMaster></webMaster>';
        $rss .= '<ttl>5</ttl>';
        $rss .= '<image>';
            $rss .= '<url>' . env('SITE_LOGO') . '</url>';
            $rss .= '<title>' . env('SITE_NAME') . '</title>';
            $rss .= '
            <link>' . url('/') . '</link>';
            $rss .= '
        </image>';
        $rss .= '
        <atom:link href="' . url('/rss/home.rss') . '" rel="self" type="application/rss+xml" />';
        // $post = $posts[0];
        foreach ($posts as $post) {
        // var_dump($post->description);
        $rss .= '<item>';
            $rss .= '<title>
                <![CDATA[ ' . $post->title . ' ]]>
            </title>';
            $rss .= '<description>
                <![CDATA[ <a href="' . getUrlPost($post) . '"><img width="180px" border="0" src="' . getThumbnail($post->thumbnail) . '" align="left" hspace="5" /></a><div>' . html_entity_decode($this->xmlsafe($post->description), ENT_QUOTES, 'UTF-8') . '</div> ]]>
            </description>';
            $rss .= '<content:encoded>
                <![CDATA[ ' . html_entity_decode(content_rss_replace($post->content), ENT_QUOTES, 'UTF-8') . ' ]]>
            </content:encoded>';
            $rss .= '
            <link>' . getUrlPost($post) . '</link>';
            $rss .= '<pubDate>' . date("D, d M Y H:i:s O", strtotime($post->updated_at)) . '</pubDate>';
            $rss .= '<guid>' . getUrlPost($post) . '</guid>';
            $rss .= '
            <atom:link href="' . url('/rss/home.rss') . '" rel="self" type="application/rss+xml" />';
            $rss .= '
        </item>';
        }
        $rss .= '
    </channel>';
    $rss .= '</rss>';
// die();
header("Content-Type: text/xml; charset=utf-8");
echo $rss;
}

private function xmlsafe($s)
{
return preg_replace(
'/[\x00-\x08\x0B\x0C\x0E-\x1F]|\xED[\xA0-\xBF].|\xEF\xBF[\xBE\xBF]/',
"\xEF\xBF\xBD",
$s
);
}

public function detail($slug)
{
$category = Category::where('slug', $slug)->first();
if ($slug != 'home') {
$params = [
'category_id' => $category->id,
'limit' => 50,
];


$now = Carbon::now();

$posts = Story::getPosts($params);

$rss = '
<?xml version="1.0" encoding="utf-8" ?>';
$rss .= '<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/"
    xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:atom="http://www.w3.org/2005/Atom" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
    xmlns:slash="http://purl.org/rss/1.0/modules/slash/">';
    //sitemap category
    $rss .= '<channel>';
        $rss .= '<title>' . $category->title . '</title>';
        $rss .= '<atom:link href="' . url(" rss/" . $category->slug . ".rss") . '" rel="self"
            type="application/rss+xml"
            />';
            $rss .= '
            <link>' . getUrlCate($category) . '</link>';
            $rss .= '<description>' . strip_tags(html_entity_decode($category->description, ENT_QUOTES, 'UTF-8')) .
                '
            </description>';
            $rss .= '<lastBuildDate>' . date("D, d M Y H:i:s O") . '</lastBuildDate>';
            $rss .= '<language>vi-vn</language>';
            $rss .= '<sy:updatePeriod>hourly</sy:updatePeriod>
            <sy:updateFrequency>1</sy:updateFrequency>';
            $rss .= '<image>';
                $rss .= '<url>' . env('SITE_LOGO') . '</url>';
                $rss .= '<title>' . $category->title . '</title>';
                $rss .= '
                <link>' . getUrlCate($category) . '</link>';
                $rss .= '<width>144</width>';
                $rss .= '<height>50</height>';
                $rss .= '
            </image>';
            $rss .= '<pubDate>' . date("D, d M Y H:i:s O") . '</pubDate>';
            $rss .= '<docs>' . url('rss-feed') . '</docs>';
            foreach ($posts as $post) {
            $rss .= '<item>';
                $rss .= '<title>
                    <![CDATA[ ' . $post->title . ' ]]>
                </title>';
                $rss .= '<description>
                    <![CDATA[ <a href="' . getUrlPost($post) . '"><img width="180px" border="0" src="' . getThumbnail($post->thumbnail) . '" align="left" hspace="5" /></a><div>' . html_entity_decode($post->description, ENT_QUOTES, 'UTF-8') . '</div> ]]>
                </description>';
                $rss .= '<content:encoded>
                    <![CDATA[ ' . html_entity_decode(content_rss_replace($post->content), ENT_QUOTES, 'UTF-8') . ' ]]>
                </content:encoded>';
                $rss .= '
                <link>' . getUrlPost($post) . '</link>';
                $rss .= '<pubDate>' . date("D, d M Y H:i:s O", strtotime($post->updated_at)) . '</pubDate>';
                $rss .= '<guid>' . getUrlPost($post) . '</guid>';
                $rss .= '
                <atom:link href="' . getUrlPost($post) . '" rel="self" type="application/rss+xml" />';
                $rss .= '
            </item>';
            }
            $rss .= '</channel>';
    $rss .= '</rss>';
header("Content-Type: text/xml; charset=utf-8");
echo $rss;
} else {
$data['categories'] = Category::all();
return view('web.rss.index', $data);
}
}
}