<?php
  /*
    manage member page
    You can Add || Edit || Delete memeber from here
  
  
  */

    session_start(); 
    $pageTitle='Member';
     
    if(isset($_SESSION['Username'])){
        
       include 'init.php';

       $do = isset($_GET['do'] )? $_GET['do'] : 'manage';

         /*Start Manage Page*/
       if($do == 'manage'){        //Manage page
         echo 'welcome to manage';

       }elseif($do == 'Edit'){     ////////////////////////////////////////////// (Page Edit)   ////////////////////////////////////
          // echo ' welcome to Edit Page your id = '.$_GET['user_id'];
              /*important*/
          //check if Get Request user_id is Numeric $$ Get integer value(intval) of it
         $user_id=(isset($_GET['user_id']) && is_numeric($_GET['user_id'])) ? intval($_GET['user_id']): 0 ;

          //Select All Data Depend on this ID
         $stmt= $connect->prepare(" SELECT * FROM users where User_ID =? " ); 

          //Excute Query
         $stmt->execute(array( $user_id ));

         //Fecth The Data
         $row=$stmt->fetch(); // جلب المعلومات كلها 

         // ?? id بيعرفني هل فيه ريكورد في الداتا بيز بال  
         $count= $stmt->rowcount();

            //show the form
            if( $stmt->rowcount() > 0){  ?>
                <h2 class="text-center">Edit Member</h2>
                  <div class="container">
                      <form class="form-horizontal" action="?do=Update" method="POST">
                        <input type="hidden" name="userid" value="<?php echo $user_id?>">
                              
                        <div class="form-group form-group-lg">
                          <label class="col-sm-2">UserName</label>
                          <div class="col-sm-10">
                              <input type="text" name="username" class="form-control" value="<?php echo $row['UserName']?>"  autocomplete="off">
                          </div>
                        </div>

                        <div class="form-group form-group-lg">
                          <label class="col-sm-2">Password</label>
                          <div class="col-sm-10">
                              <input type="hidden"   name="old-password" value="<?php echo $row['Password']?>">
                              <input type="password" name="new-Password" class="form-control"  >
                          </div>
                        </div>

                        <div class="form-group form-group-lg">
                          <label class="col-sm-2">Email</label>
                          <div class="col-sm-10">
                              <input type="email" name="Email" class="form-control"  value="<?php echo $row['Email']?>" >
                          </div>
                        </div>

                        <div class="form-group form-group-lg">
                          <label class="col-sm-2">FullName</label>
                          <div class="col-sm-10">
                              <input type="text" name="Full" class="form-control"  value="<?php echo $row['FullName']?>" >
                          </div>
                        </div>

                        <div class="form-group form-group-lg">
                          <div class="col-sm-offset-2 col-sm-10">
                              <input type="submit" value="Update" class="btn btn-primary btn-lg" >
                          </div>
                        </div>


                        </form>
                  </div>      

        <?php
              //if there is no such id show Error Massage 
           } else{
              echo'theres is no such ID';
            }

          }elseif($do ='update'){   /////////////////////////////////////////////////// (Update page) //////////////////////////////
              Echo "<h2 class='text-center'>Update Member</h2>";
              if($_SERVER['REQUEST_METHOD'] == 'POST'){
                   
                //Get variable from the Form
                $id    =$_POST['userid'];
                $user  =$_POST['username'];
                $email =$_POST['Email'];
                $full  =$_POST['Full'];

                /*Password Track*/
                /* Condition ? true : False;
                  $pass= empty($_POST['new-password'])? $_POST['old-password'] : sha1($_POST['new-password']);
                */
                $pass='';
                if(empty($_POST['new-password'])){
                  $pass=$_POST['old-password'];
                }else {
                  $pass=sha1($_POST['new-password']);
                }
                echo $pass;

                /*Validation The form*////////////////
                $FromErrors=array();

              /*  if(strlen($user<3)){
                   $FromErrors[]='Username cant Be less than 4 characters';
                }*/

                if(empty($user)){
                   $FromErrors[] ='Username can Not Empty';                  
                }

                if(empty($email)){
                  $FromErrors[] ='Email can Not Empty';                  
                }

                if(empty($full)){
                  $FromErrors[] ='FullName can Not Empty';                  
                }

                foreach( $FromErrors as $error){
                  Echo $error .'<br/>';
                }

                  /*Update the Database with the info*/
                $stmt=$connect->prepare("UPDATE users SET UserName =? ,Email =?,FullName =? ,Password=? WHERE User_ID =? " );
                $stmt->execute(array($user ,$email ,$full ,$pass ,$id ));

                /*Echo Success Massage*/ 
                Echo $stmt->rowCount().'Recorded Updated'; 
                
              }else{
                Echo 'Sorry You Can Not Browse This Page Directly';
              }

          }

       include $tmp.'Footer.php';
    }

    else{
      
        header('location:index.php');
        exit();
    }