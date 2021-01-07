<!-- jQuery -->
<script src="../assets/vendor/jquery/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="../assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<!-- Metis Menu Plugin JavaScript -->
<script src="../assets/vendor/metisMenu/metisMenu.min.js"></script>
<!-- Custom Theme JavaScript -->
<script src="../assets/dist/js/sb-admin-2.js"></script>

<!-- Include Date Range Picker -->
<script type="text/javascript" src="../assets/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="../assets/css/bootstrap-datepicker3.css"/>
<script>
  $(document).ready(function(){
    var date_input=$('input[id="date"]'); //our date input has the name "date"
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    date_input.datepicker({
      format: 'mm/dd/yyyy',
      container: container,
      todayHighlight: true,
      autoclose: true,
    })
  })
</script>
