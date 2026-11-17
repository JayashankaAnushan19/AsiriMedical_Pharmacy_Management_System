<?php include('../../control/AdminUser/HeadAndFooter/header.php'); ?>


<div class="container-fluid">
    <div id="demo-element" class="card shadow"> 
        <div class="card-header">
            <p class="text-primary m-0 font-weight-bold">Manage Users
                &nbsp;&nbsp;
                <button id="btnNewExtra" onclick="btnNewExtraFunc()" class="btn btn-info" hidden>New</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button class="btn btn-info" id="go-button" style="float: right;"><i class="icon-fullscreen">Full Screen</i></button>
            </p>
        </div>
        <div class="card-body shadow">
            <form action="../../control/AdminUser/manageUsers.php" method="post">
                <div class="form-row">
                    <div class="col">
                        <div>
                            <strong><center><label class="" id="msgForUser" hidden></label></center></strong>
                        </div>
                    </div>
                </div>
                <div>
                    <input id="txtUserID" type="text" name="txtUserID" hidden>
                </div>
                <div class="form-row">
                    <div class="col">
                        <div class="form-group"><label for="txtUserName"><strong>Name</strong></label>
                            <input class="form-control" type="text" placeholder="Enter Name..." id="txtUserName" name="txtUserName" required></div>
                        </div>
                        <div class="col">
                            <div class="form-group"><label for="txtNICNumber"><strong>NIC</strong></label>
                                <input class="form-control" type="text" placeholder="12345679V" id="txtNICNumber" name="txtNICNumber" required></div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group"><label for="txtUserAddress"><strong>Address</strong></label>
                                    <input class="form-control" type="text" placeholder="No.0, Street, City" id="txtUserAddress" name="txtUserAddress" required></div>
                                </div>
                                <div class="col">
                                    <div class="form-group"><label for="txtUserTel"><strong>Tel</strong></label>
                                        <input class="form-control" type="text" pattern="[0-9]{10}" placeholder="000000" id="txtUserTel" name="txtUserTel" required></div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group"><label for="txtUserUName"><strong>User Name</strong></label>
                                            <input class="form-control" type="text" placeholder="Enter Username for Loggin..." id="txtUserUName" name="txtUserUName" required></div>
                                            <script type="text/javascript">
                                                $(function () {
                                                    $('#txtUserUName').on('click.once', function () {
                                                        alert("User cannot change Username. Only Admin can change Username.");
                                                        $('#txtUserUName').off('click.once');
                                                    })            
                                                });
                                            </script>
                                        </div>
                                        <div class="col">
                                            <div class="form-group"><label for="txtPassword"><strong>Password</strong></label>
                                                <div class="form-inline">
                                                    <input class="form-control" type="password" placeholder="" id="txtPassword" name="txtPassword" required>
                                                    &nbsp;&nbsp;
                                                    <input style="float: right;" type="checkbox" onclick="showHidePassword()"> &nbsp; Show Password
                                                </div>
                                                
                                            </div>
                                            <script type="text/javascript">
                                                function showHidePassword() {
                                                    if( document.getElementById('txtPassword').type == 'password' ) {
                                                        document.getElementById('txtPassword').type="text";
                                                    } else {
                                                        document.getElementById('txtPassword').type="password";
                                                    }
                                                }
                                            </script>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col">
                                            <div class="form-group"><label for="txtUserRole"><strong>User Role</strong></label>
                                                <select class="form-control" id="txtUserRole" name="txtUserRole" onchange="userLevelRequire()" required>
                                                    <option value="-1"> - Select User Role - </option>

                                                    <?php 
                                                    if ($_SESSION['UserLevel'] == 0) {
                                                        echo '<option value="0">Super Admin</option>';
                                                    }
                                                    ?>
                                                    <option value="1">Admin</option>
                                                    <option value="2">Store Keeper</option>
                                                    <option value="3">Cashier</option>
                                                </select>   
                                            </div>
                                            <script type="text/javascript">
                                                function userLevelRequire() {
                                                    var uRoleVal = document.getElementById('txtUserRole').value;
                                                    if (uRoleVal && uRoleVal != -1) {

                                                        var skillsSelect = document.getElementById("txtUserRole");
                                                        var selectedText = skillsSelect.options[skillsSelect.selectedIndex].text;
                                                        if (uRoleVal == 0) {
                                                            var msg = "Can Manage everything."
                                                            document.getElementById('txtUserRoleInfo').value = selectedText + " >>  " + msg;
                                                        }
                                                        else if (uRoleVal == 1) {
                                                            var msg = "Can Manage anything under S.Admin Authorization."
                                                            document.getElementById('txtUserRoleInfo').value = selectedText + " >>  " + msg;
                                                        }
                                                        else if (uRoleVal == 2) {
                                                            var msg = "Only Add and update Stock."
                                                            document.getElementById('txtUserRoleInfo').value = selectedText + " >>  " + msg;
                                                        }
                                                        else if (uRoleVal == 3) {
                                                            var msg = "Only Add Bills."
                                                            document.getElementById('txtUserRoleInfo').value = selectedText + " >>  " + msg;
                                                        }
                                                        
                                                    }
                                                    else{
                                                        document.getElementById('txtUserRoleInfo').value = "";

                                                    }
                                                }
                                            </script>
                                        </div>
                                        <div class="col">
                                            <div class="form-group"><label for="txtUserRoleInfo"><strong>&nbsp;</strong></label>
                                                <input class="form-control" type="text" id="txtUserRoleInfo" name="txtUserRoleInfo" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col">
                                        </div>
                                        <div class="col">
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <button class="btn btn-primary btn-md" id="btn_AddUser" name="btn_AddUser" type="submit">&nbsp;&nbsp;&nbsp;Add&nbsp;&nbsp;&nbsp;</button>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <button class="btn btn-warning btn-md" id="btn_UpdateUser" name="btn_UpdateUser" type="submit">Update</button>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <button class="btn btn-danger btn-md" id="btn_DeleteUser" name="btn_DeleteUser" type="submit">Delete</button>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                </div>
                                                <div class="col">
                                                </div>
                                                <div class="col">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <input class="form-control col-4" style="float: right;" type="text" id="myUserSearchTxt" onkeyup="myUserSearchFunction(0)" placeholder="Search User by NIC..." title="Type in a name"><br>
                                <!-- Show Agents -->
                                <div class="table-responsive table mt-2" id="mainDataTable">
                                    <?php 

                                    include('../../model/db_connection.php'); 

                                    try{

                                        $Connection = setConnection();

                                        if ($_SESSION['UserLevel'] != 0) 
                                        {
                                            $myUserCommand = "SELECT * FROM `tb_adminuser` WHERE `user_Active` = '1' AND `user_Role` != 0";
                                        }
                                        else{
                                            $myUserCommand = "SELECT * FROM `tb_adminuser` WHERE `user_Active` = '1' ";
                                        }

                                        $userResults=mysqli_query($Connection, $myUserCommand);

                                        $numRowsUsers = mysqli_num_rows($userResults);
                                        if ($numRowsUsers > 5) {
                                            $numRowsRemainUsers = mysqli_num_rows($userResults) - 5;
                                            echo "There are {$numRowsUsers} record(s) detected. Remain to show {$numRowsRemainUsers} record(s)";
                                        }
                                        elseif ($numRowsUsers = mysqli_num_rows($userResults) > 0) {
                                            $numRowsUsers = mysqli_num_rows($userResults);
                                            echo "There are {$numRowsUsers} record(s) detected.";
                                        }
                                        else{
                                            echo "No Records Available.";
                                        }
                                        

                                        $table='<table class="table my-0" id="mainUserDataTable">';
                                        $table.='<thead><tr><td><strong>ID</strong></td><td><strong>NIC</strong></td><td><strong>Name</strong></td><td><strong>Telephone </strong></td><td><strong>Address</strong></td></td><td><strong>User Role</strong></td><td><strong>Edit / Delete</strong></td></tr></thead><tbody>';
                                        $n = 0;
                                        while ($record = mysqli_fetch_assoc($userResults)) 
                                        {
                                            $Id=$record['user_ID'];
                                            $NIC=$record['user_NIC'];
                                            $Name=$record['user_Name'];
                                            $Tel=$record['user_Tel'];
                                            $Address=$record['user_Address'];

                                            $UName=$record['user_Uname'];
                                            $Password=$record['user_Password'];
                                            $UsrRole=$record['user_Role'];

                                            $n += 1;
                                            if ($n<6) {
                                                $table.='<tr id="'.$Id.'">';
                                                $table.='<td>'.$Id.'</td>';
                                                $table.='<td>'.$NIC.'</td>';
                                                $table.='<td>'.$Name.'</td>';
                                                $table.='<td>'.$Tel.'</td>';
                                                $table.='<td>'.$Address.'</td>';
                                                $table.='<td hidden>'.$UName.'</td>';
                                                $table.='<td hidden>'.$Password.'</td>';
                                                $table.='<td hidden>'.$UsrRole.'</td>';
                                                if ($UsrRole == 0) {
                                                    $URolename = "Super Admin";
                                                }
                                                elseif ($UsrRole == 1) {
                                                    $URolename = "Admin";
                                                }
                                                elseif ($UsrRole == 2) {
                                                    $URolename = "Store Keeper";
                                                }
                                                elseif ($UsrRole == 3) {
                                                    $URolename = "Cashier";
                                                }
                                                $table.='<td>'.$URolename.'</td>';
                                                $table.='<td>
                                                <button class="btn btn-warning" onclick="myUserUpdateFunction('.$Id.')"><i class="fas fa-edit"></i></button>
                                                <button class="btn btn-danger" onclick="myUserDeleteFunction('.$Id.')"><i class="fas fa-trash"></i></button></td>';
                                                $table.='</tr>';
                                ////
                                            }
                                            else{
                                                $table.='<tr id="'.$Id.'" style="display:none;">';
                                                $table.='<td>'.$Id.'</td>';
                                                $table.='<td>'.$NIC.'</td>';
                                                $table.='<td>'.$Name.'</td>';
                                                $table.='<td>'.$Tel.'</td>';
                                                $table.='<td>'.$Address.'</td>';
                                                $table.='<td hidden>'.$UName.'</td>';
                                                $table.='<td hidden>'.$Password.'</td>';
                                                $table.='<td hidden>'.$UsrRole.'</td>';
                                                if ($UsrRole == 0) {
                                                    $URolename = "Super Admin";
                                                }
                                                elseif ($UsrRole == 1) {
                                                    $URolename = "Admin";
                                                }
                                                elseif ($UsrRole == 2) {
                                                    $URolename = "Store Keeper";
                                                }
                                                elseif ($UsrRole == 3) {
                                                    $URolename = "Cashier";
                                                }
                                                $table.='<td>'.$URolename.'</td>';
                                                $table.='<td>
                                                <button class="btn btn-warning" onclick="myUserUpdateFunction('.$Id.')"><i class="fas fa-edit"></i></button>
                                                <button class="btn btn-danger" onclick="myUserDeleteFunction('.$Id.')"><i class="fas fa-trash"></i></button></td>';
                                                $table.='</tr>';
                                            }
                                            

                                        }
                                        $table.='</tbody> </table>';
                                        echo $table;
                                    }
                                    catch (exception $ex)
                                    {
                                        echo 'Caught exception: ', $ex -> getMessage(), "\n";
                                    }
                                    finally
                                    {
                                        mysqli_close($Connection);
                                    }

                                    ?>    
                                </div>
                            </div>
                        </div>
                    </div>

                    <script type="text/javascript"></script>

                    <script>
                        document.getElementById("btn_UpdateUser").style.display = 'none';
                        document.getElementById("btn_DeleteUser").style.display = 'none';

                        function myUserSearchFunction() {
                          var input, filter, table, tr, td, i, txtValue;
                          input = document.getElementById("myUserSearchTxt");
                          filter = input.value.toUpperCase();
                          table = document.getElementById("mainUserDataTable");
                          tr = table.getElementsByTagName("tr");
                          var n = 1;
                          for (i = 1; i < tr.length; i++) {
                            td = tr[i].getElementsByTagName("td")[1];
                            if (td) {
                              txtValue = td.textContent || td.innerText;
                              if (txtValue.toUpperCase().indexOf(filter) > -1 && n<6) {
                                tr[i].style.display = "";
                                n += 1;
                            } else {
                                tr[i].style.display = "none";
                            }
                        }       
                    } 
                }

                function myUserUpdateFunction(mg){

                    $('td').click(function(){
                        var col = $(this).parent().children().index($(this));
                        var row = $(this).parent().parent().children().index($(this).parent());
        // alert('Row: ' + row + ', Column: ' + col);
        // alert("Hello! I am an alert box!!" + mg);

        var newRow = row + 1;
        table = document.getElementById("mainUserDataTable");
        tr = table.getElementsByTagName("tr");
        document.getElementById("txtUserID").value =  tr[newRow].getElementsByTagName("td")[0].innerHTML;
        document.getElementById("txtUserName").value =  tr[newRow].getElementsByTagName("td")[2].innerHTML;
        document.getElementById("txtNICNumber").value =  tr[newRow].getElementsByTagName("td")[1].innerHTML;
        document.getElementById("txtUserAddress").value =  tr[newRow].getElementsByTagName("td")[4].innerHTML;
        document.getElementById("txtUserTel").value =  tr[newRow].getElementsByTagName("td")[3].innerHTML;
        document.getElementById("txtUserUName").value =  tr[newRow].getElementsByTagName("td")[5].innerHTML;
        document.getElementById("txtPassword").value =  tr[newRow].getElementsByTagName("td")[6].innerHTML;
        document.getElementById("txtUserRole").value =  tr[newRow].getElementsByTagName("td")[7].innerHTML;

        document.getElementById("msgForUser").hidden = true;

        document.getElementById("txtUserName").disabled =  false;
        document.getElementById("txtNICNumber").disabled =  false;
        document.getElementById("txtUserAddress").disabled =  false;
        document.getElementById("txtUserTel").disabled =  false;
        document.getElementById("txtUserUName").disabled =  false;
        document.getElementById("txtPassword").disabled =  false;
        document.getElementById("txtUserRole").disabled =  false;
        // 
        document.getElementById("btnNewExtra").hidden = false;
        document.getElementById("btn_AddUser").style.display = 'none';
        document.getElementById("btn_UpdateUser").style.display = 'block';
        document.getElementById("btn_DeleteUser").style.display = 'none';

    });
        // This prevents the page from scrolling down to where it was previously.
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
    // This is needed if the user scrolls down during page load and you want to make sure the page is scrolled to the top once it's fully loaded. This has Cross-browser support.
    window.scrollTo(0,0);
}

