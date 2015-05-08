$(document).ready(function() {
   
   //Fode ingot
   $(".item#ingot").mouseenter(function() {
       $(".item#ingot").fadeTo('fast', 1);
   });
   $(".item#ingot").mouseleave(function() {
       $(".item#ingot").fadeTo('fast', 0.8);
   });
   
   //Fade plank
   $(".item#plank").mouseenter(function() {
       $(".item#plank").fadeTo('fast', 1);
   });
   $(".item#plank").mouseleave(function() {
       $(".item#plank").fadeTo('fast', 0.8);
   });
   
   //Fade bolt
   $(".item#bolt").mouseenter(function() {
       $(".item#bolt").fadeTo('fast', 1);
   });
   $(".item#bolt").mouseleave(function() {
       $(".item#bolt").fadeTo('fast', 0.8);
   });
   
   //Fade misc
   $(".item#misc").mouseenter(function() {
       $(".item#misc").fadeTo('fast', 1);
   });
   $(".item#misc").mouseleave(function() {
       $(".item#misc").fadeTo('fast', 0.8);
   });
   
   //Fade nav button
   $(".navbar").mouseenter(function() {
       $(".navbar").animate({
          backgroundColor: jQuery.Color("darkgrey")
       }, 500);
   });
   $(".navbar").mouseleave(function() {
       $(".navbar").animate({
          backgroundColor: jQuery.Color("black")
       }, 500);
   });
});