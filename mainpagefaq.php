

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Trips</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/sunny/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="styling.css" rel="stylesheet">
      <link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
      <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyA_6tTKWvu8rFKXruzKisNnFJSrAVsuqxE"></script>
      <style>
        #container{
            margin-top:120px;   
        }

        #notePad, #allNotes, #done, .delete{
            display: none;   
        }

        textarea{
            width: 100%;
            max-width: 100%;
            font-size: 16px;
            line-height: 1.5em;
            border-left-width: 20px;
            border-color: #CA3DD9;
            color: #CA3DD9;
            background-color: #FBEFFF;
            padding: 10px;
              
        }
        
        .noteheader{
            border: 1px solid grey;
            border-radius: 10px;
            margin-bottom: 10px;
            cursor: pointer;
            padding: 0 10px;
            background: linear-gradient(#FFFFFF,#ECEAE7);
        }
          
        .text{
            font-size: 20px;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
          
        .timetext{
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
        .notes{
            margin-bottom: 100px;
        }
          
        #googleMap{
            width: 300px;
            height: 200px;
            margin: 30px auto;
        }
        .modal{
            z-index: 20;   
        }
        .modal-backdrop{
            z-index: 10;        
        }
        #spinner{
          display: none;
          position: fixed;
          top: 0;
          left: 0;
          bottom: 0;
          right: 0;
          height: 85px;
          text-align: center;
          margin: auto;
          z-index: 1100;
      }
        .checkbox{
            margin-bottom: 10px;   
        }
        .trip{
            border:1px solid grey;
            border-radius: 10px;
            margin-bottom:10px;
            background: linear-gradient(#ECE9E6, #FFFFFF);
            padding: 10px;
        }
        .price{
            font-size:1.5em;
        }
        .departure, .destination{
            font-size:1.5em;
        } 
        .perseat{
            font-size:0.5em;
    /*        text-align:right;*/
        }
        .time{
            margin-top:10px;  
        }  
        .notrips{
            text-align:center;
        }
        .trips{
            margin-top: 20px;
        }
        .previewing2{
            margin: auto;
            height: 20px;
            border-radius: 50%;
        }
          #mytrips{
            margin-bottom: 100px;   
          }

        .faq-question {
            background-color: white;
            padding: 10px;
        }

        .faq-answer {
            background-color: #8ebfef; /* or any other light color */
            padding: 10px;
        }
        

      </style>
  </head>
  <body>
    <!--Navigation Bar-->
    <?php
    if(isset($_SESSION["user_id"])){
        include("navigationbarconnected.php");
    }else{
        include("navigationbarnotconnected.php");
    }
    ?>




    <div id="container" class="container-fluid" style="padding: 0px 50px;">
        <div class="row">
            <div style="background-color: #a6a6a6; padding: 30px;" class="col-md-12">
                <h2>Frequently Asked Questions</h2>
                <hr>
                <div class="faq-question">
                    <h3>What is trip sharing?</h3>
                </div>
                <div class="faq-answer">
                    <p>Trip sharing is the practice of sharing a ride with other travelers who are headed in the same direction. It's a great way to save money and reduce your carbon footprint while meeting new people.</p>
                </div>
                <div class="faq-question">
                    <h3>How does trip sharing work?</h3>
                </div>
                <div class="faq-answer">
                    <p>Users sign up and post details about their trip, such as their starting point, destination, and travel dates. Other users can then search for available trips and request to join a ride.</p>
                </div>
                <div class="faq-question">
                    <h3>Is trip sharing safe?</h3>
                </div>
                <div class="faq-answer">
                    <p>We take the safety and security of our users very seriously. All users must create a profile with verified information and we have strict policies in place to ensure a safe and positive experience.</p>
                </div>
                <div class="faq-question">
                    <h3>Can I cancel my trip after I've already accepted passengers?</h3>
                </div>
                <div class="faq-answer">
                    <p>You should only cancel your trip if there's an emergency or unforeseen circumstance. If you need to cancel, please give your passengers as much notice as possible and contact our support team.</p>
                </div>
                <div class="faq-question">
                    <h3>How do I know if a driver is reliable?</h3>
                </div>
                <div class="faq-answer">
                    <p>We have a driver rating system in place that allows passengers to rate their experience with a driver. Before booking a ride, you can view a driver's profile and see their rating and reviews from other passengers.</p>
                </div>
                <div class="faq-question">
                    <h3>Can I bring luggage with me on a trip sharing ride?</h3>
                </div>
                <div class="faq-answer">
                    <p>Most drivers will allow you to bring luggage, but it's always a good idea to check with the driver before booking a ride to make sure they have enough space.</p>
                </div>
                <div class="faq-question">
                    <h3>Can I request a specific driver for my trip?</h3>
                </div>
                <div class="faq-answer">
                    <p>No, we don't allow users to request specific drivers. However, you can view a driver's profile and rating before booking a ride to ensure a positive experience.</p>
                </div>
                <div class="faq-question">
                    <h3>How do I pay for my ride?</h3>
                </div>
                <div class="faq-answer">
                    <p>Payment is typically handled through our website, and we accept a variety of payment methods including credit/debit cards and PayPal.</p>
                </div>
                <div class="faq-question">
                    <h3>How much does it cost to use your trip sharing service?</h3>
                </div>
                <div class="faq-question">
                    <h3>Can I earn money by driving for your service?</h3>
                </div>
                <div class="faq-answer">
                    <p>Yes, drivers can earn money by offering rides through our platform. We have a transparent payment system in place and drivers are paid for the rides they provide.</p>
                </div>
                <div class="faq-question">
                    <h3>Can I smoke or bring alcohol on a trip sharing ride?</h3>
                </div>
                <div class="faq-answer">
                    <p>No, smoking and alcohol are not allowed on trip sharing rides.</p>
                </div>
                <div class="faq-question">
                    <h3>What if I'm running late for my ride?</h3>
                </div>
                <div class="faq-answer">
                    <p>It's important to communicate with your driver if you're running late. You can message them through our platform or call them directly if they've provided their contact information.</p>
                </div>
                <div class="faq-question">
                    <h3>What if my driver is running late?</h3>
                </div>
                <div class="faq-answer">
                    <p>If your driver is running late, they should communicate with you as soon as possible. If you're concerned or need to make alternative travel arrangements, please contact our support team.</p>
                </div>
                <div class="faq-question">
                    <h3>What if I need to make a stop during the ride?</h3>
                </div>
                <div class="faq-answer">
                    <p>Most drivers are willing to make a brief stop during the ride if it's requested in advance. However, please be respectful of your driver's time and make sure the stop doesn't significantly delay the trip.</p>
                </div>
                <div class="faq-question">
                    <h3>What if I have a complaint or issue with my ride?</h3>
                </div>
                <div class="faq-answer">
                    <p>If you have a complaint or issue with your ride, please contact our support team as soon as possible. We take all user feedback seriously and will work to resolve any issues promptly.</p>
                </div>
                <div class="faq-question">
                    <h3>How far in advance should I book my ride?</h3>
                </div>
                <div class="faq-answer">
                    <p>We recommend booking your ride as far in advance as possible to ensure availability. However, you can also search for available rides at the last minute if necessary.</p>
                </div>
                <div class="faq-question">
                    <h3>How do I know if a passenger is trustworthy?</h3>
                </div>
                <div class="faq-answer">
                    <p>Just like with drivers, our platform has a rating system for passengers. After completing a ride with a passenger, drivers can rate their experience and leave a review. Before accepting a passenger's request to join your ride, you can view their profile and see their rating and reviews from other drivers. This should give you a good sense of whether the passenger is trustworthy or not. Additionally, all users on our platform are required to create a verified profile with accurate information, which helps to further ensure safety and reliability.</p>
                </div>
                <div class="faq-question">
                    <h3>Can I bring my pet on a trip sharing ride?</h3>
                </div>
                <div class="faq-answer">
                    <p>It's up to the individual driver whether they allow pets on their rides. Some drivers may be willing to accommodate pets, but it's always a good idea to check with the driver before booking a ride.</p>
                </div>
                <div class="faq-question">
                    <h3>What if I need to change my travel plans after booking a ride?</h3>
                </div>
                <div class="faq-answer">
                    <p>If you need to change your travel plans, please contact your driver as soon as possible to discuss the change. If your driver is unable to accommodate the change, you can cancel your ride and search for a new one.</p>
                </div>
                <div class="faq-question">
                    <h3>How can I contact your support team?</h3>
                </div>
                <div class="faq-answer">
                    <p>You can contact our support team through our website's contact form or by emailing us directly. We're always happy to help with any questions or concerns you may have.</p>
                </div>




    <!-- Footer-->
      <div class="footer">
          <div class="container">
              
          </div>
      </div>
      
      <!--Spinner-->
      <div id="spinner">
         <img src='ajax-loader.gif' width="64" height="64" />
         <br>Loading..
      </div>


    <script src="map.js"></script>  
    <script src="mytrips.js"></script>  
  </body>
</html>