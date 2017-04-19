<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use App\User;
use App\course;
use App\Tag;
use Illuminate\Support\Facades\Auth;

class CrawlerController extends Controller
{
	var $client;
	
	public function __construct(){
		$client = new Client();
	}


	public function crawl(){
		$query = 'python';
		$client = new Client();
		$crawler = $client -> request('GET','https://www.coursera.org/courses?query=python');
		$result = "crawled" ;
		$urls = $crawler->filter('a[data-click-key^="catalog.search.click.offering_card"]')->each(function ($node) {
			$text = $node->attr('href');
			$url = "https://www.coursera.org".$text;
			return $url."<br>";
		});
		
		$titles = $crawler->filter('h2[class^="color-primary-text headline-1-text flex-1"]')->each(function ($node) {
			return $node->text()."<br>";
		});
		$user = auth()->user();
		for ($i = 0; $i < count($urls); ++$i) {
			$data = [
			'url'=>$urls[$i],
			'name'=>$titles[$i]
			];
			$admin  = User::find(3);
			Auth::login($admin);
			$course =new Course($data);
			auth()->user()->publish($course);
			$tags=explode(' ',$query);
			$course->insertTags($course,$tags);
			echo $urls[$i];
			echo $titles[$i];

		}
		Auth::login($user);
	}

	
}
