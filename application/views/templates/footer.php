			</div>
		<footer>
			<em>&copy; 2016 The Newsletter Pro</em>
		</footer>
		<!--[if lt IE9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<!--[endif]-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
		<script src="<?php echo $assets; ?>js/tnp.min.js"></script>
		<script src='//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js'></script>
		<?php
		if(isset($loadExports)) { ?>
		<link rel='stylesheet' type='text/css' href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css"></link>
		<link rel='stylesheet' type='text/css' href="https://cdn.datatables.net/buttons/1.1.2/css/buttons.dataTables.min.css"></link>
		<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
		<script type="text/javascript" src="//cdn.datatables.net/buttons/1.1.2/js/buttons.flash.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
		<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
		<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
		<script type="text/javascript" src="//cdn.datatables.net/buttons/1.1.2/js/buttons.html5.min.js"></script>
		<script type="text/javascript" src="//cdn.datatables.net/buttons/1.1.2/js/buttons.print.min.js"></script>
		<script type="text/javascript">
		$(function() {
			$('#report').DataTable( {
				dom: 'Bfrtip',
				buttons: [
					'copy', 'csv', 'excel', 'pdf', 'print'
				]
			} );
		});
		</script>
		<?php
		}
		?>
	</body>
</html>