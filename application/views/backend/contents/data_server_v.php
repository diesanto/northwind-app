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
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
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
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo isset($panel_heading) ? $panel_heading : '';?> </h3>
                </div><!-- /.box-header -->
<?php
switch ($page) {
    case 'view':
?>
<?php
    break;
    
    case 'add':
	case 'update':
?>
<?php
	break;

	default:
?>
 <div class="row">
    <div class="col-md-12">
        <div class="box-body">
            <div class="table-responsive" id="table-responsive"> 
            <table id="table" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>

                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                    </tr>
                </tfoot>
            </table>
            </div>           
        </div>
    </div>
</div>
<?php
        break;
}
?>
            </div><!-- /.box -->
        </div><!--/.col (right) -->
    </div>   <!-- /.row -->
</section><!-- /.content -->
<script src="<?php echo base_url().'assets/'; ?>plugins/jQuery/jquery-3.3.1.min"></script>
<script type="text/javascript">
    var site_url = site_url() + 'data_server/';

    var table;
    $(document).ready(function() {

        //datatables
        table = $('#table').DataTable({ 

            "processing": true, 
            "serverSide": true, 
            "order": [], 
            
            "ajax": {
                "url": site_url + 'get_data',
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