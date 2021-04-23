## A PHP/JS web scraper for 10web's blog
Simple web application that scrapes and aggregates 10Web’s latest blog posts and shows them on the front page. Must be changed to CLI app


Some of the feature include:
* Dependencies managed through composer
* Options for date range and article limit
### Dependencies
- PHP >= 7.1
- PHP web server

#### How to quickly setup
* Ensure you have [composer](www.getcomposer.org) installed 

    * You can use composer (recommended) to create the project using `composer create-project smweb/web-scrapper:dev-master myproject`   (rename {myproject} to any)
    * or download the project in zip format [here](https://github.com/smwebstudio/web-scrap/archive/refs/heads/master.zip) and extract it to your http server.                                                          	
* In the root folder, run composer install
* In the app/ folder, edit db_config.php for proper DB credentials
* After dependencies are installed, run `php -S localhost:800` to start a server at the root folder.
* To scrap posts run command `php app/scraper_cli.php --count "{count}" --startDate "{startDate}" --endDate "{endDate}" ` , where
    * {count} is articles count to scrap, integer
    * {startDate} is article's published min date
    * {endDate} is article's published max date
    * Date format: mm/dd/yyyy (example: 04/23/2021 )



### Versioning
Project uses [GitHub](https://github.com/) for versioning.

