##Regualr Expressions

These are the regualr expressions used to scrape the data from the prose. 

###MTA Ridership

/Total ridership on MTA subways, trains and buses in (\w*) (\d{4}) was (\d+\.?\d+) million, an? (increase|decrease) of (\d+\.?\d*) percent from (\1) (\d{4})/

Data placed into array positions: 

//1 - month
//2 - year
//3 - ridership in millions
(*Not used in current script:*)
//4 - increase/decrease
//5 - percent
//7 - year previous

#### Subway Ridership only 


/Subway(?:\s+)ridership(?:\s+)in(?:\s+)(\w+)(?:\s+)(\d{4})(?:\s+)was(?:\s+)(\d+\.\d+)(?:\s+)million,(?:\s+)an?(?:\s+)(increase|decrease)(?:\s+)of(?:\s+)(\d+\.\d+)(?:\s+)percent(?:\s+)from(?:\s+)(\1)(?:\s+)(\d{4})/ //*This regex gives an example of how to account for variable white space*

/In (\w+) (20\d{2}), subway ridership was (\d+\.?\d+) million, an? (increase|decrease) of (\d+\.?\d+) percent from (\w+) (20\d{2})/

###Airport Information

/In (\w+) (\d{4}), (\d+\.?\d*) million passengers flew in(?:to)? and out of the region\Ws airports, (?:a (\d+\.?\d*) percent increase|a decrease of 0.2 percent) from (\1) (\d{4})( passenger levels)?/

/Passengers in NYC area airports totaled (\d+\.?\d*) million in (\w*) (\d{4}), up (\d\.?\d*) percent from (\2) (\d{4})/

####Domestic/Internation Breakdown
/Domestic air carriers accounted for (\d+\.?\d*) million passengers, a? ?(up|down)? (\d+\.?\d*) percent(?:.*) ((\d+\.?\d*)) million passengers traveled with international air carriers/

###Hotel Occupancy

/In (\w*) (20\d{2}), the average daily hotel room rate was \$(\d+).* Hotel occupancy was (\d{2}\.?\d*) percent/


###Broadway Attendance

/Broadway attendance was approximately ((\d+\.?\d*) million|\d{3},\d{3}) during the ((four|five) weeks ending ((\w+) (\d+), (20\d{2})))/

