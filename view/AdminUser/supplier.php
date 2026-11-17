    <?php include('../../control/AdminUser/HeadAndFooter/header.php'); ?>

    <style>
        textarea {
          resize: none;
      }
  </style>
  <div id="mainCat" class="container-fluid">
    <div class="card shadow">
        <!-- Main Cat start -->
        <div class="card-header py-3">
            <p class="text-primary m-0 font-weight-bold">Manage Suppliers
                &nbsp;&nbsp;

                <button id="btnNewExtra" class="btn btn-info" hidden>New</button>
            </p>

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 text-nowrap">
                    <form action="../../control/AdminUser/manageCompany.php" method="post">
                        <div class="form-row">
                            <div class="col">
                                <div>
                                    <strong><center><label class="" id="msg" hidden></label></center></strong>
                                </div>
                                <div>
                                    <input id="txtComID" type="text" name="txtComID" hidden>
                                </div>
                                <div class="form-group">
                                    <label for="txtComName">
                                        <strong>Supplier Name 
                                            <!-- Tootip -->
                                            <a href="#" data-toggle="tooltip" title="Enter Company."><i class="fas fa-question-circle" style="color: black;"></i></a>
                                        </strong>
                                    </label>
                                    <input id="txtComName" class="form-control" type="text" placeholder="Company Name" name="txtComName" required>
                                </div>
                                <div class="form-group">
                                    <label for="txtComAddress">
                                        <strong>Address 
                                        </strong>
                                    </label>
                                    <textarea id="txtComAddress" class="form-control" rows="1" placeholder="Company Address" name="txtComAddress" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="txtComTel">
                                        <strong>Telephone
                                        </strong>
                                    </label>
                                    <input id="txtComTel" class="form-control" type="text" placeholder="Company Tel" pattern="[0-9]{10}" name="txtComTel" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            &nbsp;&nbsp;
                            <div class="form-group">
                                <button id="btnAdd" name="btnAdd" class="btn btn-primary btn-md" type="submit">Add New </button>
                            </div> &nbsp;&nbsp;&nbsp;
                            <div class="form-group">
                                <button id="btnUpdate" name="btnUpdate" class="btn btn-warning btn-md" type="submit">Update</button>
                            </div> &nbsp;&nbsp;&nbsp;
                            <div class="form-group">
                                <button id="btnDelete" name="btnDelete" class="btn btn-danger btn-md" type="submit">Delete</button>
                            </div> &nbsp;&nbsp;&nbsp;
                        </div>
                        <!-- Search Company by name -->
                        <input class="form-control col-4" style="float: right;" type="text" id="myInput" onkeyup="myFunction(0)" placeholder="Search Company by Name..." title="Type in a name"><br><br>
                    </form>
                    <!-- Show added Companies -->
                    <div class="table-responsive table mt-2" id="mainDataTable">
                        <?php 

                        include('../../model/db_connection.php'); 

                        try{

                            $Connection = setConnection();

                            $myCoCommand = "SELECT * FROM `tb_company` WHERE `Company_Active` = '1' ";
                            $CoResult=mysqli_query($Connection, $myCoCommand);

                            $numRowsSubCats = mysqli_num_rows($CoResult);

                            if ($numRowsSubCats > 5) {
                                $numRemainRowsSubCats = mysqli_num_rows($CoResult) - 5;
                                echo "There are {$numRowsSubCats} record(s) detected. Remain to show {$numRemainRowsSubCats} record(s)";
                            }
                            else{
                                echo "There are {$numRowsSubCats} record(s) detected.";
                            }


                            $table='<table class="table my-0" id="mainDataTable">';
                            $table.='<thead><tr><td><strong>Company ID</strong></td><td><strong>Company Name</strong></td><td><strong>Company Address</strong></td><td><strong>Company Tel</strong></td><td><strong>Edit / Delete</strong></td></tr></thead><tbody>';
                            $n = 0;
                            while ($record = mysqli_fetch_assoc($CoResult)) 
                            {
                                $Id=$record['Company_ID'];
                                $Name=$record['Company_Name'];
                                $Address=$record['Company_Address'];
                                $Tel=$record['Company_Tel'];

                                $n += 1;
                                if ($n<6) {
                                    $table.='<tr id="'.$Id.'">';
                                    $table.='<td>'.$Id.'</td>';
                                    $table.='<td>'.$Name.'</td>';
                                    $table.='<td>'.$Address.'</td>';
                                    $table.='<td>'.$Tel.'</td>';
                                    $table.='<td>
                                    <button class="btn btn-warning" onclick="myUpdateFunction('.$Id.')"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger" onclick="myDeleteFunction('.$Id.')"><i class="fas fa-trash"></i></button></td>';
                                    $table.='</tr>';
                                                ////
                                }
                                else{
                                    $table.='<tr id="'.$Id.'" style="display:none;">';
                                    $table.='<td>'.$Id.'</td>';
                                    $table.='<td>'.$Name.'</td>';
                                    $table.='<td>'.$Address.'</td>';
                                    $table.='<td>'.$Tel.'</td>';
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
        <!-- Main Cat end -->
    </div>
    <br>
</div>

<!-- Footer part Start from here -->
<?php include('../../control/AdminUser/HeadAndFooter/footer.php');?>

<script>
    document.getElementById("btnUpdate").style.display = 'none';
    document.getElementById("btnDelete").style.display = 'none';

    function myFunction() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("myInput");
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
        document.getElementById("txtComID").value =  tr[newRow].getElementsByTagName("td")[0].innerHTML;
        document.getElementById("txtComName").value =  tr[newRow].getElementsByTagName("td")[1].innerHTML;
        document.getElementById("txtComAddress").value =  tr[newRow].getElementsByTagName("td")[2].innerHTML;
        document.getElementById("txtComTel").value =  tr[newRow].getElementsByTagName("td")[3].innerHTML;

        document.getElementById("msg").hidden = true;

        document.getElementById("txtComName").disabled = false;
        document.getElementById("txtComAddress").disabled = false;
        document.getElementById("txtComTel").disabled = false;
        // 
        document.getElementById("btnNewExtra").hidden = false;
        document.getElementById("btnAdd").style.display = 'none';
        document.getElementById("btnUpdate").style.display = 'block';
        document.getElementById("btnDelete").style.display = 'none';

    });
        // This prevents the page from scrolling down to where it was previously.
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
    // This is needed if the user scrolls down during page load and you want to make sure the page is scrolled to the top once it's fully loaded. This has Cross-browser support.
    window.scrollTo(0,0);
}

