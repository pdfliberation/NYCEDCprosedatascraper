<link rel="stylesheet" href="css/basestyles.css" type="text/css"/>
<!DOCTYPE html>
<html>
<head>

<?php
/**
 * Created by PhpStorm.
 * User: michaelsanderson2
 * Date: 1/18/14
 * Time: 4:25 PM
 */
$MTAData = array();
$AirportData = array();
$HotelData = array();
$BroadwayData = array();

//first the script reads the data from each text file
for ($yearloop = 2005; $yearloop < 2014; $yearloop++) {
    for ($monthloop = 1; $monthloop < 13; $monthloop ++) {

        //there was some text issue coverting to txt, using rtf fixed that
        $monthyearsting = sprintf('%02d', $monthloop) . " " . sprintf('%01d', $yearloop) . ".rtf";
        $NewsletterYearMonthString = $yearloop . '-' . sprintf('%02d', $monthloop);
        ///echo "<h3>" . $monthyearsting . "</h3>\n";
        $text = file_get_contents($monthyearsting);
        //echo $text;
        if (empty($text))
        {
            continue;
        }

        //necessary for some PDFs
        $text = preg_replace("/\\nI\\b/us", "", $text);

        $MTAridership = array();
        if (!preg_match("/Total ridership on MTA subways, trains and buses, and bridge and tunnel use in (\\w+) (\\d{4}) was (\\d+\\.?\\d*) million, a (\\d+\\.?\\d*) percent (increase) from (\\1) (\\d{4})/um", $text, $MTAridership))
        {
            $matchMTA = preg_match("/Total ridership on MTA subways, trains and buses in (\\w*) (\\d{4}) was (\\d+\\.?\\d+) million, an? (increase|decrease) of (\\d+\\.?\\d*) percent from (\\1) (\\d{4})/uUs", $text, $MTAridership);
            $includesBridgesAndTunnels  = 0;

        } else {
            $includesBridgesAndTunnels = 1;
        }

//1 - month
//2 - year
//3 - ridership in millions
//4 - increase/decrease
//5 - percent
//7 - year previous


        $month = $MTAridership[1];
        $year = $MTAridership[2];
        $ridershipINMillions = $MTAridership[3];
        $increaeDecrease =  $MTAridership[4]; // not used currently
        $percent = $MTAridership[5]; // not used currently
        $previousYear = $MTAridership[7]; // not used currently

        //check as added:
        //echo "\nMTA Ridership:\n  $month $year: $ridershipINMillions million, $increaeDecrease of $percent percent over $month $previousYear ((";

        //add to array:
        $monthYear = $month . $year;

//get Subway ridership only
        $MTAsubwayridership = array();
        if (preg_match("/Subway(?:\\s+)ridership(?:\\s+)in(?:\\s+)(\\w+)(?:\\s+)(\\d{4})(?:\\s+)was(?:\\s+)(\\d+\\.\\d+)(?:\\s+)million,(?:\\s+)an?(?:\\s+)(increase|decrease)(?:\\s+)of(?:\\s+)(\\d+\\.\\d+)(?:\\s+)percent(?:\\s+)from(?:\\s+)(\\1)(?:\\s+)(\\d{4})/us", $text, $MTAsubwayridership) == 0) {
        //var_dump($MTAsubwayridership);

            preg_match("/In (\\w+) (20\\d{2}), subway ridership was (\\d+\\.?\\d+) million, an? (increase|decrease) of (\\d+\\.?\\d+) percent from (\\w+) (20\\d{2})/us", $text, $MTAsubwayridership);
        }

            $month = $MTAsubwayridership[1];
            $year = $MTAsubwayridership[2];
            $SubwayridershipINMillions = $MTAsubwayridership[3];
            $increaeDecrease =  $MTAsubwayridership[4];
            $percent = $MTAsubwayridership[5];
            $previousYear = $MTAsubwayridership[7];

            //check as added:
            //echo "\n<br>Subway Ridership:\n $month $year: $SubwayridershipINMillions million, $increaeDecrease of $percent percent over $month $previousYear";

            $MTADataOneMonth = array(
                'month' => $month,
                'year' => $year,
                'total ridership' => $ridershipINMillions,
                'total includes bridges and tunnels' => $includesBridgesAndTunnels,//not used
                'subway ridership' => $SubwayridershipINMillions,
                'reported' => $NewsletterYearMonthString
            );
            $MTAData[] = $MTADataOneMonth;


//match air travel

        $airtravel2 = array();
        if(preg_match("/In (\\w+) (\\d{4}), (\\d+\\.?\\d*) million passengers flew in(?:to)? and out of the region\\Ws airports, (?:a (\\d+\\.?\\d*) percent increase|an? (?:decrease|increase) of (\\d+\\.?\\d*) percent) from (\\1) (\\d{4})( passenger levels)?/us", $text, $airtravel2) == 0) {

            preg_match("/Passengers in NYC area airports totaled (\\d+\\.?\\d*) million in (\\w*) (\\d{4}), up (\\d\\.?\\d*) percent from (\\2) (\\d{4})/us",$text, $airtravel2 );
            $month = $airtravel2[2];
            $year = $airtravel2[3];
            $totalTravelRidership = $airtravel2[1];


        } else {

            $month = $airtravel2[1];
            $year = $airtravel2[2];
            $totalTravelRidership = $airtravel2[3];
        }

        //check as added:
        //Echo "\n<br>Air traffic: $month $year: $totalTravelRidership million total \n";

         if (preg_match("/Domestic air carriers accounted for (\\d+\\.?\\d*) million passengers, a? ?(up|down)? (\\d+\\.?\\d*) percent(?:.*) ((\\d+\\.?\\d*)) million passengers traveled with international air carriers/us", $text, $airtravel2 ))
        {
            $domesticTotal = $airtravel2[1];
            $domesticUpDown = $airtravel2[2];
            $domesticUp = $airtravel2[3];
            $InternationalTotal = $airtravel2[4];
            //check as added:
            //Echo "\n<br>Domestic travelers: $domesticTotal million. Intenational: $InternationalTotal million";
        } else {
            preg_match("/Domestic air carriers accounted for (\\d+\\.\\d+) million passengers.*(\\d+\\.\\d+) million passengers traveled with international air carriers/us", $text, $airtravel2);
            $domesticTotal = $airtravel2[1];
            $InternationalTotal = $airtravel2[2];


        }

        $airportOneMonth = array(
            'month' => $month,
            'year' => $year,
            'total_passengers' => $totalTravelRidership,
            'domestic' => $domesticTotal,
            'international' => $InternationalTotal,
            'reported' => $NewsletterYearMonthString
        );

        $AirportData[] = $airportOneMonth;


    $hotels = array();
        preg_match("/In (\\w*) (20\\d{2}), the average daily hotel room rate was \\$(\\d+).* Hotel occupancy was (\\d{2}\\.?\\d*) percent/us", $text, $hotels);
        {
            $month = $hotels[1];
            $year = $hotels[2];
            $averageRate = $hotels[3];
            $percentAverage = $hotels[4];
            //check as added:
            //echo "\n<br>Hotels:  $month $year. Average rate: \$$averageRate, Percent occupancy: $percentAverage ";
        }

        $hotelsOneMonth = array(
            'month' => $month,
            'year' => $year,
            'average rate' => $averageRate,
            'percent occupancy' => $percentAverage,
            'reported' => $NewsletterYearMonthString

        );

        $HotelData[] = $hotelsOneMonth;

        $broadway = array();
        preg_match("/Broadway attendance was approximately ((\\d+\\.?\\d*) million|\\d{3},\\d{3}) during the ((four|five) weeks ending ((\\w+) (\\d+), (20\\d{2})))/us",  $text, $broadway);
        //convert scraped values to numbers here
        //$broadwayAttendance = str_replace(",","", $broadway[1]);
        $broadwayAttendance = $broadway[1];
        $fourOrFiveWeeks = $broadway[4];
        $endingMonth = $broadway[6];
        $endingDay = $broadway[7];
        $endingYear = $broadway[8];
        //check as added:
        //echo "\n<br>Broadway:  Attendance was $broadwayAttendance for <b>$fourOrFiveWeeks</b> weeks ending $endingYear.$endingMonth.$endingDay\n";

        $BroadwayOneMonthPeriod = array(
            'ending month' => $endingMonth,
            'ending year' => $endingYear,
            'ending day' => $endingDay,
            'four or five weeks' => $fourOrFiveWeeks,
            'attendance' => $broadwayAttendance,
            'reported' => $NewsletterYearMonthString
        );

        $BroadwayData[] = $BroadwayOneMonthPeriod;
    }
}


