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
	public function mysql_clean($string){
		return preg_replace('/[^A-Za-z0-9\-\s\r\n\.]/', '', substr($string,0,190));
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
			
			echo "Checking: ".$course['title']."\r\n";
			if($course['homepage'] != null && count(course::where('url',$course['homepage'])->get()) == 0){
				$description =$course['summary'];
				$data = [
				'url'=>$course['homepage'],
				'name'=>	$course['title'],
				'title' => $course['subtitle'],
				'description' => $this->mysql_clean($description),
				'image_url' => $course['image'],
				];
				echo "Saving: ".$data['name']."\r\n";
				try{
					$tags= $course['tracks'];
					$courseModel = new Course($data);
					$admin->publish($courseModel);
					$courseModel->insertTags($courseModel,$tags);
				}catch(\Illuminate\Database\QueryException $e){
					echo "Couldn't save ".$data['name']."\r\n";
				}
			}
		}

	}
	public function edxCrawler(){
		$client_ID = "OgHU5GM9WDpZBBNl7HsnxWIakF2kUe8tAS1Fxbuy";
		$client_secret ="4nBXEuren8vq2IcE8GNDEm5yN0Dzt18LqnLYQmcRuRqBo1nBhI5M8PFV7neGFLDWKkBRkhKH0hVgZoaJ2LC6FTsJ8Ewj1oHESNFj1Nkw92yJilITlSCDd3tqd3ase2Hc";
		$param = "grant_type=client_credentials&client_id="+$client_ID+"&client_secret="+$client_secret+"&token_type=jwt";
		$param ="grant_type=client_credentials&client_id=OgHU5GM9WDpZBBNl7HsnxWIakF2kUe8tAS1Fxbuy&client_secret=4nBXEuren8vq2IcE8GNDEm5yN0Dzt18LqnLYQmcRuRqBo1nBhI5M8PFV7neGFLDWKkBRkhKH0hVgZoaJ2LC6FTsJ8Ewj1oHESNFj1Nkw92yJilITlSCDd3tqd3ase2Hc&token_type=jwt";
		$client = new Client();
		$crawler = $client -> request('POST',"https://api.edx.org/oauth2/v1/access_token",[],[], ['HTTP_CONTENT_TYPE' => 'application/x-www-form-urlencoded'],$param);
		$response = $client->getResponse();
		$json = $response->getContent();

		$decoded=json_decode($json,true);
		$access_token= $decoded['access_token'];
// 		$client = new Client('https://api.edx.org/catalog/v1/catalogs/', array(
//     'request.options' => array(
//         'headers' => array('Authorization' => "JWT ".$access_token),
//     )
// ));
		$client->setHeader("Authorization", "JWT ".$access_token);
		$this->edxCrawl($client,"https://api.edx.org/catalog/v1/catalogs/129/courses",1);
		 //$client -> request("GET","https://api.edx.org/catalog/v1/catalogs/129/courses");
		 //$response = $client->getResponse();
		 //$json = $response->getContent();
		// echo $json;
		// $decoded=json_decode($json,true);
		// $results =$decoded['results'];
		// echo $decoded['count']."\r\n";
	}

	public function edxCrawl($client,$seed,$page){
		echo "Reading Page ".$page."\r\n";
		$crawler = $client -> request('GET',$seed);
		$response = $client->getResponse();
		$json = $response->getContent();
		$decoded=json_decode($json,true);
		$next = $decoded['next'];
		$courses = $decoded['results'];
		$admin  = User::find(2);
		foreach($courses as $course){
			echo "Checking: ".$course['title']."\r\n";
			if($course['marketing_url'] != null && count(course::where('url',$course['marketing_url'])->get()) == 0){
				$data = [
				'url'=>$course['marketing_url'],
				'name'=>	$course['title'],
				'title' => $course['title'],
				'description' => $this->mysql_clean($course['short_description']),
				'image_url' => $course['image']['src'],
				];
				echo "Saving: ".$data['name']."\r\n";
				$tags = array();
				foreach($course['subjects'] as $subject){
					array_push($tags,$subject['name']);
				}
				try{
					$course = new Course($data);
					$admin->publish($course);
					$course->insertTags($course,$tags);
				}catch(\Illuminate\Database\QueryException $e){
					echo "Couldn't Save ".$data['name']."\r\n";
				}
			}
		}
		
		if($next != null){
			$this->edxCrawl($client,$next,$page+1);
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
				if(array_key_exists($url,$this->crawled)){
					return null;
				}
				return $url;
			}
			if(array_key_exists(substr($url,0,$pos),$this->crawled)){
					return null;
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
				if($url != null && !array_key_exists($url,$this->crawled) && !array_key_exists($url,$this->to_crawl) ){
					$this->to_crawl[$url]=$depth;
				}
			}
			foreach($courses_urls as $url){
				$url = "https://www.".$this->domain.$url;
				if($url != null && !array_key_exists($url,$this->crawled) && !array_key_exists($url,$this->to_crawl)){
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
					echo "Saving: https://www.".$this->domain.$urls[$i]."\r\n";	
					
				if($data['name'] != null){
					try{
					$course =new Course($data);
					$admin->publish($course);
				}catch(\Illuminate\Database\QueryException $e){
					echo "Couldn't Save https://www.".$this->domain.$urls[$i]."\r\n";	
				}
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
