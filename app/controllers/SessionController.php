<?php


class SessionController extends Controller {

  

   public function storeSessionData() {
      Session::put('my_name', 'Kean');
      echo "Data has been added to session";
   }

   public function accessSessionData() {

      $name = Session::get('my_name'); 

      if (Session::has('my_name'))
      {
        if ($name == "almonte") {
           echo "THis is a true user of the system";
        } else
          echo $name;
      }
      else {
         echo "No user has been found for that session";
      }

  
   }

    public function deleteSessionData() {

       $name = Session::get('my_name'); 
      
       if (Session::has('my_name')) {

         if ($name == "Chester") {
              echo "Chester has been removed from session";
              Session::flush('my_name');
         } 
         else if ($name == "Almonte") {
              echo "Almonte has been removed from session";
              Session::flush('my_name');
         }
         else {
             echo $name." has been removed from session.";
            Session::flush('my_name');
         }
       }
      

      
   }


   

   public function showValidData() {
      return View::make('showValidation');
   }


}