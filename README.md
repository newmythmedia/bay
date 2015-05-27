# myth:Bay

[![Build Status](https://travis-ci.org/newmythmedia/bay.svg)](https://travis-ci.org/newmythmedia/bay)

The Bay component provides a simple way to include re-usable content in any `view` or rendered HTML, while keeping the logic in a separate class or module. This makes it simple to implement re-usable "widgets" in your applications, though that term is, perhaps, too grand. 

A common example could be the "Recent Posts" section of a blog - the actual content is derived from the Blog module in a larger application, and appears in a number of places across your application, but you can easily insert it where you want it within the view  layer, instead of loading it in every controller and sending it to the view. 

## Installation
Installation is handled through [Composer](https://getcomposer.org/) as [myth/bay](#).

