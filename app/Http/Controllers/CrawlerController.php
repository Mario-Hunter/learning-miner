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

	public function crawl($query){
		$websites = [
		"https://www.coursera.org/courses?query=",

		//"https://www.edx.org/course?search_query="

		"https://search.mit.edu/search?site=ocw&client=mit&getfields=*&output=xml_no_dtd&proxystylesheet=https%3A%2F%2Focw.mit.edu%2Fsearch%2Fgoogle-ocw.xsl&requiredfields=WT%252Ecg_s%3ACourse+Home%7CWT%252Ecg_s%3AResource+Home&sectionlimit=WT%252Ecg_s%3ACourse+Home%7CWT%252Ecg_s%3AResource+Home&as_dt=i&oe=utf-8&departmentName=web&filter=0&courseName=&q="
		];
		$domains = [
		"coursera.org",
		//"edx.org"
		"ocw.mit.edu"
		];
		for($i=0;$i<count($websites);$i++){
			$this->getCourses($websites[$i].$query,$query,$domains[$i]);
		}


	}


	public function getCourses($url,$query,$domain){
		$client = new Client();
		$crawler = $client -> request('GET',$url);

		$urls = $crawler->filter($this->getUrlCssSelector($domain))->each(function ($node) {
			$text = $node->attr('href');
			$url = $text;
			return $url;
		});
		
		$titles = $crawler->filter($this->getTitleCssSelector($domain))->each(function ($node) {

			return $node->text();
		});


		$user = auth()->user();

		for ($i = 0; $i < count($urls); ++$i) {
			$data = [
			'url'=>"https://www.".$domain.$urls[$i],
			'name'=>$titles[$i]
			];
			$admin  = User::find(3);
			Auth::login($admin);
			$course =new Course($data);
			auth()->user()->publish($course);
			$tags=explode(' ',$query);
			$course->insertTags($course,$tags);
			echo "https://www.".$domain.$urls[$i].'<br>';
			echo $titles[$i].'<br>';

		}
		if ($user){
			Auth::login($user);
		}
	}
	public function getUrlCssSelector($domain){
		if ($domain == "coursera.org"){
			return 'a[data-click-key^="catalog.search.click.offering_card"]';
		}
		if($domain == "edx.org"){
			return '.course-link';

		}
		if ($domain == "ocw.mit.edu"){
			return 'div[class^="results_search"]  p > a';
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
	public function getTitleCssSelector($domain){
		if ($domain == "coursera.org"){
			return 'h2[class^="color-primary-text headline-1-text flex-1"]';
		}
		if ($domain == "edx.org"){
			return '.title-heading';
		}
		if ($domain == "ocw.mit.edu"){
			return 'div[class^="results_search"]  p > a';
		}
		
	}
}
