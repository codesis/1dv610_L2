## Test case 1.0 Navigate to page
Page is shown, displaying todays date as [Day of Week], the [day of month numeric]th of [Month as text] [year 4 digits]. The time is [Hour]:[minutes]:[Seconds]. E.g: "Thursday, the 17th of October 2019, The time is 09:24:23.

#### Input:
* Clear existing cookies
* Navigate to site

#### Output:
* The text "Assignment 2" is shown
* The text "Not logged in" is shown
* A link with the text "Register a new user" is shown
* A form for login is shown
* Todays date and time is shown in correct format

// BILD PÅ STARTSIDAN //

---
## Test case 1.1 Failed login without any entered fields
Make sure login cannot happen without entering any fields

#### Input:
* Test case 1.0
* Make sure both username and password are empty
* Press "Login" button

#### Output:
* The text "Not logged in" is shown
* A message "Username is missing" is shown
* A form for login is shown

// BILD PÅ RESULTAT //

---
## Test case 1.2 Failed login with only username
Make sure login cannot happen without entering both fields

#### Input:
* Test case 1.0
* Enter text in the username field and let the password field be empty
* Press "Login" button

#### Output:
* The text "Not logged in" is shown
* A message "Password is missing" is shown
* A form for login is shown
* The text you entered in the username field still remains

// BILD PÅ RESULTAT //

---
## Test case 1.3 Failed login with only password
Make sure login cannot happen without entering both fields

#### Input:
* Test case 1.0
* Enter text in the password field and let the username field be empty
* Press "Login" button

#### Output:
* The text "Not logged in" is shown
* A message "Username is missing" is shown
* A form for login is shown
* Password field is empty

// BILD PÅ RESULTAT //

---
## Test case 1.4 Failed login with wrong password but existing username
Make sure login cannot happen without correct password

#### Input:
* Test case 1.0
* Enter "Admin" in the username field and "password" in the password field (note no capital 'p' in password)
* Press "Login" button

#### Output:
* The text "Not logged in" is shown
* A message "Wrong name or password" is shown
* A form for login is shown
* Password field is empty
* "Admin" remains in the username field

// BILD PÅ RESULTAT //

---
## Test case 1.5 Failed login with existing password but wrong username
Make sure login cannot happen without correct username even if another user has that password

#### Input:
* Test case 1.0
* Enter "admin" in the username field and "Password" in the password field (note no capital 'a' in admin)
* Press "Login" button

#### Output:
* The text "Not logged in" is shown
* A message "Wrong name or password" is shown
* A form for login is shown
* Password field is empty
* "admin" remains in the username field

// BILD PÅ RESULTAT //

---
## Test case 1.6 Successfull login with correct username and password
Make sure login will happen if correct username and password is used

#### Input:
* Test case 1.0
* Enter "Admin" in username field and "Password" in password field
* Press "Login" button

#### Output:
* The text "Logged in" is shown
* A link "Update password" is shown
* A message "Welcome" is shown
* A button "Logout" is shown

// BILD PÅ RESULTAT //

---
