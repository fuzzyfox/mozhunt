# API
## Capabilities
* Check if a user is logged in.
* Verify that a token is valid
* Determine if a user has found a token before
* Add a token to a user collection
* Add new domain to the system
* Add new token to a domain

### Response Formats
* JSON
* XML

## Routes

> From this point on all documentation is an example and needs to be discussed in detail to specify routes, parameters, responses, etc… -- William Duyck (FuzzyFox)

All routes are to be prepended with `/api`.

### GET
* `/user` - this will contain all api calls relating to users
	* `/check` - this will check if a user is logged in or not.
* `/token` - this will contain all token related calls
	* `/valid` - checks if a token is valid or not, as well as determines the type of token and its status in regard to the current user (e.g. found/not found).
	* `/add` - this will be used to add a token to the database
	* `/collect` - adds a token to the currently logged in users collection
* `/clue` - this will contain all clue related calls
	* `/all` - this will respond with a list of all currently provided clues
	* `/current` - this will respond with only the most recently provided clue

#### /user/check
##### Resource URL
	http://www.mozhunt.com/api/user/check.format

##### Parameters
`type` (required)  - This is the type of check to perform, for now the only allowed check is `passive` which will simply respond with a yes/no based on if the current user is logged in or not.

##### Example responses
`http://www.mozhunt.com/api/user/check.json?type=passive`

	{
		logged_in : true
	}

#### /token/valid
##### Resource URL
	http://www.mozhunt.com/api/token/valid.format

##### Parameters
`apiKey` (required) - This is the apiKey for the domain the token is hosted on.

`tokenID` (required) - This is the id of the token to check the validity of.

##### Example responses
`http://www.mozhunt.com/api/token/valid.json`

	{
		valid : true,
		accepted_domain : 'http://www.wduyck.com/'
	}