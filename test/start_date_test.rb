#! /usr/bin/ruby


########################################
# U S E R      C O N F I G
test_site = "localhost/regi/login.php"
test_user = "jacktest"
test_pass = "jacktest"

# This will use Watir to test web pages
require "rubygems"
require "watir"
Watir::Browser.default="firefox"
puts "Opening a Browser"
p = Watir::Browser.new
puts "Opening Test Site"
p.goto test_site
puts "Entering User Name"
# Note: ".set" is really slow, so I'm using ".value=" instead
p.text_field(:name, "user_name").value = test_user
puts "Entering Password"
p.text_field(:name, "user_password").value = test_pass
puts "Logging In"
p.button(:value, "login").click


start_date = "2011-12-24"
event_name = "test_event"
description= "description " * 24
# ADD NEW EVENT
puts "Clicking Create New Event"
p.link(:text, "Create New Event").click
puts "Entering Information"
p.text_field(:name, "start_date").value = start_date
p.text_field(:name, "event_name").value = event_name
p.text_field(:name, "description").value = description
p.button(:value, "New Event").click
