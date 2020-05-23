<?php 
if(isset($css_files)):
    foreach($css_files as $file): 
?>
    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php 
    endforeach;
endif; 
?>


<section class="content-header">
    <h1>
        <?php echo isset($page_header) ? $page_header : '';?>
        <small></small>
    </h1>
</section> 

<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
             <?php echo isset($output) ? $output : ''; ?>
        </div><!--/.col (right) -->
    </div>   <!-- /.row -->
</section><!-- /.content -->

<?php 
if(isset($js_files)):
    foreach($js_files as $file): ?>
    <script src="<?php echo $file; ?>"></script>
<?php 
    endforeach;
endif; 
?>

<script type="text/javascript">
    $(document).ready(function() {
        var custom_header = '<?php echo isset($custom_header) ? $custom_header : '';?>';

        $('#custom-header').append(custom_header);
    });
       
    function openBlank(url){
        window.open(url);
    }
</script>
