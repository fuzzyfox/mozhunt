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

# Data flow
**Key:**

* **->** represents data from the **entity** in question to **mozhunt**
* **<-** represents data from **mozhunt** to the **entity** in question
* **<->** represents a two way flow of data between both **mozhunt** and the **entity** in question
* **( ! )** represents an important note

## Player
* **->** | nickname - this is the publicly displayed identity of the player.
* **->** | password - obviously this is part of the log in process.
* **->** | email - this is for the mailing list before the game launches and then for log in and contact during, and for a short period after, the game finishes.
* **->** | preferences - this includes preferences on settings like opt-in and opt-out features.
* **->** | found token - this is the api key of any token the player finds.
* **<-** | player score - this can either be on their account page OR on the leader board.
* **<-** | clues - during game play there will be clues given as to the whereabouts of tokens are.

## Hider
* **<->** | see **player**.
* **->** | api key.
* **->** | token - this is the code need for copy-paste implementation.
* **->** | token status - this is the statistical data on how many people have found the token compared to how many could have potentially found it.
* **<-** | token type - there will be a number of options to customise what the token should look like to players.
* **<-** | location of token - this is the top level domain of the site the token is to be hidden on (or including the top route of the site if needed).

## Token
* **->** | api key - this is for verification of authenticity, as well as to identify the token when found.
* **->** | referrer - this again is for verification of authenticity of the token.
* **<-** | status - this is to tell the token to display as found, hidden, or normal based on current gameplay state and user viewing token.
* **<-** | type - this is the type of token to display based on the hiders preference.