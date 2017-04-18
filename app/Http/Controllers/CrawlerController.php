<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;

class CrawlerController extends Controller
{
	var $client;

	public function __construct(){
		$client = new Client();
	}


	public function crawl(){
		$client = new Client();
		$client->getClient()->setDefaultOption('config/curl/'.CURLOPT_SSL_VERIFYHOST, "FALSE");
		$client->getClient()->setDefaultOption('config/curl/'.CURLOPT_SSL_VERIFYPEER, "FALSE");
		$crawler = $client -> request('GET','https://www.coursera.org/');
		$result = "crawled" ;
		$crawler->filter('body > div')->each(function ($node) {
			print  $node->text()."\r\n".PHP_EOL;
		});
		//dd($result);
	}
}
