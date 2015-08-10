# XEMpw
Online paper wallet generator for XEM

XEMpw is an online paper wallet generator wrote in a very few line of PHP and Javascript. 
It allows you to create a physical way to store your XEM <a href="http://nem.io" target="_blank">(?)</a> using remote NIS to generate key pair
(nothing to install on your computer).

See it live <a href="https://www.krakenlabs.org/XEMpw.php" target="_blank">here</a>

#How to 

Start by including the required PHP class provided by php2nem in your page

<?
#include the required class
require_once 'pathto/NEM.php';

#define the initial configuration parameters
#if not defined the defaults will be used
#We set a trusted node as remote NIS but you can use local NIS too
$conf = array('nis_address' => 'go.nem.ninja');

#create an instance using a user defined configuration options
$nem = new NEM($conf);

