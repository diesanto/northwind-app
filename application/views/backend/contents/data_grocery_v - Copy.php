<?php 
if(isset($grocery['css_files'])):
    foreach($grocery['css_files'] as $file): 
?>
    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php 
    endforeach;
endif; 
?>

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
        		<div class="box-body">
                    <div class="table-responsive" id="table-responsive">               
                        <?php echo isset($grocery['output']) ? $grocery['output'] : ''; ?>
                    </div>
                </div>
            </div><!-- /.box -->
        </div><!--/.col (right) -->
    </div>   <!-- /.row -->
</section><!-- /.content -->
<?php 
if(isset($grocery['js_files'])):
    foreach($grocery['js_files'] as $file): ?>
    <script src="<?php echo $file; ?>"></script>
<?php 
    endforeach;
endif; 
?>