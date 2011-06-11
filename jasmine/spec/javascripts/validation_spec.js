describe("Date Checker", function() {
it("returns empty string if valid is entered", function() {
expect(checkDate('2011-02-28')).toEqual("");
expect(checkDate('2011-02-29')).toContain("Invalid Combination");
expect(checkDate('2011-02-28')).toEqual("");
expect(checkDate('2011-02-28')).toEqual("");
});
});


