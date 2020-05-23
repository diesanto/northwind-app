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
                    <button type="button" name="edit" class="btn btn-primary" onClick="location.href='<?php echo site_url('employeesx/update/'.$EmployeeID); ?>'">Edit Data</button> &nbsp; &nbsp; 
                    <button type="button" name="back" class="btn btn-primary pull-right" onClick="location.href='<?php echo site_url('employeesx'); ?>'">Back Button</button>
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
        <form role="form" method="POST" action="<?php echo $action; ?>"> 
            <div class="box-body">
                <div class="row">
                <div class="col-lg-6">
                    <?php echo isset($EmployeeID) ? $EmployeeID : '';?>
                    <div class="form-group">
                        <label>Last Name</label>
                        <?php echo isset($LastName) ? $LastName : '';?>
                    </div>
                    <div class="form-group">
                        <label>First Name</label>
                        <?php echo isset($FirstName) ? $FirstName : '';?>
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
                        <div class="input-group date" id="birthpicker">
                            <?php echo isset($BirthDate) ? $BirthDate : '';?>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>                        
                    </div>
                    <div class="form-group">
                        <label>HireDate</label>
                        <?php echo isset($HireDate) ? $HireDate : '';?>
                    </div>

                    <div class="form-group">
                        <label>Photo</label>
                        <?php echo isset($Photo) ? $Photo : '';?>
                    </div>
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
                        <?php echo isset($ReportsTo) ? $ReportsTo : '';?>
                    </div>
                </div>
                </div>
            </div>

            <div class="box-footer">
                <input type="submit" name="submit" class="btn btn-primary" value="Submit Data"> &nbsp; &nbsp; 
                <button type="reset" name="reset" class="btn btn-default">Reset Data</button>
                <button type="button" name="back" class="btn btn-primary pull-right" onClick="location.href='<?php echo site_url('employeesx'); ?>'">Back Button</button>
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
                <h3 class="box-title"><?php echo isset($panel_heading) ? $panel_heading : '';?> </h3>
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <button id="add" class="btn btn-primary btn-sm" title="Data Add" alt="Data Add" onClick="location.href='<?php echo site_url('employeesx/create'); ?>'"><i class="glyphicon glyphicon-plus"></i> Add Employee</button> 
                        </div>  
                    </div>
                </div>  
                <div class="table-responsive" id="table-responsive"> 
                <table id="table" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width: 100px!important;">Action</th>
                            <th>No</th>
                            <th>LastName</th>
                            <th>FirstName</th>
                            <th>Title</th>
                            <th>TitleOfCourtesy</th>
                            <th>BirthDate</th>
                            <th>HireDate</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Region</th>
                            <th>PostalCode</th>
                            <th>Country</th>
                            <th>HomePhone</th>
                            <th>Extension</th>  
                            <th>Photo</th>
                            <th>Notes</th>
                            <th>ReportsTo</th>
                            <th>Sex</th>       
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th>Action</th>
                            <th>No</th>
                            <th>LastName</th>
                            <th>FirstName</th>
                            <th>Title</th>
                            <th>TitleOfCourtesy</th>
                            <th>BirthDate</th>
                            <th>HireDate</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Region</th>
                            <th>PostalCode</th>
                            <th>Country</th>
                            <th>HomePhone</th>
                            <th>Extension</th>  
                            <th>Photo</th>
                            <th>Notes</th>
                            <th>ReportsTo</th>
                            <th>Sex</th>                      
                        </tr>
                    </tfoot>
                </table>
                </div>           
            </div>

        </div><!-- /.box -->
    </div><!--/.col (right) -->
</div> <!-- /.row -->

<script type="text/javascript">
    var site_url = site_url() + 'employeesx/';

    var table;
    $(document).ready(function() {
        
        var pageLength    = 5;
        var iDisplayStart = <?php echo $this->session->flashdata('iDisplayStart') ?  $this->session->flashdata('iDisplayStart') : 0; ?>;
        var searchValue   = "<?php echo $this->session->flashdata('searchValue') ?  $this->session->flashdata('searchValue') : ''; ?>";        
        var recordsFiltered = <?php echo $this->session->flashdata('recordsFiltered') ?  $this->session->flashdata('recordsFiltered') : 0; ?>;

        if(recordsFiltered >= pageLength && recordsFiltered == iDisplayStart) iDisplayStart = iDisplayStart - pageLength;

        table = $('#table').DataTable({ 
            "iDisplayStart" : iDisplayStart,
            "processing": true, 
            "serverSide": true, 
            "pageLength" : pageLength,
            "search" : {
                "search" : searchValue,
            },

            "order": [], 
            
            "ajax": {
                "url": site_url + 'get_employees',
                "type": "POST"
            },
            
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
        });

    });
</script>
<?php
        break;
}
?>
</section><!-- /.content -->

