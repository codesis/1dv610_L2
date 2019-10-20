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
* "The text "Password updated successfully" is shown
* An update password form is shown

---