echo "<h3>MTA Ridership (millions):</h3>";
echo 'Original source: Metropolitan Transportation Authority<br/>';
echo 'reported_year-month,stat_year-month,total_ridership,subway_ridership<br/>';

foreach ($MTAData as $MTAOneMonth)
{
    if (empty($MTAOneMonth['month'])){
        continue;
    }

    echo $MTAOneMonth['reported'] . "," .  $MTAOneMonth['year']  . '-' . date('m', strtotime($MTAOneMonth['month'])) . ', ' . $MTAOneMonth['total ridership'] . ', ' . $MTAOneMonth['subway ridership'] . '<br/>'."\n";

}

echo "<h3>Airport Passenger Volume (millions)</h3>";
echo 'Original source: Port Authority of New York and New Jersey<br>';
echo 'reported_year-month,stat_year-month,total_passengers,domestic,international<br/>';
foreach ($AirportData as $AirPortOneMonth)
{
    if (empty($AirPortOneMonth['month'])){
        continue;
    }
    echo $AirPortOneMonth['reported'] . "," . $AirPortOneMonth['year'] . '-' . date('m', strtotime($AirPortOneMonth['month']))  . ', ' . $AirPortOneMonth['total_passengers']  . ', ' . $AirPortOneMonth['domestic']  . ', ' . $AirPortOneMonth['international']  . '</br>' . "\n";

}

echo "<h3>Hotel Rates and Occupancy</h3>";
echo 'reported_year-month,stat_year-month,average_rate,occupancy_percent<br/>';
foreach ($HotelData as $HotelOneMonth)
{
    if (empty($HotelOneMonth['month'])){
        continue;
    }
    echo $HotelOneMonth['reported'] . "," .$HotelOneMonth['year']  . '-' . date('m', strtotime($HotelOneMonth['month'])) . ', ' . $HotelOneMonth['average rate']  . ', ' . $HotelOneMonth['percent occupancy']  . '</br>' . "\n";

}

echo "<h3>Broadway Attendance (by four or five week period)</h3>";
echo 'reported_year-month,stat_period_ending_year-month-day,number_of_weeks,attendance<br/>';
foreach ($BroadwayData as $BroadwayOneMonth)
{
    if (empty($BroadwayOneMonth['ending month'])){
        continue;
    }

    $weeksInt = $BroadwayOneMonth['four or five weeks'] == 'five' ? 5 : 4;

    echo $BroadwayOneMonth['reported'] . ',' . $BroadwayOneMonth['ending year'] . '-' . date('m', strtotime($BroadwayOneMonth['ending month'])) . '-' . sprintf('%02d', $BroadwayOneMonth['ending day'])  . ', ' . $weeksInt . ', ' . $BroadwayOneMonth['attendance']  . '</br>' . "\n";

}



?>

