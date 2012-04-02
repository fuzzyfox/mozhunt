# Status Codes
These are the various status/permission codes used throughout mozhunt. The are used to control a range of different things from user permissions/status, to the status of a token.

## User
### Roles
#### Admin
An admin is a user who has the ability to do anything when it comes to user and token management. It is admins that can revoke tokens and even entire domains, as well as remove user accounts due to a breach of terms of service (which will include the game rules).

#### Support
This is a user who has been deemed suitable to help others with technical and game play issues, however does not need to be able to revoke and delete tokens, domains, and users. This is also the same level as should be required for any future issue tracking administration, as well as faq administration.

#### Hider
This is someone who is playing the game, but is also hiding one or more tokens on one or more domains. The main reason this role exists is so that we can provide additional information to these users based on how many people (not who they are just the numbers) have found their token, as well as their apiKeys.

A hider can also see all the same information that a standard player can in regard to themselves.

#### Player
This is a typical user and only sees the information on what tokens they have found and where, what their account details are and how to change them, etc… They can also see clues as to where tokens they have not yet found are, however these are to be release periodically throughout the game, and should not all be visible to the user by default.

#### Pending
This is a user who has signed up to play the game, but has not yet activated their account by means of email verification. This status only applies to users who create an account directly with us, and does not apply to those who sign up using browserID.

#### Inactive and notified
This is a user who has been detected as inactive and has been notified as such. We will mark these users with a particular status code and email them a link to remark their account as active. Users who are either Admin OR Support will never be marked as inactive and so it is a simple process to check if an inactive user is also a hider or just a standard user.

### Codes
* **0** = admin
* **1** = support
* **2** = hider
* **3** = player
* **4** = pending
* **5** = inactive

## Domain
### Roles
#### Active
This is a domain that has been registered with the system and verified as belonging to the user that created it. This means that tokens can now be associated with this domain OR should tokens already be on that domain, they too can now be marked as active.

#### Pending
This is a domain that has been registered with the system but has not yet been verified as belonging to the user who has created it. This does not however mean that they cannot start hiding tokens. It simply means that these tokens are not yet marked as active and so cannot be found by those playing the game yet.

#### Revoked
This is when a domain is under suspicion of breaking the mozhunt rules. It means that all tokens associated with it should now be marked as disabled while the domain is investigated. By revoking a domain or token it does not punish users who have already found the token. This action can be chosen at a latter time should it be deemed necessary to do so.

#### Deleted
This is what happens when either a domain has been found to have broken the mozhunt rules, OR the user that created it wishes to remove it from the system. In the situation where it was found to have broken the rules the associated tokens will be completely removed from the game, however should it be that the user who created the domain wish it be removed, mozhunt will re-assign the domain to itself, remove the details of what the domain was, and mark it deleted. This means those that found tokens on the domain do not loose out on points.

### Codes
* **0** = active
* **1** = pending
* **2** = revoked
* **3** = deleted

## Token
### Roles
#### Active
This is where a token has been created and is associated with a domain that is also marked as active. It also means that those playing the game can now find this token and add it to their score.

#### Revoked
This is used when mozhunt deems a single token to be in breach of the rules, and rather than revoking the domain, only the token in question is revoked. Revoked tokens do not penalise the players of the game and the token will remain part of their score should they already have found it.

#### Deleted
This is when a token is removed from the system by either the user who created OR the domain it was associated with the token is marked as deleted.

#### Disabled
This is a temporary removal of a token from the game and is used to mark tokens that are associated with a domain as unfindable while investigations occur.

### Codes
* **0** = active
* **1** = revoked
* **2** = deleted
* **3** = disabled