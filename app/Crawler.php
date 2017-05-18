<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Goutte\Client;
use App\User;
use App\course;
use App\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class Crawler extends Model
{
	public $root ;
	public $max_depth = 5;
	public $crawled = array();
	public $to_crawl = array();
	public $domain;

	public function __construct($url,$domain){
		$this->root = $url;
		$this->domain = $domain;
		$this->to_crawl[$url] = 0;

	}

	public function udacityCrawler(){
		$client = new Client();
		$crawler = $client -> request('GET','https://www.udacity.com/public-api/v0/courses');
		$response = $client->getResponse();
		$json = $response->getContent();
		$decoded=json_decode($json,true);
		$courses = $decoded['courses'];
		$admin  = User::find(2);

		foreach($courses as $course){
			
			
			if($course['homepage'] != null && count(course::where('url',$course['homepage'])->get()) == 0){
				$description =$course['summary'];
				$data = [
				'url'=>$course['homepage'],
				'name'=>	$course['title'],
				'title' => $course['subtitle'],
				'description' => preg_replace('/[^A-Za-z0-9\-\s\r\n\.]/', '', substr($description,0,190)),
				'image_url' => $course['image'],
				];
				echo $data['url']."\r\n";
				echo $data['description']."\r\n";
				$tags= $course['tracks'];
				$courseModel = new Course($data);
				$admin->publish($courseModel);
				$courseModel->insertTags($courseModel,$tags);
			}
		}

	}
	public function edxCrawler(){
		$this-> edxCrawl('https://courses.edx.org/api/courses/v1/courses/');
	}
	public function edxCrawl($seed){
		$client = new Client();
		$crawler = $client -> request('GET',$seed);
		$response = $client->getResponse();
		$json = $response->getContent();

		$decoded=json_decode($json,true);
		$next = $decoded['pagination']['next'];
		
		$courses = $decoded['results'];
		$admin  = User::find(2);
		foreach($courses as $course){
			$data = [
			'url'=>$course['homepage'],
			'name'=>	$course['title'],
			'title' => $course['subtitle'],
			'description' => substr($course['summary'],0,189)."..",
			'image_url' => $course['image'],
			];
			$course = new Course($data);
			$admin->publish($course);
		}
		
		if($next != null){
			edxCrawl($next);
		}
	}

	public function crawl(){
		$depth = end($this->to_crawl);
		$url = key($this->to_crawl);
		unset($this->to_crawl[$url]);
		if($url == null  ){
			return;
		}
		echo "Crawling ".$url." at depth ".$depth."\r\n";
		$this->getUrls($url,$depth+1);
		$this->crawled[$url] = $depth;
		$this->crawl();
	}


	private function getUrls($url,$depth){
		$client = new Client();
		$crawler = $client -> request('GET',$url);

		$courses_urls = $crawler->filter($this->getUrlCssSelector($this->domain))->each(function ($node) {
			$text = $node->attr('href');
			$url = $text;
			$pos = strpos($url,"?");
			if($pos == false){
				return $url;
			}
			return substr($url,0,$pos);

		});

		$this->storeCourses($client,$courses_urls);

		$to_crawl_urls = $crawler->filter('a')->each(function ($node) {
			$text = $node->attr('href');
			$url = $text;
			if(strpos($url,$this->domain) == false){
				return null; 
			}
			
			return $url;
		});

		if($depth < $this->max_depth){
			foreach($to_crawl_urls as $url){
				if($url != null && !array_key_exists($url,$this->crawled)){
					$this->to_crawl[$url]=$depth;
				}
			}
			foreach($courses_urls as $url){
				$url = "https://www.".$this->domain.$url;
				if(!array_key_exists($url,$this->crawled)){
					$this->to_crawl[$url]=$depth;
				}
			}
		}




	}
	public function storeCourses($client,$urls){
		$admin  = User::find(2);
		
		for ($i = 0; $i < count($urls); ++$i) {
			echo "Checking url : "."https://www.".$this->domain.$urls[$i]."\r\n";
			if( $urls[$i] != null && count(course::where('url',"https://www.".$this->domain.$urls[$i])->get()) == 0 ){
				echo "Storing :".$urls[$i]."\r\n";
				$metaCrawler = $client -> request('GET',"https://www.".$this->domain.$urls[$i]);

				$data = $this->getMetaData($metaCrawler,$urls[$i]);

				if($data['name'] != null){
					$course =new Course($data);
					$admin->publish($course);
					echo "https://www.".$this->domain.$urls[$i]."\r\n";	
				}

			//$course->insertTags($course,$tags);
				
			}

		}
	}

	public function getUrlCssSelector($domain){
		if ($domain == "coursera.org"){
			return 'a[href^="/learn"]';
		}
		if($domain == "edx.org"){
			return '.course-link';

		}
		if ($domain == "ocw.mit.edu"){
			return 'a[href^="/courses/"] ';
		}
		if ($domain == "udacity.com"){
			return 'a[href^="/course"]';
		}
	}
	public function gettAttribute($domain){
		if ($domain == "coursera.org"){
			return 'href';
		}
		if ($domain == "edx.org"){
			return 'href';
		}
	}
	
	public function getMetaData($metaCrawler,$url){
		try {
			$title = $metaCrawler->filter('meta[property="og:title"]')->attr('content');
		} catch (\InvalidArgumentException $e) {
			$title = null;
		}
		try {
			$image_url = $metaCrawler->filter('meta[property="og:image"]')->attr('content');
		} catch (\InvalidArgumentException $e) {
			$image_url = null;
		}
		try {
			$description = substr($metaCrawler->filter('meta[property="og:description"]')->attr('content'),0,189)."..";
		} catch (\InvalidArgumentException $e) {
			$description = null;
		}
		$data = [
		'url'=>"https://www.".$this->domain.$url,
		'name'=>	$title,
		'title' => $title,
		'description' => $description,
		'image_url' => $image_url,
		];
		return $data;
	}
}
