# myth:Bay

[![Build Status](https://travis-ci.org/newmythmedia/bay.svg)](https://travis-ci.org/newmythmedia/bay)

The Bay component provides a simple way to include re-usable content in any `view` or rendered HTML, while keeping the logic in a separate class or module. This makes it simple to implement re-usable "widgets" in your applications, though that term is, perhaps, too grand. 

A common example could be the "Recent Posts" section of a blog - the actual content is derived from the Blog module in a larger application, and appears in a number of places across your application, but you can easily insert it where you want it within the view  layer, instead of loading it in every controller and sending it to the view. 

**NOTE: This library is under initial development. While simple functionality is here, there are a few things left to be implemented, like Caching and a way to locate libraries to use in a framework-agnostic way.**

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
	




