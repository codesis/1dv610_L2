##### This application has four (4) Use Cases that are "must-haves" for the assignment. They can be found here: **LINK**. However the basic use cases are modified in this application, e.g. the credentials are not kept alive for 30 days but are instead alive for 1 hour. 

### Use Case 5 - Update existing password credentials

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
### Use Case 6 - Delete existing user

#### Main scenario
* Starts when a user wants to delete its account
* System asks for user credentials
* User provides credentials
* System deletes the saved credentials and presents a success message

#### Alternate scenarios
* 6a. The user could not be authenticated (wrong or nonexistent credentials)
* i. System presents an error message
* ii. Step 2 in main scenario

---
