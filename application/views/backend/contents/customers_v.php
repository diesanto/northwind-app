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

            <form class="form-horizontal">
                <div class="box-body"> 
                    <div class="row">
                    <div class="col-lg-8">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Customer ID</label>
                            <p class="form-control-static"><?php echo isset($CustomerID) ? $CustomerID : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Company Name</label>
                            <p class="form-control-static"><?php echo isset($CompanyName) ? $CompanyName : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Contact Name</label>
                            <p class="form-control-static"><?php echo isset($ContactName) ? $ContactName : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Contact Title</label>
                            <p class="form-control-static"><?php echo isset($ContactTitle) ? $ContactTitle : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Address</label>
                            <p class="form-control-static"><?php echo isset($Address) ? $Address : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">City</label>
                            <p class="form-control-static"><?php echo isset($City) ? $City : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Region</label>
                            <p class="form-control-static"><?php echo isset($Region) ? $Region : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">PostalCode</label>
                            <p class="form-control-static"><?php echo isset($PostalCode) ? $PostalCode : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Phone</label>
                            <p class="form-control-static"><?php echo isset($Phone) ? $Phone : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Fax</label>
                            <p class="form-control-static"><?php echo isset($Fax) ? $Fax : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Country</label>
                            <p class="form-control-static"><?php echo isset($Country) ? $Country : '';?></p>
                        </div>
                    </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="button" name="edit" class="btn btn-primary" onClick="location.href='<?php echo site_url('customers/update/'.$CustomerID); ?>'">Edit Data</button> &nbsp; &nbsp; 
                    <button type="button" name="back" class="btn btn-primary pull-right" onClick="location.href='<?php echo site_url('customers'); ?>'">Back Button</button>
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
                    <div class="form-group">
                        <label>Customer ID</label>
                        <input type="text" class="form-control" name="CustomerID" id="CustomerID" value = "<?php echo isset($CustomerID) ? $CustomerID : '';?>" />
                    </div>
                    <div class="form-group">
                        <label>Company Name</label>
                        <input type="text" class="form-control" name="CompanyName" id="CompanyName" value = "<?php echo isset($CompanyName) ? $CompanyName : '';?>" />
                    </div>
                    <div class="form-group">
                        <label>Contact Name</label>
                        <input type="text" class="form-control" name="ContactName" id="ContactName" value = "<?php echo isset($ContactName) ? $ContactName : '';?>" />
                    </div>
                    <div class="form-group">
                        <label>Contact Title</label>
                        <input type="text" class="form-control" name="ContactTitle" id="ContactTitle" value = "<?php echo isset($ContactTitle) ? $ContactTitle : '';?>" />
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" name="Address" id="Address" value = "<?php echo isset($Address) ? $Address : '';?>" />
                    </div>
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" class="form-control" name="City" id="City" value = "<?php echo isset($City) ? $City : '';?>" />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Region</label>
                        <input type="text" class="form-control" name="Region" id="Region" value = "<?php echo isset($Region) ? $Region : '';?>" />
                    </div>
                    <div class="form-group">
                        <label>PostalCode</label>
                        <input type="text" class="form-control" name="PostalCode" id="PostalCode" value = "<?php echo isset($PostalCode) ? $PostalCode : '';?>" />
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control" name="Phone" id="Phone" value = "<?php echo isset($Phone) ? $Phone : '';?>" />
                    </div>
                    <div class="form-group">
                        <label>Fax</label>
                        <input type="text" class="form-control" name="Fax" id="Fax" value = "<?php echo isset($Fax) ? $Fax : '';?>" />
                    </div>
                    <div class="form-group">
                        <label>Country</label>
                        <input type="text" class="form-control" name="Country" id="Country" value = "<?php echo isset($Country) ? $Country : '';?>" />
                    </div>
                </div>
                </div>
            </div>

            <div class="box-footer">
                <input type="submit" name="submit" class="btn btn-primary" value="Submit Data"> &nbsp; &nbsp; 
                <button type="reset" name="reset" class="btn btn-default">Reset Data</button>
                <button type="button" name="back" class="btn btn-primary pull-right" onClick="location.href='<?php echo site_url('customers'); ?>'">Back Button</button>
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
                            <button id="add" class="btn btn-primary btn-sm" title="Data Add" alt="Data Add" onClick="location.href='<?php echo site_url('customers/create'); ?>'"><i class="glyphicon glyphicon-plus"></i> Add Customer</button> 
                        </div>  
                    </div>
                </div>  
                <div class="table-responsive" id="table-responsive"> 
                <table id="table" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width: 100px!important;">Action</th>
                            <th>No</th>
                            <th>CustomerID</th>
                            <th>CompanyName</th>
                            <th>ContactName</th>
                            <th>ContactTitle</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Region</th>
                            <th>PostalCode</th>
                            <th>Country</th>
                            <th>Phone</th>
                            <th>Fax</th>        
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th>Action</th>
                            <th>No</th>
                            <th>CustomerID</th>
                            <th>CompanyName</th>
                            <th>ContactName</th>
                            <th>ContactTitle</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Region</th>
                            <th>PostalCode</th>
                            <th>Country</th>
                            <th>Phone</th>
                            <th>Fax</th>                           
                        </tr>
                    </tfoot>
                </table>
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

<script type="text/javascript">
    var site_url = site_url() + 'customers/';

    var table;
    $(document).ready(function() {

        //datatables
        
        table = $('#table').DataTable({ 
            "processing": true, 
            "serverSide": true, 
            "order": [], 
            
            "ajax": {
                "url": site_url + 'get_customers',
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