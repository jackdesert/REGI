describe("Date Checker", function() {
it("returns empty string if valid date is entered", function() {
expect(checkDate('02/28/2011')).toEqual("");
expect(checkDate('02/29/2011')).toContain("Invalid Combination");
expect(checkDate('12/26/1999')).toContain("Bad Year");
expect(checkDate('12/26/2021')).toContain("Bad Year");
expect(checkDate('13/26/2011')).toContain("Bad Month");
expect(checkDate('00/26/2011')).toContain("Bad Month");
expect(checkDate('01/32/2011')).toContain("Bad Day");
expect(checkDate('01/00/2011')).toContain("Bad Day");
expect(checkDate('01/3/2011')).toContain("Format Invalid");
expect(checkDate('12/26/199R')).toContain("Format Invalid");
expect(checkDate('12/26.2011')).toContain("Format Invalid");

});
});