$("#btnNewExtra").click(function (e) {
    document.getElementById("msgForUser").hidden = true;

    document.getElementById("txtUserName").disabled =  false;
    document.getElementById("txtNICNumber").disabled =  false;
    document.getElementById("txtUserAddress").disabled =  false;
    document.getElementById("txtUserTel").disabled =  false;
    document.getElementById("txtUserUName").disabled =  false;
    document.getElementById("txtPassword").disabled =  false;
    document.getElementById("txtUserRole").disabled =  false;

    document.getElementById("txtUserID").value =  "";
    document.getElementById("txtUserName").value =  "";
    document.getElementById("txtNICNumber").value =  "";
    document.getElementById("txtUserAddress").value =  "";
    document.getElementById("txtUserTel").value =  "";
    document.getElementById("txtUserUName").value =  "";
    document.getElementById("txtPassword").value =  "";
    document.getElementById("txtUserRole").value =  "-1";
    
    document.getElementById("btnNewExtra").hidden = true;
    document.getElementById("btn_AddUser").style.display = 'block';
    document.getElementById("btn_UpdateUser").style.display = 'none';
    document.getElementById("btn_DeleteUser").style.display = 'none';

            // This prevents the page from scrolling down to where it was previously.
            if ('scrollRestoration' in history) {
                history.scrollRestoration = 'manual';
            }
        // This is needed if the user scrolls down during page load and you want to make sure the page is scrolled to the top once it's fully loaded. This has Cross-browser support.
        window.scrollTo(0,0);




    });



