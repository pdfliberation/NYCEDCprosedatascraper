NYCEDCprosedatascraper
======================

This use regex (in php, but can be any language) get data from the NYC EDC newsletters

Process:

A set of expressions was written in PHP to grab the data from textual indicators in the monthly report. We fpcused on the last page of Indicators that did not have charts of data accompanying them.

We analyzed the discrepencies in descriptions from year to year, and created expressions that would consistantly grab that data from PDF files. Coverage included 2005-2013. 
