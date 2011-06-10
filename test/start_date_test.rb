#! /usr/bin/ruby


########################################
# U S E R      C O N F I G


# This will use Watir to test web pages
require "rubygems"
require "watir"
require 'test/unit'


def login
    ########### U S E R    D E F I N E D  ######################
    test_site = "localhost/regi/login.php"
    test_user = "jacktest"
    test_pass = "jacktest"
    #############################################################
    Watir::Browser.default="firefox"
    puts "Opening a Browser"
    f = Watir::Browser.new
    puts "Opening Test Site"
    f.goto test_site
    puts "Entering User Name"
    # Note: ".set" is really slow, so I'm using ".value=" instead
    f.text_field(:name, "user_name").value = test_user
    puts "Entering Password"
    f.text_field(:name, "user_password").value = test_pass
    puts "Logging In"
    f.button(:value, "login").click
    f   # return value
end

def relax
    #sleep 0.5
end



class AMC < Test::Unit::TestCase

    def test_00_login
        f = login
        assert(f.text.include?( "you are now logged in!" ), "Not Logged In")
        relax
        f.close
        relax
    end
    def test_01_create_event_valid_start_no_end
        f = login
        start_date = "2011-12-24"
        event_name = "test_event"
        description= "description " * 24
        # ADD NEW EVENT
        puts "Clicking Create New Event"
        f.link(:text, "Create New Event").click
        puts "Entering Information"
        f.text_field(:name, "start_date").value = start_date
        f.text_field(:name, "event_name").value = event_name
        f.text_field(:name, "description").value = description
        f.button(:value, "New Event").click
        assert(f.text.include?( "This event has been inserted into the database"), "Event not inserted")
        relax
        f.close
        relax
    end
end

