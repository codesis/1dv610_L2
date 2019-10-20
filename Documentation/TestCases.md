##### The first four (4) Test Cases, which are general and mandatory for the assignment, can be found [*here*](https://github.com/dntoll/1dv610/blob/master/assignments/A2_resources/TestCases.md "Test Cases 1-4 by Daniel Toll") 

###### Author: Emma Källström

## Test Case 5.0, Show Update Form
When user wants to update their password a update password form should be shown

#### Input:
* Test case 1.7 Successful login with correct Username and Password
* Press "Update password"

#### Output:
* The text "Logged In" is shown
* The text "Welcome, *username*!" is shown
* An update password form is shown

---

## Test Case 5.1, Failed to update password without any entered fields
Make sure update cannot happen without entering any fields

#### Input:
* Test case 5.0
* Make sure both password fields are empty
* Press "Update password" button

#### Output:
* The text "Password has too few characters, at least 6 characters." is shown
* An update password form is shown

---

## Test Case 5.2 Failed to update password with only one field entered
Make sure update cannot happen when only one field is entered

#### Input:
* Test case 5.0
* Enter a password in one field with minimum 6 characters, leave the other password field empty
* Press "Update password" button

#### Output:
* The text "Password has too few characters, at least 6 characters." is shown
* An update password form is shown

---

## Test Case 5.3, Failed to update password with different inputs
Make sure update cannot happen if the entered passwords do not match

#### Input:
* Test case 5.0
* Enter two different passwords with minimum 6 characters each
* Press "Update password" button

#### Output:
* The text "Passwords do not match." is shown
* An update password form is shown

---

## Test Case 5.4, Successfully updated password
Make sure password is updated when submitting two identical passwords

#### Input:
* Test case 5.0
* Enter two identical passwords with minimum 6 characters each
* Press "Update password" button

#### Output
* The text "Password updated successfully" is shown
* An update password form is shown

---

## Test Case 6.0, Show Delete Form
When user wants to delete their account a delete account form should be shown

#### Input:
* Test case 1.7 Successful login with correct Username and Password
* Press "Delete account"

#### Output:
* The text "Logged In" is shown
* The text "Welcome, *username*!" is shown
* A delete account form is shown

---

## Test Case 6.1, Failed to delete user without entering any fields
Make sure deletion cannot happen without entering any fields

#### Input:
* Test case 6.0
* Make sure username and password field are left empty
* Press "Delete account" button

#### Output:
* The text "Wrong name or password" is shown
* A delete account form is shown

---

## Test Case 6.2, Failed to delete user with only one field entered
Make sure deletion cannot happen with only one field entered

#### Input:
* Test Case 6.0
* Enter text in username field, leave password field empty
* Press "Delete account" button

#### Output:
* The text "Wrong name or password" is shown
* A delete account form is shown

---

## Test Case 6.3, Failed to delete user with both, but faulty, fields entered
Make sure deletion cannot happen with wrong credentials

#### Input:
* Test Case 6.0
* Enter text in both fields but faulty ones
* Press "Delete account" button

#### Output:
* The text "Wrong name or password" is shown
* A delete account form is shown

---

## Test Case 6.4, Failed to delete user with one correct credential entered
Make sure deletion cannot happen with only one correct credential entered

#### Input:
* Test Case 6.0
* Enter the correct username in the username field and a faulty password in the password field
* Press "Delete account" button

#### Output:
* The text "Wrong name or password" is shown
* A delete account form is shown

---

## Test Case 6.5, Successfully deleted user
Make sure deletion is made when both correct credentials are entered

#### Input:
* Test Case 6.0
* Enter the correct username and password in the fields
* Press "Delete account" button

#### Output:
* The text "Not logged in" is shown
* The text "Deleted user successfully" is shown
* The login form is shown

---

## Test Case 6.6, Fail to login deleted user
Make sure the deleted user is deleted from the database and cannot sign in

#### Input:
* Test Case 6.5
* Enter the deleted user's username and password
* Press "Login"

#### Output:
* The text "Not logged in" is shown
* The text "Wrong name or password" is shown
* The login form is shown
