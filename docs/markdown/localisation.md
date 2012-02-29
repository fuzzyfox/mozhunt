# Localisation
To help ensure mozhunt can read a large audience around the world it should be easily localisable and as such it makes use of some of the build in tools within CodeIgniter as well as some custom methods for large blocks of text such as legal documents etc…

## Language files
mozhunt sticks all short strings, such as error messages, page titles, and continually reused strings in a collection of files all stored within `application/language/{locale}/` where `{locale}` is replaced by the locale identifier (e.g. **en**, **es**, **fr**, etc…).

Currently mozhunt is only available in English. However the same filenames will be used repeatedly for the other locales. These files are:

* `theme_lang.php`	- this contains all the strings used for text that is a core part of the theme of the site.
* `views_lang.php`	- this contains all the page titles and strings relating to a theme that the controller passes the view.
* `errors_lang.php`	- this file contains all the strings displayed to the users when errors are encountered.

For large blocks of text that include links, multiple headings, etc… it is not feasible to use the built in tool provided by CodeIgniter as it is not suited to the task. Instead mozhunt uses a custom setting added to the CodeIgniter `config.php` file. This adds a configuration that sets the locale mozhunt is to use.