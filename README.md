# myth:Bay

[![Build Status](https://travis-ci.org/newmythmedia/bay.svg)](https://travis-ci.org/newmythmedia/bay)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/newmythmedia/bay/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/newmythmedia/bay/?branch=develop)

The Bay component provides a simple, framework-agnostic, way to include re-usable content in any `view` or rendered HTML, while keeping the logic in a separate class or module. This makes it simple to implement re-usable "widgets" in your applications, though that term is, perhaps, too grand. 

A common example could be the "Recent Posts" section of a blog - the actual content is derived from the Blog module in a larger application, and appears in a number of places across your application, but you can easily insert it where you want it within the view  layer, instead of loading it in every controller and sending it to the view. 

## Installation
Installation is handled through [Composer](https://getcomposer.org/) as [myth/bay](#).

## General Usage

Bays have only one real requirement: You must have a class that is either already loaded, or can be autoloaded, with a function that returns a string. There are a couple of finer points to consider, but that is the basics that are needed. 

**For these examples, we will assume that we are creating a blog system, and the we want to show the recent posts as a Bay.**

To instantiate our Bay system, we simply create a new instance of `Myth\Bay\Bay`.

	$bay = new Myth\Bay\Bay();
	
Then you just need to ensure that object is available within your view layer. For CodeIgniter, you would need to pass it as a variable to the `view()` command. 

### Calling Without Parameters

The simplest usage is to simply call a single method that doesn't need any parameters at all. This is done with the `display()` method.

First, though, we need a class and method that we can call. For our purpses, we assume that it can be autoloaded just fine.

	class Posts {
		public function recentPosts() 
		{ 
			$posts = $this->postModel->findLatest(5);
			return $this->view('recentPosts', ['posts' => $posts] );
		}
	}

	// In your view layer...
	$bay->display("\Blog\Posts::recentPosts");

This will attempt to autoload and create an instance of the `\Blog\Posts` class, and call the `recentPosts` function. The `recentPosts` function grabs the latest 5 posts from the database, then renders out a view that formats it properly, returning the rendered HTML to the Bay.

### Calling With Parameters

Parameters in Bays are handled as  a string, and contain one or more key/value pairs. This string is then parsed into an array of key/value pairs, which is passed to the target class' method. This provides a simple way to simulate named parameters so that you can provide the parameters in any way that you want. 

	class Posts {
		public function recentPosts( array $params=[] ) 
		{ 
			$limit = ! empty($params['limit']) ? $params['limit'] : 5;
			$offset = ! empty($params['offset']) ? $params['offset'] : 0;
		
			$posts = $this->postModel->findLatest( $limit, $offset );
			return $this->view('recentPosts', ['posts' => $posts] );
		}
	}

	// In your view layer...
	$bay->display("\Blog\Posts::recentPosts", "limit=5 offset=0");

The parameters can be separated by either spaces (as shown) or by commas, depending on your preferences.  Alternatively, you can pass an array of key/value pairs as the second parameter and it will be used untouched.

	$bay->display("\Blog\Posts::recentPosts", ['limit' => 5, 'offset' => 0] );
	

## Custom Loaders

Bay supports the use of custom loaders in case you need to implement one specifically for your framework. These are simple classes that are only resonsible for locating and loading the class into memory. It must implement the `Myth\Bay\LibraryFinderInterface` which only has a single method: `find( $class )`. 

One has been provided for [CodeIgniter 3](http://codeigniter.com) that can be used as an example if needed. 

To use a custom loader you would pass an instance in as the first parameter when instantiating the Bay class.

	$bay = new Myth\Bay\Bay( new Myth\Bay\CI3Finder() );

Once loaded, this class will be used to locate a class when any other autoloading fails to locate it.


## Caching Results

Bays support caching the rendered output so that you never have to hit the original class (or even autoload it) for better performance in many cases. You tell it you want it to be cached by providing a little bit of extra information in the `display()` call. 

The third (optional) parameter to the `display` method is the name the cache should be stored as. If this is not provided, one will be built for you based on the class name, the method name, and an md5 hash of the params array. The fourth parameter is the number of **minutes** the cache should be stored for.

	$bay->display("\Blog\Posts::recentPosts", "limit=5 offset=0", 'some-cache-key', 15);

This example would cache the results under the key `some-cache-key` and store it for 15 minutes. After the 15 minutes is up, the cache would be built again, automatically. The default TTL time is 0 minutes. Be sure to check this behavior with your cach engine of choice. 

### Providing A Cache Engine
In order for Bays to work in a framework-agnostic manner, we require a framework-integration library for the cache, much like what is used for the custom class loader, above. These classes must extend `Myth\Bay\CacheInterface` and must implement two methods: `get($key)` and `set($key, $content, $ttl)`. A CodeIgniter 3 integration has been provided.

This integration class must be provided during class construction as the second parameter.

	$bay = new Myth\Bay\Bay( null, new Myth\Bay\CI3Cache() );


