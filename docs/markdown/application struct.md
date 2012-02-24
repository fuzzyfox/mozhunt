---
Contents

* Basic idea - `starthere.md`
	* The players
	* The hiders
	* The token
* Getting started - `getting started.md`
	* Development environment
	* Development process
	* Coding style
	* Where to begin
* Data flow - `data flow.md`
	* Player
	* Hider
	* Token
* System flows - `system flows.md`
	* Player creation
	* Token creation
	* Token finding
* Application structure - `application struct.md`
	* Directory structure explained
	* URI structure
	* Controllers
	* Methods
	* API
* Site map - `sitemap.md`

---

# Application structure
## Directory structure explained
As you may be aware there is a fairly specific structure to the directory mozhunt is developed in. This helps make life not only easier for developers, but also more organised.

So where to begin? Well… like this maybe?

* **/** - this is mozhunt there is nothing directly in here other than a few licenses, other essential directories, the `.htaccess`, `index.php`, `index.html`, `robots.txt`, `humans.txt`, `crossdomain.xml`, `README.md`, and `favicon.ico` files.
	* **/application** - this is the core components of mozhunt. It contains all the model, view, and controller code, as well as configuration files. This is where all the PHP is hidden away, as well as a little HTML in some of the views. *For a more in-depth look into this directory see the CodeIgniter user guide.
	* **/asset** - contains all the publicly available/viewable assets used to create mozhunt.
		* **/css** - all CSS files used to for the site.
		* **/font** - all the web fonts used.
		* **/img** - all the images (including tokens).
		* **/js** - all the JavaScript.
	* **/docs** - this contains all the high level documentation for mozhunt.
		* **/markdown** - this is the documentation in its raw form, no styling or images.
		* **/html** - this is the exact same documentation after it has been run through a converter to add styling and images.
	* **/jetpack** - specific to the mozhunt restartless add-on for Firefox, please see its own individual documentation for more details.
	* **/wordpress** - specific to the wordpress plugin for token implementation on wordpress sites, please see its own individual documentation for more details.
	* **/system** - this is CodeIgniter's core, as well as all the libraries and helpers that come with it initially.
	* **/test** - this is a directory for writing test cases into as well as for any little quick snippets or experiments that do not require the CodeIgniter framework.

## URI structure
* **/** - static page controller, homepage
* **/about/** - static page controller, about landing page
* **/about/history/** - static page controller, mozhunt history
* **/about/howto/** - static page controller, how to play mozhunt
* **/about/rules/** - static page controller, the games rules
* **/user/** - user controller, all things to do with user management
* **/tokens/** - token controller, all things to do with token management
* **/api/** - api controller, see **api** section below for more
* **/legal/** - static page controller, legal landing page
* **/legal/tos/** - static page controller, terms of service
* **/legal/privacy/** - static page controller, privacy policy
* **/legal/disclaimers/** - static page controller, disclaimers
* **/contact/** - static page controller, contact landing page

## Controllers
* **static_content** - static pages are pulled into the site template using this controller
* **user** - deals with everything to do with user management and user dashboards
* **token** - controls token creation and management
* **api** - deals with all api interaction

## Methods
**Removed.**

## API
**Has been moved to** `api.md`.