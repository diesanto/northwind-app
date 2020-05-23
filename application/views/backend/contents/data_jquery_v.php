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
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-6">
                        <button type="button" onClick="add_kasus();" class="btn btn-primary" id="add-kasus" >Tambah</button>
                    </div>  

                    <div class="col-lg-6">
                        <form class="form-inline" role="form" method="post" id="search-form" name="search-form">
                            <div class="input-group pull-right">
                                <input type="text" name="key" value="" class="form-control" placeholder="masukan kata kunci"  />
                                <span class="input-group-btn">
                                <button name="search" type="button" id="cari" class="btn btn-default" >Cari</button>
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
<script src="<?php echo base_url().'assets/'; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script type="text/javascript">
    var site_url = site_url() + 'data_jquery/';

    $("#cari").click(function() {
        $('#table-responsive').hide();
        $.post(site_url + 'generate_table/', $('#search-form').serialize(), function(data) {
            $('#table-responsive').html(data);
            $('#table-responsive').slideDown('slow');
        });
    });

</script>