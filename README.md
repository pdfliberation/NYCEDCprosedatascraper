NYCEDCprosedatascraper
======================

This use regex (in php, but can be any language) get data from the NYC EDC newsletters

Process:

First, we extreacted the text from the PDF files using a Mac "Get Text" tool to extract the data.

Second, A set of regular expressions was written (and then converted to PHP) to convert the data of textual indicators in the monthly report to a csv file output format that can be useful to the EDC team and larger community.

We analyzed the discrepencies in descriptions from year to year (to account for the changes in decsriptions/summaries, Coverage included 2005-2013. 

+For expedency we converted pdfs to text files beforehand, but this was originally intended to run in Ruby against text returned from Tabula that was not converted into charts. 

Thanks for the opportunity.
