# Ruby on Rails Update: 

Since I have recently become quite adept at working with Ruby on Rails, I decided
to create a Rails implementation of REGI, named "Kooji". 
See source code at http://github.com/jackdesert/kooji

Kooji includes several enhancements over REGI, including: 

  - More responsive (with fewer page loads) using AJAX for things like 
    approving users
  - News feed showing what your most recent activity is (like who you 
    approved for a trip, what you signed up for, when you last updated
    your profile, etc.)
  - Photos of each user, displayable on the carpooling page, so you 
    can get to know people better that you hiked with
  - A leader blurb, or philosophy, displayed on each event that leader is 
    associated with. By seeing the leader's name, photo, and philosophy blurb
    before you even sign up, you have a better sense of whether his/her leadership
    style will mesh with what you're looking to get out of the adventure
  - An enhanced ADMIN page, where you can see all leaders in the system, and 
    easily upgrade them to be admins if you like
  - Carpooling page with entries grouped by whether they are offering or 
    soliciting a ride
  - Enhanced menus
  - Clear delineation of who is the registrar for the event. This allows a user 
    to respond to a system email, and it will go to the registrar for the 
    event. Likewise, if a leader or registrar responds to the email that 
    says "so and so signed up", that email goes to the user who signed up.
  - Code is much easier to maintain
  
You can test out a live prototype of Kooji at http://evening-mountain-9380.heroku.com/
Create a new user like normal, and if you want to turn them into a power user or admin, 
then log in as "admin@sunni.ru" with password "pass", go to the Admin page, and make yourself
an event creator or admin, as you wish. 

And now, back to our regularly scheduled event:

# REGI, an Online Event Registration System

REGI is currently being used by the Boston chapter Hiking and Backpacking
committee to register participants for outdoors-type activities like
hiking in the white mountains of New Hampshire, backpacking on the
Appalachian trail, and learning to snowshoe. You can view the current
manifestation of REGI at http://hbbostonamc.org/regi.

## REGI Features

 - Event leaders can post details about the event they are hosting,
   including cost, meals, dates, speed and difficulty of hike/ski/bike/etc,
   what the terrain will be like, and what type of gear is required
   for the event.
 - Participants can view all of the events being sponsored
   by their AMC committee, and those that use REGI for registration
   will have a direct link to the registration page.
 - Participants can create a profile telling a bit about themselves,
   including what their usual workout routine is, what kinds of
   other outdoor experience they have, and any dietary/medicaly
   restrictions they have
 - With the help of these profiles, event leaders can screen participants,
   making sure only those properly prepared and outfitted come along.
 - Once a participant is approved for an event, he/she can see all
   the other approved participants who are going, including contact
   information, so they can all arrange their own carpooling.


## Hosting Requirements

Here's what you need to know to host REGI on your own site:

 - php
 - apache with .htaccess enabled for mod_rewrite and a couple other features
 - mysql
 - a sendgrid account for sending mail (http://sendgrid.com)
 - pear packages: Swift and Spreadsheet_Excel_Writer

### Email

Email is being sent through Sendgrid
You can log in at sendgrid.com to see how many emails have been sent out.
When you install for your particular chapter, you will need your own sendgrid account

### Pear Packages

Two pear packages are required.
- Swift
- Spreadsheet_Excel_Writer

Once installed, make sure you update the lines that look like:
set_include_path('/home/hbboston/pear/pear/php' . PATH_SEPARATOR . get_include_path());
so that they use your include path (where your pear packages are installed)
I suggest you test the email and the spreadsheet export before you launch :)

### eLyXer (Support Pages)

The support documents are composed in a kick-ass editor named LyX. Google it.
eLyXer is installed as part of this git repository. Just update the .lyx documents, and eLyXer
will output the corresponding html

### Unit Tests

There are unit tests in php/test/unit_tests that you should invoke using
  'phpunit test_name.php'
I suggest running these before each deploy. In particular, they check
the password hashing routine.

### System Security

There is a document outlining the security used in REGI. It is located at
php/docs/regi_security.lyx
It is likely not a complete document, but it will give you a good idea of the
password hashing routine that is used

### Settings

To customize REGI for your particular instance, update php/regi/settings.php
Also you will need a file php/regi/passwords/regi_passwords.php that
contains the following:

<?php

    // Database
    $PASS_DB_HOST        = "localhost";
    $PASS_DB_NAME        = "your_db_name";
    $PASS_DB_USER        = "your_db_user";
    $PASS_DB_PASSWORD    = "your_db_password";

    // Swift Mailer through SendGrid
    $PASS_SWIFT_USER = 'your_sendgrid_user_name';
    $PASS_SWIFT_PASSWORD = 'your_sendgrid_password';

    // Secret code for HMAC generation (Changing this will de-authenticate all cookies associated with this site)
    $PASS_HMAC_SECRET_CODE = "a_really_long_string_off#^^%#%_characters_that_you_choose";

## Contact Information

If you have questions about either hosting or contributing to either Kooji or REGI, please contact me. I'm:

    Jack Desert
    Lead Developer, REGI and Kooji
    jworky@gmail.com 
    (208) 366-6059


