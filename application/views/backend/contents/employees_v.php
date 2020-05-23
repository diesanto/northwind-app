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
                    <button type="button" name="edit" class="btn btn-primary" onClick="location.href='<?php echo site_url('employees/update/'.$EmployeeID); ?>'">Edit Data</button> &nbsp; &nbsp; 
                    <button type="button" name="back" class="btn btn-primary pull-right" onClick="location.href='<?php echo site_url('employees'); ?>'">Back Button</button>
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
                    <?php echo isset($EmployeeID) ? $EmployeeID : '';?>
                    <div class="form-group">
                        <label>First Name</label>
                        <?php echo isset($FirstName) ? $FirstName : '';?>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <?php echo isset($LastName) ? $LastName : '';?>
                    </div> 
                    <div class="form-group">
                        <label>Title</label>
                        <?php echo isset($Title) ? $Title : '';?>
                    </div>
                    <div class="form-group">
                        <label>TitleOfCourtesy</label>
                        <?php echo isset($TitleOfCourtesy) ? $TitleOfCourtesy : '';?>
                    </div>
                    <div class="form-group">
                        <label>Sex</label>
                        <div class="radio">
                            <label>
                                <?php echo isset($Male) ? $Male : '' ;?>
                            <label>
                                <?php echo isset($Female) ? $Female : '' ;?>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Birth Date</label>
                        <?php echo isset($BirthDate) ? $BirthDate : '';?>
                    </div>
                    <div class="form-group">
                        <label>HireDate</label>
                        <?php echo isset($HireDate) ? $HireDate : '';?>
                    </div>

                    <div class="form-group">
                        <label>Photo</label>
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
                        <?php echo isset($Address) ? $Address : '';?>
                    </div>
                    <div class="form-group">
                        <label>City</label>
                        <?php echo isset($City) ? $City : '';?>
                    </div>
                    <div class="form-group">
                        <label>Region</label>
                        <?php echo isset($Region) ? $Region : '';?>
                    </div>
                    <div class="form-group">
                        <label>PostalCode</label>
                        <?php echo isset($PostalCode) ? $PostalCode : '';?>
                    </div>
                    <div class="form-group">
                        <label>HomePhone</label>
                       <?php echo isset($HomePhone) ? $HomePhone : '';?>
                    </div>
                    <div class="form-group">
                        <label>Extension</label>
                        <?php echo isset($Extension) ? $Extension : '';?>
                    </div>
                    <div class="form-group">
                        <label>Country</label>
                        <?php echo isset($Country) ? $Country : '';?>
                    </div>
                    <div class="form-group">
                        <label>Notes</label>
                        <?php echo isset($Notes) ? $Notes : '';?>
                        
                    </div>
                    <div class="form-group">
                        <label>ReportsTo</label>
                        <div class="row">
                            <div class="col-lg-12"><?php echo isset($ReportsTo) ? $ReportsTo : '';?></div>
                        </div>
                        
                    </div>
                </div>
                </div>
            </div>

            <div class="box-footer">
                <input type="submit" name="submit" class="btn btn-primary" value="Submit Data"> &nbsp; &nbsp; 
                <button type="reset" name="reset" class="btn btn-default">Reset Data</button>
                <button type="button" name="back" class="btn btn-primary pull-right" onClick="location.href='<?php echo site_url('employees'); ?>'">Back Button</button>
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
                            <button id="add" class="btn btn-primary btn-sm" title="Data Add" alt="Data Add" onClick="location.href='<?php echo site_url('employees/create'); ?>'"><i class="glyphicon glyphicon-plus"></i> Add Employee</button> &nbsp; &nbsp; &nbsp; 
                            <button id="print-preview" class="btn btn-default btn-sm" title="Data Print" alt="Data Print" onClick="window.open('<?php echo site_url('employees/print_preview'); ?>')"><i class="glyphicon glyphicon-print"></i> Print Preview</button> &nbsp; &nbsp; &nbsp; 
                            <button id="print-pdf" class="btn btn-danger btn-sm" title="Data Print" alt="Data Print" onClick="window.open('<?php echo site_url('employees/print_pdf'); ?>')"><i class="glyphicon glyphicon-save-file"></i> Download PDF</button> 
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
    var site_url = site_url() + 'employees/';

    $("#search").click(function() {
        $('#table-responsive').hide();
        $.post(site_url + 'generate_table/', $('#search-form').serialize(), function(data) {
            $('#table-responsive').html(data);
            $('#table-responsive').slideDown('slow');
        });
    });

</script>