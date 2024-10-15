<?php
    include_once'connection.php';

    $teacher = "SELECT * FROM tb_teacher";
$stmt = $conn->prepare($teacher);
$stmt->execute();
$Teacher = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include_once "header.php"; ?>

<section class="content-wrapper">
    <div class="container-fluid">
        <div class="row mb-2 card-header">
            <div class="col-sm-6">
                <h1 class="m-0">|Report</h1>
            </div>
            <!-- /.col -->

        </div>
    </div>
    <div class="row m-2">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <div class="form-group" style="width: 300px;">
                            <input type="text" id="" name="namesearch" class="search form-control float-right"
                                placeholder="Search" style="font-family:Khmer OS Siemreap;">
                            <div class="input-group-append">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row m-2">
        <div class="col-4">
            <di class="card">
                <div class="form-group">
                    <select name="" id="" class="form-control">
                        <option value="">1</option>
                        <option value="">1</option>
                        <option value="">1</option>
                    </select>
                </div>
        </div>
    </div>
    </div>

    <div><h3>Source code : PHP export to excel file</h1></div>
<div> 
<div id="container" >
<div class="col-sm-6 pull-left">
                  <div class="well well-sm col-sm-12">
                      <b id='project-capacity-count-lable'><?php echo count($data);?></b> records found.
                   <div class="btn-group pull-right">
  <button type="button" class="btn btn-info">Action</button>
  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
    <span class="caret"></span>
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu" role="menu" id="export-menu">
    <li id="export-to-excel"><a href="#">Export to excel</a></li>
    <li class="divider"></li>
    <li><a href="#">Other</a></li>
  </ul>
</div>
				
                      </div>
					  <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" id="export-form">
						<input type="hidden" value='' id='hidden-type' name='ExportType'/>
					  </form>
                  <table id="" class="table table-striped table-bordered">
                    <tr>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Salary</th>
                  </tr>
                <tbody>
                  <?php foreach($data as $row):?>
				  <tr>
				  <td><?php echo $row ['Name']?></td>
				  <td><?php echo $row ['Status']?></td>
				  <td><?php echo $row ['Priority']?></td>
				  <td><?php echo $row ['Salary']?></td>
				  </tr>
				  <?php endforeach; ?>
                </tbody>
              </table>
              </div></div>  

</div>

</section>

<?php include_once "footer.php"; ?>