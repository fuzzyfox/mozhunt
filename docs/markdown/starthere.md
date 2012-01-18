# Welcome to mozhunt
mozhunt was originally a community developed, community run, treasure hunt on the web for the mozilla community. It was a big success and now it is finally time to dust it off and recreate it.

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

## Basic idea
There are two parts to the game... first of all there are those hiding tokens. The idea is that this is a quick and simple a process as possible. All the hider need do is paste one or two lines of code onto their site and instantly their token is hidden. They can also add a cryptic clue as to what their site is and where on the site their token is hidden.

For the players this is a little different, they visit as many sites as possible (originally around the mozilla community) to find these tokens.

Now you should not need a separate account to hide and find tokens. **However** those hiding tokens may not add the one they have hidden to their site.

### The players
Players should have the easiest gameplay experience possible, with as many useful and interesting features we can provide without taking away from the simplicity of the idea.

A play will need to have an account with mozhunt and be logged in to play. However they need not visit the site once they start unless they wish to view their rank in the player leader board, or change some settings.

When finding a token players should be able to simply click the token to mark it as found and then continue looking at the site the token was hidden on.

## The hiders
These people are ordinary players for the most part however they have decided to also hide a token. This therefore means that their own token is automatically marked as found for them, and so they cannot add it to their score.

To hide a token the will need to provide the root domain (and if needed route) that the token will be hidden on. This allows for them to hide it in either a blog post, OR a repeatedly displayed part of their site, such as the header and/or footer.

To add a token to their site, we (mozhunt) will provide the hider with an api key, and a couple of lines of code to add to their site, with the api key already configured so the code is as simple as copy-paste.

## The token
One item that has been mentioned but not discussed is the token. This is essentially just a record in our (mozhunt's) database, and a few lines of code on a website. These lines of code however include:

* A small javascript snippet to AJAJ-ify the token finding process and provide a more seamless experience for the players
* A hyperlink fallback should javascript be disabled or fail
* And an image, this is the token from the players perspective and is what should be clicked to start the finding process