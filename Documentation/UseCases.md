##### The first four (4) Use Cases, which are general and mandatory for the assignment, can be found [*here*](https://github.com/dntoll/1dv610/blob/master/assignments/A2_resources/UseCases.md "Use Cases 1-4 by Daniel Toll") 

###### Author: Emma Källström

## Use Case 5 - Update existing password credentials

#### Main scenario
* Starts when a user wants to change its password
* System asks for password
* User provides password
* System updates the saved credentials and presents a success message

#### Alternate Scenarios
* 5a. The user could not be authenticated (wrong, manipulated or nonexistent credentials)
  * i. System presents an error message
  * ii. Step 2 in Use Case 1.

* 5b. Credentials could not be saved (Passwords are too short (<= 5) or do not match)
  * i. System presents an error message
  * ii. Step 2 in main scenario

---
## Use Case 6 - Delete existing user

#### Main scenario
* Starts when a user wants to delete its account
* System asks for user credentials
* User provides credentials
* System deletes the saved credentials, ends the session and presents a success message

#### Alternate scenarios
* 6a. The user could not be authenticated (wrong or nonexistent credentials)
  * i. System presents an error message
  * ii. Step 2 in main scenario

---