$("#btnNewExtra").click(function (e) {
    document.getElementById("msg").hidden = true;

    document.getElementById("txtComName").disabled = false;
    document.getElementById("txtComAddress").disabled = false;
    document.getElementById("txtComTel").disabled = false;

    document.getElementById("txtComName").value = "";
    document.getElementById("txtComAddress").value = "";
    document.getElementById("txtComTel").value = "";
    
    document.getElementById("btnNewExtra").hidden = true;
    document.getElementById("btnAdd").style.display = 'block';
    document.getElementById("btnUpdate").style.display = 'none';
    document.getElementById("btnDelete").style.display = 'none';

            // This prevents the page from scrolling down to where it was previously.
            if ('scrollRestoration' in history) {
                history.scrollRestoration = 'manual';
            }
        // This is needed if the user scrolls down during page load and you want to make sure the page is scrolled to the top once it's fully loaded. This has Cross-browser support.
        window.scrollTo(0,0);




    });



function myDeleteFunction(gh){

    $('td').click(function(){
        var col = $(this).parent().children().index($(this));
        var row = $(this).parent().parent().children().index($(this).parent());
        // alert('Row: ' + row + ', Column: ' + col);
        // alert("Hello! I am an alert box!!" + mg);

        var newRow = row + 1;
        table = document.getElementById("mainDataTable");
        tr = table.getElementsByTagName("tr");
        document.getElementById("txtComID").value =  tr[newRow].getElementsByTagName("td")[0].innerHTML;
        document.getElementById("txtComName").value =  tr[newRow].getElementsByTagName("td")[1].innerHTML;
        document.getElementById("txtComAddress").value =  tr[newRow].getElementsByTagName("td")[2].innerHTML;
        document.getElementById("txtComTel").value =  tr[newRow].getElementsByTagName("td")[3].innerHTML;

        document.getElementById("msg").hidden = false;
        document.getElementById("msg").innerHTML = "Do you want to Delete this Company?";
        document.getElementById("msg").style.color = 'red';

        document.getElementById("txtComName").disabled = true;
        document.getElementById("txtComAddress").disabled = true;
        document.getElementById("txtComTel").disabled = true;

        document.getElementById("btnNewExtra").hidden = false;
        document.getElementById("btnAdd").style.display = 'none';
        document.getElementById("btnUpdate").style.display = 'none';
        document.getElementById("btnDelete").style.display = 'block';

    });
        // This prevents the page from scrolling down to where it was previously.
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
    // This is needed if the user scrolls down during page load and you want to make sure the page is scrolled to the top once it's fully loaded. This has Cross-browser support.
    window.scrollTo(0,0);
}
</script>