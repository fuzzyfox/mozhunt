# User management system
## Database structure
	CREATE TABLE IF NOT EXISTS `user` (
	  `userID` int(11) NOT NULL AUTO_INCREMENT,
	  `email` varchar(254) NOT NULL,
	  `password` char(128) NOT NULL COMMENT 'sha512',
	  `nickname` varchar(30) NOT NULL,
	  `userStatus` tinyint(4) DEFAULT '4' NOT NULL,
	  `lastActive` int(4) unsigned NOT NULL,
	  PRIMARY KEY (`userID`),
	  UNIQUE KEY `email` (`email`,`nickname`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

### Reasoning and other notes
#### userID
The `userID` is to be used internally when ever we identify a user for any purpose. This is to reduce the amount of personal information that can be seen, as well as the number of people that can see it.

#### email
The `email` is of course the users contact address and (unless using browserID) need to be verified before they can play the game.

#### password
The `password` is compulsory for all users, including those who join by browserID. In the case of browserID a completely random, 16 character long, alpha-numeric-symbol password will be generated for them and emailed to them. This provides a fallback option should for some reason users not be able to log in with their browserID.

All passwords are to salted with the users `nickname` and then sha512 hashed. This provides a more secure, and difficult to crack hash should the database be compromised and user provide passwords such as "*password123*"

#### nickname
The `nickname` is the publicly displayed identity of the user. This will appear in admin control panels, the game play leader board, etc… This nickname can be a real name or a screen name and may contain all alphanumeric characters and the following symbols `_ - [ ] ( ) " " ' ' |` and of course should they be using a real name the `space` character.

#### userStatus
The `userStatus` is used to identify what role/status the user has. It is a single digit that can show that a user is either an admin, or is pending verification. The full list of roles and status codes can be found below in the **User roles** section.

#### lastActive
The `lastActive` field is to contain the unix timestamp for the last interaction the user had with the game. This will be updated whenever a user visits the site, or finds a token.

This field has been added to the user table so as to allow us an easy way to go through the database and prune out users who are not actually playing the game. We will issue a 48hour notice should a user be noticed to not be active. This will be via email, which will contain a "lifeboat" link that will update their `lastActive` time.

## User roles
### Admin
An admin is a user who has the ability to do anything when it comes to user and token management. It is admins that can revoke tokens and even entire domains, as well as remove user accounts due to a breach of terms of service (which will include the game rules).

### Support
This is a user who has been deemed suitable to help others with technical and game play issues, however does not need to be able to revoke and delete tokens, domains, and users. This is also the same level as should be required for any future issue tracking administration, as well as faq administration.

### Hider
This is someone who is playing the game, but is also hiding one or more tokens on one or more domains. The main reason this role exists is so that we can provide additional information to these users based on how many people (not who they are just the numbers) have found their token, as well as their apiKeys.

A hider can also see all the same information that a standard player can in regard to themselves.

### Player
This is a typical user and only sees the information on what tokens they have found and where, what their account details are and how to change them, etc… They can also see clues as to where tokens they have not yet found are, however these are to be release periodically throughout the game, and should not all be visible to the user by default.

### Pending
This is a user who has signed up to play the game, but has not yet activated their account by means of email verification. This status only applies to users who create an account directly with us, and does not apply to those who sign up using browserID.

### Inactive and notified
This is a user who has been detected as inactive and has been notified as such. We will mark these users with a particular status code and email them a link to remark their account as active. Users who are either Admin OR Support will never be marked as inactive and so it is a simple process to check if an inactive user is also a hider or just a standard user.

## User status codes
* **0** = admin
* **1** = support
* **2** = hider
* **3** = player
* **4** = pending
* **5** = inactive