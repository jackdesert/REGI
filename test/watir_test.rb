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
    attr_reader :b, :start_date, :end_date, :event_name, :description
    attr_accessor :event_id
    def initialize
        @start_date = "01/01/2011"
        @end_date = "01/01/2011"
        @event_name = "The Name I was Born With"
        @description = "A short, concise treatise on what you will get out of this."
        @event_id = ''
        Watir::Browser.default="firefox"
        puts "Opening a Browser"
        @b = Watir::Browser.new
    end

        def login
        ########### U S E R    D E F I N E D  ######################
        test_site = "localhost/regi/logout.php"
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
        # ADD NEW EVENT
        puts "Clicking Create New Event"
        @b.div(:text, "Create New Event").click
        puts "Entering Information"
        @b.text_field(:name, "start_date").value = @start_date
        @b.text_field(:name, "event_name").value = @event_name
        @b.text_field(:name, "description").value = @description
        @b.button(:value, "Create New Event").click
    end
    def view_profile
        puts "Viewing Profile"
        @b.div("text", "My Profile").click
    end
end

class AMC < Test::Unit::TestCase
    def setup
        @truck = Standard.new
        @truck.login
    end
    #~ def test_00_login
        #~ assert(@truck.b.text.include?( "you are now logged in!" ), "Not Logged In")
        #~ puts "Success!"
        #~ relax
        #~ @truck.b.close
        #~ relax
    #~ end
    #~ def test_01_create_event_valid_start_no_end
        #~ puts "Clicking Create New Event"
        #~ @truck.b.div(:text, "Create New Event").click
        #~ puts "Entering Information"
        #~ @truck.b.text_field(:name, "start_date").value = @truck.start_date
        #~ @truck.b.text_field(:name, "event_name").value = @truck.event_name
        #~ @truck.b.text_field(:name, "description").value = @truck.description
        #~ @truck.b.button(:value, "Create New Event").click
        #~ assert(@truck.b.text.include?( "This event has been inserted into the database"), "Event not inserted")
        #~ assert(@truck.b.html.include?( @truck.start_date ),"Start date not found on page")
        #~ assert(@truck.b.html.include?( @truck.event_name ),"Event name not found on page")
        #~ assert(@truck.b.html.include?( @truck.description ),"Description not found on page")
        #~ # Change Start Date to another reasonable value
        #~ new_date = "02/28/2011"
        #~ @truck.b.text_field(:name, "start_date").value = new_date
        #~ @truck.b.button(:value, "Update Event").click
        #~ assert(@truck.b.text.include?( "This event has been updated in the database"), "Event not inserted")
        #~ assert(@truck.b.html.include?( new_date ),"Start date not found on page")
        #~ end_date = "02/30/2011"
        #~ @truck.b.text_field(:name, "end_date").value = end_date
        #~ @truck.b.button(:value, "Update Event").click
        #~ #assert(@truck.b.text.include?( "Invalid Combination"), "Javascript was supposed to catch bad date combo")
        #~ @truck.b.close
    #~ end
    #~ def test_02_function_create
        #~ puts "creating event using class method"
        #~ @truck.create
        #~ assert(@truck.b.text.include?( "This event has been inserted" ))
    #~ end

    def test_03_update_profile
        @truck.view_profile
        assert(@truck.b.text.include?( "User Name" ))
        # update diet
        myRand = rand(100000000000).to_s
        @truck.b.text_field(:name, "diet").value = myRand
        @truck.b.button(:value, "Update My Profile").click
        assert(@truck.b.text.include?( "Your profile has been updated" ))
        assert(@truck.b.text.include?( myRand ))
    end
end
