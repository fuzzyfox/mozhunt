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

# Getting Started
## Development environment
So there is of course a difference between the development environment and the production site, however we need to make this difference as small as possible. So this section provides information on how to setup your development environment so as to reflect that of the production server.

### System requirements
* Git + GitHub account
* Backend Development Only
	* MySQL
	* PHP
	* Apache
* Frontend Development Only
	* Mozilla Aurora (Firefox v. 11 minimum)
	* Chrome Beta
	* Internet Explorer 8, 9, or 10 beta (if it is due/likely to release before Easter)

Why so many different browsers for frontend development? Well even though the main target is the Mozilla Community, not all of those in the community use Mozilla Firefox… and we want to be able to allow those who may not be part of the Mozilla Community to join in too!

So why are we using the development versions of the browsers? Well we want to promote the open web, and web standards so that is done by developing the application in accordance with those. However we also want to promote good practice for internet users which is to ensure they have the latest version of their browser possible. This means using development versions of some browsers as these development versions will be release versions come our launch date.

### Untracked files
For security, and common sense reasons, some files are not tracked on the git repository… these files consist of those that are either created by the operating system in order to manage directories and other things, as well as those that contain any sensitive information such as database passwords, encryption keys, or anything that falls under the protection of the *Data Protection Act*.

In some instances these files are essential for the operation of the application. So to counteract this problem, should any file be untracked but needed for the application to run, a sample version should be created which should be named in the following manner:
	{filename}.sample.{extension}
This indicates that the file should be copied and the `.sample` part be removed. 

Sample files **MUST NOT** contain sensitive information. This information should be replaced by a few words that describe what should be there OR it should be self explanatory what should be entered. If neither applies then ensure a comment is added nearby in the code that explains what information should be entered and where.

## Development process
### Repository management
When working on a specific feature (i.e. user signup), you should, where possible, create a new branch for that feature, and then merge it once it is complete.

The **master** branch should only be used for certain milestones, and releases. There will therefore be a **development** branch which features should be merged into. This will allow easy staging, as well as a clear development process for future releases and enhancements.

#### Additional Features
There may be separate features that are not part of the core application such as a JetPack (restartless add-on) for Firefox, or a WordPress Plugin for hiders. These features should also be developed on separate branches, however do not need to follow the same management process as the core. It will be up to the branch owners how to manage those features and should add that information to this file below.

### Milestones
Each milestone is to be achieved before the next is started, as it would be so when walking in the countryside. 

A milestone represents a major improvement or completion of the core application. This would be events like:

* A large feature is completed that provides the one of most essential elements of the application
* Major changes have been made to the application that need to be distributed to anyone else using it beside mozhunt.
* Critical, or a collection of minor, bug fixes. These, though not necessarily milestones in the strictest sense are important to be on the **master** branch.

### Issue tracking
This will primarily be done using GitHub's build in issue tracker. This means that there are less different tools to learn, and in less locations. Issues should be tagged based on feature and severity (Critical, Minor, Request).

Issues should be as descriptive as possible and should where appropriate include the following information:

* Version of the application (or commit reference) when issue is created
* For fronted issues which browser they occur in
* A short description of the issue and steps to reproduce
* If problem code is known but not in current development this should be included
* Suggestions on how to fix

#### Example:
	v. 0.0.1
	browser: Internet Explorer 6
	
	all the ajaj does not work and the site looks funky. 	All the images have grey backgrounds and forms are 	hideously Windows 98.
	
	Steps:
	1. visit the site using IE 6
	
	Fix:
	none… who would be stupid enough now to support IE6?!

## Coding style
Coding style is something that varies from developer to developer, so this is just a guide on appreciated practices and some requirements for comments/documentation.

### Indentation and code blocks
Be consistent if nothing else, however it is preferred if you don't do this:
	
	if($x == 1){$y = 2;}
	
but instead do this:
	
	if($x == 1)
	{
		$y = 2;
	}
	
or this:
	
	if($x == 1) {
		$y = 2;
	}
	
### Shorthand and complex bits
When doing something shorthand or complex that is not easy to understand add a simple comment before hand to explain what it is you are doing. For example this oversimplified example:
	
	// assigning the string 'true' or 'false' based on
	// condition
	$string = ($boolean)? 'true' : 'false';
	
### Quotes
As much as possible follow these conventions.

#### PHP
Single quotes unless reading variables inline. i.e. `"this is a $varType"` and `'this is a string'`

#### HTML & JavaScript
Single quotes for JavaScript, and double quotes for HTML attributes. This makes writing any HTML in JavaScript 1000 times easier. i.e. `var html = '<a href="/">home</a>';`

### Input, forms, sessions, and database connections
Please ONLY use the CodeIgniter provided libraries and helpers for dealing with input, sessions and the database. Use the form helper from CodeIgniter at all times when opening forms so as to ensure that we have CSRF protection fully enabled. 

### Comments
Please ensure that you comment your code thoroughly so as to ensure easy pickup for others. Please also use **phpdoc** style comments at the beginning of all files, classes, and functions. Also ensure to add yourself as the author of each function and class you create, and should you work on a piece of code created by someone else add yourself as a contributor. This will help with issue fixing and who deserves praise for what.

**Note:** This applies in a similar fashion to **CSS** and **JavaScript**, not so much for **HTML**.

### File endings
You should include a small comment to point out that it is the end of the file and where the file is/should be located. e.g.
	
	/* End of file welcome.php */
	/* Location: ./application/controllers/welcome.php */
	
This will help provide an easy way to identify files if you multiple files with the same name open in your code editor (some do not show the file path in the title, just the name).

#### PHP
Don't use the PHP close tag. Reasoning for this can be found with a simple Google search, but in short it improves performance and recedes file size a little.

## Where to begin
You should start be finishing reading these doc's you are currently reading now, then move on to familiarising yourself with CodeIgniter and jQuery if you are not already so. Then… talk to the others working on the code, and decide with them what you will each be working on.