#! /usr/bin/ruby

require 'test/unit'

class JavaScript < Test::Unit::TestCase

    def test_00_run_jasmine
        # Call jasmine unit testing
        Dir.chdir("/home/jd/php/jasmine")
        message = `rake jasmine:ci`
        assert(message.include?( "0 failures" ), "Javascript Unit Tests Failed")
    end
end
