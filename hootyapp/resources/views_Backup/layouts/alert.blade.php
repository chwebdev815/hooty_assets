@if ($errors->any())
<script type="text/javascript">
	toastr.error('Please check the form below for errors', 'Error', {timeOut: 5000})
</script>
@endif

@if ($message = Session::get('success'))
<script type="text/javascript">
	toastr.success('<?php echo $message; ?>', 'Success', {timeOut: 5000})
</script>
<?php Session::forget('success');?>
@endif

@if ($message = Session::get('error'))
<script type="text/javascript">
	toastr.error('<?php echo $message; ?>', 'Error', {timeOut: 5000})
</script>
<?php Session::forget('error');?>
@endif

@if ($message = Session::get('warning'))
<script type="text/javascript">
	toastr.warning('<?php echo $message; ?>', 'Warning', {timeOut: 5000})
</script>
<?php Session::forget('warning');?>
@endif

@if ($message = Session::get('info'))
<script type="text/javascript">
</script>
<?php Session::forget('info');?>
@endif