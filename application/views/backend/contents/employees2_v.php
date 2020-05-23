<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo isset($page_header) ? $page_header : '';?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> <?php echo isset($breadcrumb) ? $breadcrumb : ''; ?></li>
    </ol>
</section> 

<!-- Main content -->
<section class="content">
<?php 
if ($this->session->flashdata('success')) {
    echo notifications('success', $this->session->flashdata('success'));
}
if ($this->session->flashdata('error')) {
    echo notifications('error', $this->session->flashdata('error'));
}
if (validation_errors()) {
    echo notifications('warning', validation_errors('<p>', '</p>'));
}
?>

<?php
switch ($page) {
    case 'view':
?>
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo isset($panel_heading) ? $panel_heading : '';?></h3>
            </div><!-- /.box-header -->

            <form>
                <div class="box-body"> 
                    <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="control-label">Employee ID</label>
                            <p class="form-control-static"><?php echo isset($EmployeeID) ? $EmployeeID : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Last Name</label>
                            <p class="form-control-static"><?php echo isset($LastName) ? $LastName : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="control-label">First Name</label>
                            <p class="form-control-static"><?php echo isset($FirstName) ? $FirstName : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Sex</label>
                            <p class="form-control-static"><?php echo isset($Sex) ? $Sex : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Title</label>
                            <p class="form-control-static"><?php echo isset($Title) ? $Title : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="control-label">TitleOfCourtesy</label>
                            <p class="form-control-static"><?php echo isset($TitleOfCourtesy) ? $TitleOfCourtesy : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Birth Date</label>
                            <p class="form-control-static"><?php echo isset($BirthDate) ? $BirthDate : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="control-label">HireDate</label>
                            <p class="form-control-static"><?php echo isset($HireDate) ? $HireDate : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Photo</label>
                            <p class="form-control-static"><?php echo isset($Photo) ? $Photo : '';?></p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="control-label">Address</label>
                            <p class="form-control-static"><?php echo isset($Address) ? $Address : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="control-label">City</label>
                            <p class="form-control-static"><?php echo isset($City) ? $City : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Region</label>
                            <p class="form-control-static"><?php echo isset($Region) ? $Region : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="control-label">PostalCode</label>
                            <p class="form-control-static"><?php echo isset($PostalCode) ? $PostalCode : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="control-label">HomePhone</label>
                            <p class="form-control-static"><?php echo isset($HomePhone) ? $HomePhone : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Extension</label>
                            <p class="form-control-static"><?php echo isset($Extension) ? $Extension : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Country</label>
                            <p class="form-control-static"><?php echo isset($Country) ? $Country : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Notes</label>
                            <p class="form-control-static"><?php echo isset($Notes) ? $Notes : '';?></p>
                        </div>

                        <div class="form-group">
                            <label class="control-label">ReportsTo</label>
                            <p class="form-control-static"><?php echo isset($ReportsTo) ? $ReportsTo : '';?></p>
                        </div>

                    </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="button" name="edit" class="btn btn-primary" onClick="location.href='<?php echo site_url('employees2/update/'.$EmployeeID); ?>'">Edit Data</button> &nbsp; &nbsp; 
                    <button type="button" name="back" class="btn btn-primary pull-right" onClick="location.href='<?php echo site_url('employees2'); ?>'">Back Button</button>
                </div>
            </form>
            
        </div><!-- /.box -->
    </div><!--/.col (right) -->
</div> <!-- /.row -->

<?php
    break;
    
    case 'add':
	case 'update':
?>

<div class="row">
    <div class="col-lg-12">
    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo isset($panel_heading) ? $panel_heading : '';?></h3>
        </div><!-- /.box-header -->
        <form role="form" method="POST" action="<?php echo $action; ?>" enctype="multipart/form-data">  
            <div class="box-body">
                <div class="row">
                <div class="col-lg-6">
                    <input type="hidden" name="EmployeeID" id="EmployeeID" value = "<?php echo isset($EmployeeID) ? $EmployeeID : '';?>" />
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" name="FirstName" id="FirstName" value = "<?php echo isset($FirstName) ? $FirstName : '';?>" />
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" name="LastName" id="LastName" value = "<?php echo isset($LastName) ? $LastName : '';?>" />
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" name="Title" id="Title" value = "<?php echo isset($Title) ? $Title : '';?>" />
                    </div>
                    <div class="form-group">
                        <label>TitleOfCourtesy</label>
                        <input type="text" class="form-control" name="TitleOfCourtesy" id="TitleOfCourtesy" value = "<?php echo isset($TitleOfCourtesy) ? $TitleOfCourtesy : '';?>" />
                    </div>
                    <div class="form-group">
                        <label>Sex</label>
                        <div class="radio">
                        <label><input type="radio" name="Sex" id="Sex" value="M" <?php echo isset($Sex) ? ($Sex == 'M' ? 'checked="true"' : '') : '';?> /> Male</label> &nbsp; &nbsp; 
                        <label><input type="radio" name="Sex" id="Sex" value="F" <?php echo isset($Sex) ? ($Sex == 'F' ? 'checked="true"' : '') : '';?> /> Female</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Birth Date</label>
                        <input type="text" class="form-control" name="BirthDate" id="birthdatepicker"  value = "<?php echo isset($BirthDate) ? $BirthDate : '';?>" />
                    </div>
                    <div class="form-group">
                        <label>HireDate</label>
                        <input type="text" class="form-control" name="HireDate"  id="datepicker" value = "<?php echo isset($HireDate) ? $HireDate : '';?>" />
                    </div>

                    <div class="form-group">
                        <label>Photo</label>
                        <input type="file" name="userfile" /><br/>
                        <?php echo isset($Photo) ? $Photo : '';?>
                    </div>
                    <!--
                    <div class="form-group">
                        <label>Address</label>
                        <textarea  class="form-control" name="Address" id="Address"><?php echo isset($Address) ? $Address : '';?></textarea>
                    </div>
                    -->
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" name="Address" id="Address" value = "<?php echo isset($Address) ? $Address : '';?>" />
                    </div>
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" class="form-control" name="City" id="City" value = "<?php echo isset($City) ? $City : '';?>" />
                    </div>
                    <div class="form-group">
                        <label>Region</label>
                        <input type="text" class="form-control" name="Region" id="Region" value = "<?php echo isset($Region) ? $Region : '';?>" />
                    </div>
                    <div class="form-group">
                        <label>PostalCode</label>
                        <input type="text" class="form-control" name="PostalCode" id="PostalCode" data-inputmask='"mask": "99999"' data-mask value = "<?php echo isset($PostalCode) ? $PostalCode : '';?>" />
                    </div>
                    <div class="form-group">
                        <label>HomePhone</label>
                        <input type="text" class="form-control" name="HomePhone" id="HomePhone" data-inputmask='"mask": "0899-9999-99999"' data-mask value = "<?php echo isset($HomePhone) ? $HomePhone : '';?>" />
                    </div>
                    <div class="form-group">
                        <label>Extension</label>
                        <input type="text" class="form-control" name="Extension" id="Extension" value = "<?php echo isset($Extension) ? $Extension : '';?>" />
                    </div>
                    <div class="form-group">
                        <label>Country</label>
                        <input type="text" class="form-control" name="Country" id="Country" value = "<?php echo isset($Country) ? $Country : '';?>" />
                    </div>
                    <div class="form-group">
                        <label>Notes</label>
                        <textarea class="form-control" name="Notes" id="Notes"><?php echo isset($Notes) ? $Notes : '';?></textarea>
                        
                    </div>
                    <div class="form-group">
                        <label>ReportsTo</label>
                        <?php echo form_dropdown('ReportsTo', $all_employees, isset($ReportsTo) ?$ReportsTo : 0, 'class="form-control"'); ?>
                    </div>
                </div>
                </div>
            </div>

            <div class="box-footer">
                <input type="submit" name="submit" class="btn btn-primary" value="Submit Data"> &nbsp; &nbsp; 
                <button type="reset" name="reset" class="btn btn-default">Reset Data</button>
                <button type="button" name="back" class="btn btn-primary pull-right" onClick="location.href='<?php echo site_url('employees2'); ?>'">Back Button</button>
            </div>
        </form>
    </div><!-- /.box -->
    </div><!--/.col (right) -->
</div><!-- /.row -->
<?php
	break;

	default:
?>
 <div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <?php echo isset($panel_heading) ? $panel_heading : '';?> 
                </h3>
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <button id="add" class="btn btn-primary btn-sm" title="Data Add" alt="Data Add" onClick="location.href='<?php echo site_url('employees2/create'); ?>'"><i class="glyphicon glyphicon-plus"></i> Add Employee</button> 
                        </div>  

                        <div class="col-lg-6">
                           <form class="form-inline" role="form" method="post" id="search-form" name="search-form">
                                <div class="input-group pull-right">
                                    <input type="text" name="q" value="" class="form-control" placeholder=""  />
                                    <span class="input-group-btn">
                                    <button name="search" type="button" id="search" class="btn btn-default" ><i class="glyphicon glyphicon-search"></i> </button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>  

                <div class="table-responsive" id="table-responsive"> 
                <?php echo isset($table) ? $table : ''; ?>
                </div>           
            </div>

        </div><!-- /.box -->
    </div><!--/.col (right) -->
</div>   <!-- /.row -->
<?php
        break;
}
?>
</section><!-- /.content -->

<script src="<?php echo base_url().'assets/'; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script type="text/javascript">
    var site_url = site_url() + 'employees2/';

    $("#search").click(function() {
        $('#table-responsive').hide();
        $.post(site_url + 'generate_table/', $('#search-form').serialize(), function(data) {
            $('#table-responsive').html(data);
            $('#table-responsive').slideDown('slow');
        });
    });

</script>