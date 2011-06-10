#! /usr/bin/ruby


########################################
# U S E R      C O N F I G


# This will use Watir to test web pages
require "rubygems"
require "watir"
require 'test/unit'




def relax
    #sleep 0.5
end


class Standard
    attr_reader :b
    def initialize
        @start_date = "2011-01-01"
        @end_date = "2011-01-01"
        @event_name = "The Name I was Born With"
        @description = "A short, concise treatise on what you will get out of this."
        Watir::Browser.default="firefox"
        puts "Opening a Browser"
        @b = Watir::Browser.new
    end

        def login
        ########### U S E R    D E F I N E D  ######################
        test_site = "localhost/regi/login.php"
        test_user = "jacktest"
        test_pass = "jacktest"
        #############################################################
        puts "Opening Test Site"
        @b.goto test_site
        puts "Entering User Name"
        # Note: ".set" is really slow, so I'm using ".value=" instead
        @b.text_field(:name, "user_name").value = test_user
        puts "Entering Password"
        @b.text_field(:name, "user_password").value = test_pass
        puts "Logging In"
        @b.button(:value, "login").click
        @b   # return value
    end
    def create
        start_date = "2011-12-24"
        event_name = "test_event"
        description= "description " * 24
        # ADD NEW EVENT
        puts "Clicking Create New Event"
        @b.link(:text, "Create New Event").click
        puts "Entering Information"
        @b.text_field(:name, "start_date").value = start_date
        @b.text_field(:name, "event_name").value = event_name
        @b.text_field(:name, "description").value = description
        @b.button(:value, "New Event").click
    end
    def close
        @b.close
    end

end

class AMC < Test::Unit::TestCase
    def setup
        @truck = Standard.new
    end
    def test_00_login
        @truck.login
        assert(@truck.b.text.include?( "you are now logged in!" ), "Not Logged In")
        puts "Success!"
        relax
        @truck.close
        relax
    end
    #~ def test_01_create_event_valid_start_no_end
        #~ f = login
        #~ start_date = "2011-12-24"
        #~ event_name = "test_event"
        #~ description= "description " * 24
        #~ # ADD NEW EVENT
        #~ puts "Clicking Create New Event"
        #~ f.link(:text, "Create New Event").click
        #~ puts "Entering Information"
        #~ f.text_field(:name, "start_date").value = start_date
        #~ f.text_field(:name, "event_name").value = event_name
        #~ f.text_field(:name, "description").value = description
        #~ f.button(:value, "New Event").click
        #~ assert(f.text.include?( "This event has been inserted into the database"), "Event not inserted")
        #~ relax
        #~ f.close
        #~ relax
    #~ end
end

