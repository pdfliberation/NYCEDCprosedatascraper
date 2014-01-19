NYCEDCprosedatascraper
======================

This use regex (in php, but can be any language) get data from the NYC EDC newsletters

###Process:

A set of expressions was written in PHP to grab the data from textual indicators in the monthly report. We focused on the last page of Indicators that did not have charts of data accompanying them.

We analyzed the discrepencies in descriptions from year to year, and created expressions that would consistantly grab that data from PDF files. Coverage included 2005-2013. 

For expedency we converted pdfs to text files beforehand, but this was originally intended to run in Ruby against text returned from Tabula that was not converted into charts. 
