System Requirements
=====================
* PHP 7.1 (use of nullable return types)
* Composer

How to set up
=============
1. ```git clone git@github.com:ebaioni/movie-recommendation.git```
2. ```cd movie-recommendation```
3. ```composer install```

How to run tests
================
* ```vendor/phpunit/phpunit/phpunit --bootstrap vendor/autoload.php tests```

How to run the script
=====================
* ```php entrypoint.php Comedy 12:00```

Solution Overview
=================
Solution consists of 4 classes:

* MovieRecommendation
* HttpClientWrapper
* ShowFactory
* Show

In order to search for Shows, user has to provide ```genre``` and ```time```. 
* ```genre``` must not be empty
* ```time``` can be expressed in either 24hr format (19:00) or 12hr format (7:00pm) with or without leading 0. Minutes are required, so 7pm isn't accepted.

```MovieRecommendation``` class requires an instance of ```HttpClientWrapper``` to be given at instantion time. ```HttpClientWrapper``` is a wrapper around a HttpClient (in this case ```nategood/httpful```). 
Wrapper is in place to create a layer of abstraction between ```MovieRecommendation``` and the httpClient. ```MovieRecommendation``` shouldn't need to be updated if we want to swap the httpClient behind the scenes in the future. Operation that will be possible by just replacing it inside the wrapper (and making sure the same result set is returned).

Once the http call is made to fetch the show-list, the response is given to ```ShowFactory``` that knows how to build a ```Show``` object. In this way, ```MovieRecommendation``` can be tested easier (no ```new``` statements inside it and another layer of abstraction is added in case of evolutions of the ```Show``` class).

```Show``` class is what is usually referred as "model". It represents a show and exposes getters for its properties and useful method to derive information.

The 30minutes look-ahead time is **NOT** part of the ```MovieRecommendation``` class but is, instead, a responsibility of the caller to decide if and how long of a margin is required. 
This is done intentionally. Let's say, we have 2 different clients asking for the same service but with different look-ahead times. We would be forced to add IF statements based on who is calling the service which is definetely not scalable nor ideal.

Also, date manipulation is done via ```DateTime``` objects which take into consideration timezones. For the purpose of this test, Sydney Timezone is assumed for the input time (which is different from the showing times returned from the endpoint).

Possible Improvements
=====================
Considering the nature of the data fetched from the movie endpoint, response from http call should be cached.

Last Notes
==========
I've decided that a CLI interface was enough, the core functionality is extracted from the entry point anyway. We could easily move the content of ```entrypoint.php``` to a web server route handler or to anything we like.