function myUserDeleteFunction(gh){

    $('td').click(function(){
        var col = $(this).parent().children().index($(this));
        var row = $(this).parent().parent().children().index($(this).parent());
        // alert('Row: ' + row + ', Column: ' + col);
        // alert("Hello! I am an alert box!!" + mg);

        var newRow = row + 1;
        table = document.getElementById("mainUserDataTable");
        tr = table.getElementsByTagName("tr");
        document.getElementById("txtUserID").value =  tr[newRow].getElementsByTagName("td")[0].innerHTML;
        document.getElementById("txtUserName").value =  tr[newRow].getElementsByTagName("td")[2].innerHTML;
        document.getElementById("txtNICNumber").value =  tr[newRow].getElementsByTagName("td")[1].innerHTML;
        document.getElementById("txtUserAddress").value =  tr[newRow].getElementsByTagName("td")[4].innerHTML;
        document.getElementById("txtUserTel").value =  tr[newRow].getElementsByTagName("td")[3].innerHTML;
        document.getElementById("txtUserUName").value =  tr[newRow].getElementsByTagName("td")[5].innerHTML;
        document.getElementById("txtPassword").value =  tr[newRow].getElementsByTagName("td")[6].innerHTML;
        document.getElementById("txtUserRole").value =  tr[newRow].getElementsByTagName("td")[7].innerHTML;

        document.getElementById("msgForUser").hidden = false;
        document.getElementById("msgForUser").innerHTML = "Do you want to Delete this Company?";
        document.getElementById("msgForUser").style.color = 'red';

        document.getElementById("txtUserName").disabled =  true;
        document.getElementById("txtNICNumber").disabled =  true;
        document.getElementById("txtUserAddress").disabled =  true;
        document.getElementById("txtUserTel").disabled =  true;
        document.getElementById("txtUserUName").disabled =  true;
        document.getElementById("txtPassword").disabled =  true;
        document.getElementById("txtUserRole").disabled =  true;

        document.getElementById("btnNewExtra").hidden = false;
        document.getElementById("btn_AddUser").style.display = 'none';
        document.getElementById("btn_UpdateUser").style.display = 'none';
        document.getElementById("btn_DeleteUser").style.display = 'block';

    });
        // This prevents the page from scrolling down to where it was previously.
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
    // This is needed if the user scrolls down during page load and you want to make sure the page is scrolled to the top once it's fully loaded. This has Cross-browser support.
    window.scrollTo(0,0);
}
</script>



