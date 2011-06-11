describe("Date Checker", function() {
it("returns empty string if valid date is entered", function() {
expect(checkDate('2011-02-28')).toEqual("");
expect(checkDate('2011-02-29')).toContain("Invalid Combination");
expect(checkDate('1999-12-26')).toContain("Bad Year");
expect(checkDate('2021-12-26')).toContain("Bad Year");
expect(checkDate('2011-13-26')).toContain("Bad Month");
expect(checkDate('2011-00-26')).toContain("Bad Month");
expect(checkDate('2011-01-32')).toContain("Bad Day");
expect(checkDate('2011-01-00')).toContain("Bad Day");
expect(checkDate('2011-01-3')).toContain("Format Invalid");
expect(checkDate('199R-12-26')).toContain("Format Invalid");
expect(checkDate('2011.12-26')).toContain("Format Invalid");

});
});


