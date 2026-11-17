<?php include('../../control/AdminUser/HeadAndFooter/header.php'); ?>


<div class="container-fluid">
    <div class="card shadow"> 
        <div class="card-header">
            <p class="text-primary m-0 font-weight-bold">Manage Agents
                &nbsp;&nbsp;
                <button id="btnNewExtra" onclick="btnNewExtraFunc()" class="btn btn-info" hidden>New</button>
            </p>
        </div>
        <div class="card-body shadow">
            <form action="../../control/AdminUser/manageAgents.php" method="post">
                <div class="form-row">
                    <div class="col">
                        <div>
                            <strong><center><label class="" id="msg" hidden></label></center></strong>
                        </div>
                    </div>
                </div>
                <div>
                    <input id="txtID" type="text" name="txtID" hidden>
                </div>
                <div class="form-row">
                    <div class="col">
                        <div class="form-group"><label for="txtname"><strong>Name</strong></label>
                            <input class="form-control" type="text" placeholder="Name" id="txtname" name="txtname" required></div>
                        </div>
                        <div class="col">
                            <div class="form-group"><label for="txtNIC"><strong>NIC</strong></label>
                                <input class="form-control" type="text" placeholder="12345679V" id="txtNIC" name="txtNIC" required></div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group"><label for="txtAddress"><strong>Address</strong></label>
                                    <input class="form-control" type="text" placeholder="No.00,Street,City" id="txtAddress" name="txtAddress" required></div>
                                </div>
                                <div class="col">
                                    <div class="form-group"><label for="txtTel"><strong>Tel</strong></label>
                                        <input class="form-control" type="text" pattern="[0-9]{10}" placeholder="000000" id="txtTel" name="txtTel" required></div>
                                    </div>
                                </div>
                                <div class="form-row">
                                   <div class="col">
                                   </div>
                                   <div class="col">
                                      <div class="form-row">
                                         <div class="col">
                                          <div class="form-group">
                                             <button class="btn btn-primary btn-md" id="btn_AddAgent" name="btn_AddAgent" type="submit">&nbsp;&nbsp;&nbsp;Add&nbsp;&nbsp;&nbsp;</button>
                                         </div>
                                     </div>
                                     <div class="col">
                                      <div class="form-group">
                                         <button class="btn btn-warning btn-md" id="btn_UpdateAgent" name="btn_UpdateAgent" type="submit">Update</button>
                                     </div>
                                 </div>
                                 <div class="col">
                                  <div class="form-group">
                                     <button class="btn btn-danger btn-md" id="btn_DeleteAgent" name="btn_DeleteAgent" type="submit">Delete</button>
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
             <input class="form-control col-4" style="float: right;" type="text" id="myAgentSearchTxt" onkeyup="myAgentSearchFunction(0)" placeholder="Search Agent by NIC..." title="Type in a name"><br>
             <!-- Show Agents -->
             <div class="table-responsive table mt-2" id="mainDataTable">
                <?php 

                include('../../model/db_connection.php'); 

                try{

                    $Connection = setConnection();

                    $myCoCommand = "SELECT * FROM `tb_agent` WHERE `Agent_Active` = '1' ";
                    $CoResult=mysqli_query($Connection, $myCoCommand);

                    $numRowsSubCats = mysqli_num_rows($CoResult);
                    if ($numRowsSubCats > 5) {
                        $numRemainRowsSubCats = mysqli_num_rows($CoResult) - 5;
                        echo "There are {$numRowsSubCats} record(s) detected. Remain to show {$numRemainRowsSubCats} record(s)";
                    }
                    elseif ($numRowsSubCats = mysqli_num_rows($CoResult) > 0) {
                        $numRowsSubCats = mysqli_num_rows($CoResult);
                        echo "There are {$numRowsSubCats} record(s) detected.";
                    }
                    else{
                        echo "No Records Available.";
                    }
                    

                    $table='<table class="table my-0" id="mainDataTable">';
                    $table.='<thead><tr><td><strong>ID</strong></td><td><strong>NIC</strong></td><td><strong>Name</strong></td><td><strong>Telephone </strong></td><td><strong>Address</strong></td><td><strong>Edit / Delete</strong></td></tr></thead><tbody>';
                    $n = 0;
                    while ($record = mysqli_fetch_assoc($CoResult)) 
                    {
                        $Id=$record['Agent_ID'];
                        $NIC=$record['Agent_NIC'];
                        $Name=$record['Agent_Name'];
                        $Tel=$record['Agent_Tel'];
                        $Address=$record['Agent_Address'];

                        $n += 1;
                        if ($n<6) {
                            $table.='<tr id="'.$Id.'">';
                            $table.='<td>'.$Id.'</td>';
                            $table.='<td>'.$NIC.'</td>';
                            $table.='<td>'.$Name.'</td>';
                            $table.='<td>'.$Tel.'</td>';
                            $table.='<td>'.$Address.'</td>';
                            $table.='<td>
                            <button class="btn btn-warning" onclick="myUpdateFunction('.$Id.')"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-danger" onclick="myDeleteFunction('.$Id.')"><i class="fas fa-trash"></i></button></td>';
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
                            $table.='<td>
                            <button class="btn btn-warning" onclick="myUpdateFunction('.$Id.')"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-danger" onclick="myDeleteFunction('.$Id.')"><i class="fas fa-trash"></i></button></td>';
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

<!-- Footer part Start from here -->
<?php include('../../control/AdminUser/HeadAndFooter/footer.php'); ?>

<script type="text/javascript">
    //For Main Category Section - Start
    document.getElementById("btn_UpdateAgent").style.display = 'none';
    document.getElementById("btn_DeleteAgent").style.display = 'none';

    function myAgentSearchFunction() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("myAgentSearchTxt");
      filter = input.value.toUpperCase();
      table = document.getElementById("mainDataTable");
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

function myUpdateFunction(mg){

    $('td').click(function(){
        var col = $(this).parent().children().index($(this));
        var row = $(this).parent().parent().children().index($(this).parent());
        // alert('Row: ' + row + ', Column: ' + col);
        // alert("Hello! I am an alert box!!" + mg);

        var newRow = row + 1;
        table = document.getElementById("mainDataTable");
        tr = table.getElementsByTagName("tr");
        document.getElementById("txtID").value =  tr[newRow].getElementsByTagName("td")[0].innerHTML;
        document.getElementById("txtNIC").value =  tr[newRow].getElementsByTagName("td")[1].innerHTML;
        document.getElementById("txtname").value =  tr[newRow].getElementsByTagName("td")[2].innerHTML;
        document.getElementById("txtTel").value =  tr[newRow].getElementsByTagName("td")[3].innerHTML;
        document.getElementById("txtAddress").value =  tr[newRow].getElementsByTagName("td")[4].innerHTML;

        document.getElementById("msg").hidden = true;

        document.getElementById("txtID").disabled = false;
        document.getElementById("txtNIC").disabled = false;
        document.getElementById("txtname").disabled = false;
        document.getElementById("txtTel").disabled = false;
        document.getElementById("txtAddress").disabled = false;
        // 
        document.getElementById("btnNewExtra").hidden = false;
        document.getElementById("btn_AddAgent").style.display = 'none';
        document.getElementById("btn_UpdateAgent").style.display = 'block';
        document.getElementById("btn_DeleteAgent").style.display = 'none';

    });
        // This prevents the page from scrolling down to where it was previously.
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
    // This is needed if the user scrolls down during page load and you want to make sure the page is scrolled to the top once it's fully loaded. This has Cross-browser support.
    window.scrollTo(0,0);
}

function btnNewExtraFunc() {
    document.getElementById("msg").hidden = true;

    document.getElementById("txtname").disabled = false;
    document.getElementById("txtNIC").disabled = false;
    document.getElementById("txtAddress").disabled = false;
    document.getElementById("txtTel").disabled = false;

    document.getElementById("txtname").value = "";
    document.getElementById("txtNIC").value = "";
    document.getElementById("txtAddress").value = "";
    document.getElementById("txtTel").value = "";
    
    document.getElementById("btnNewExtra").hidden = true;
    document.getElementById("btn_AddAgent").style.display = 'block';
    document.getElementById("btn_UpdateAgent").style.display = 'none';
    document.getElementById("btn_DeleteAgent").style.display = 'none';

            // This prevents the page from scrolling down to where it was previously.
            if ('scrollRestoration' in history) {
                history.scrollRestoration = 'manual';
            }
        // This is needed if the user scrolls down during page load and you want to make sure the page is scrolled to the top once it's fully loaded. This has Cross-browser support.
        window.scrollTo(0,0);
    }

    function myDeleteFunction(gh){

        $('td').click(function(){
            var col = $(this).parent().children().index($(this));
            var row = $(this).parent().parent().children().index($(this).parent());
        // alert('Row: ' + row + ', Column: ' + col);
        // alert("Hello! I am an alert box!!" + mg);

        var newRow = row + 1;
        table = document.getElementById("mainDataTable");
        tr = table.getElementsByTagName("tr");
        document.getElementById("txtID").value =  tr[newRow].getElementsByTagName("td")[0].innerHTML;
        document.getElementById("txtNIC").value =  tr[newRow].getElementsByTagName("td")[1].innerHTML;
        document.getElementById("txtname").value =  tr[newRow].getElementsByTagName("td")[2].innerHTML;
        document.getElementById("txtTel").value =  tr[newRow].getElementsByTagName("td")[3].innerHTML;
        document.getElementById("txtAddress").value =  tr[newRow].getElementsByTagName("td")[4].innerHTML;

        document.getElementById("msg").hidden = false;
        document.getElementById("msg").innerHTML = "Do you want to Delete this Agent?";
        document.getElementById("msg").style.color = 'red';

        document.getElementById("txtname").disabled = true;
        document.getElementById("txtNIC").disabled = true;
        document.getElementById("txtTel").disabled = true;
        document.getElementById("txtAddress").disabled = true;

        document.getElementById("btnNewExtra").hidden = false;
        document.getElementById("btn_AddAgent").style.display = 'none';
        document.getElementById("btn_UpdateAgent").style.display = 'none';
        document.getElementById("btn_DeleteAgent").style.display = 'block';

    });
        // This prevents the page from scrolling down to where it was previously.
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
    // This is needed if the user scrolls down during page load and you want to make sure the page is scrolled to the top once it's fully loaded. This has Cross-browser support.
    window.scrollTo(0,0);
}
//For Main Category Section - End

</script>