<!-- Full Screen or Exit Full Screen -->
<script type="text/javascript">
    function GoInFullscreen(element) {
        if(element.requestFullscreen)
            element.requestFullscreen();
        else if(element.mozRequestFullScreen)
            element.mozRequestFullScreen();
        else if(element.webkitRequestFullscreen)
            element.webkitRequestFullscreen();
        else if(element.msRequestFullscreen)
            element.msRequestFullscreen();
    }

    function GoOutFullscreen() {
        if(document.exitFullscreen)
            document.exitFullscreen();
        else if(document.mozCancelFullScreen)
            document.mozCancelFullScreen();
        else if(document.webkitExitFullscreen)
            document.webkitExitFullscreen();
        else if(document.msExitFullscreen)
            document.msExitFullscreen();
    }

    function IsFullScreenCurrently() {
        var full_screen_element = document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement || null;

        if(full_screen_element === null)
            return false;
        else
            return true;
    }

    $("#go-button").on('click', function() {
        if(IsFullScreenCurrently())
            GoOutFullscreen();
        else
            GoInFullscreen($("#demo-element").get(0));
    });

    $(document).on('fullscreenchange webkitfullscreenchange mozfullscreenchange MSFullscreenChange', function() {
        if(IsFullScreenCurrently()) {
            $("#go-button").text('Exit Full Screen');
        }
        else {
            $("#go-button").text('Full Screen');
        }
    });
</script>

<script src="../../assets/js/jquery.min.js"></script>
<script src="../../assets/bootstrap/js/bootstrap.min.js"></script>
<script src="../../assets/js/chart.min.js"></script>
<script src="../../assets/js/bs-init.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
<script src="../../assets/js/theme.js"></script>