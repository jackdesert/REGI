describe('test with jasmine-jquery', function () {
  it('should load many fixtures into DOM', function () {
    loadFixtures('my_fixture_1.html');
    var a = readFixtures('my_fixture_1.html');
    //expect(a).toContain('Hi There');
    //expect($('#jasmine-fixtures')).toContain('Hi There');//verifyPasswordLength());
  });

});



/*describe("Verify Password Length", function() {
    //loadFixtures('../fixtures/fake.html');
    beforeEach(function () {
        //fixture = $('<div></div>');//"<div><form name='profile'><input name='user_password'></form></div>");
    });

    it('Checks the password length', function () {
        loadFixtures('fixtures/fake.html');
        print "here are the jasmine fixtures: ";
        print $("#jasmine-fixtures").html();
        expect(('hi').toContain('h'));
        //expect($('#my-fixture').verifyPasswordLength()).toContain("Passwort");
        //expect(fake.verifyPasswordLength()).toContain("Passwort");
    });

});
*/
