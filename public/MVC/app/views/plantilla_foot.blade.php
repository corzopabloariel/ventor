		<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/select2@4.0.7-rc.0/dist/js/select2.min.js"></script>
		<script src="<?php echo RUTA_HTTP; ?>assets/js/alertify.min.js"></script>
		<script src="<?php echo RUTA_HTTP; ?>assets/js/toolbox.js"></script>
		<script src="<?php echo RUTA_HTTP; ?>assets/js/pyrus.js"></script>
		<script src="<?php echo RUTA_HTTP; ?>assets/js/declaration.js"></script>
		<script src="<?php echo RUTA_HTTP; ?>assets/js/pyrus.min.js"></script>
		<script>
			window.url = "<?php echo $URL; ?>";
			window.datos = <?php echo isset($datos) ? json_encode($datos) : null; ?>;
			
			$(document).ready(function() {
				$("body").on("click",".alert button.close", function() {
					$(this).closest(".alert").remove();
				});

				if($("#sidebar").find(`a[href="${window.url}"]`).data("link") == "u") {
					$("#sidebar").find(`a[href="${window.url}"]`).addClass("active");
					$("#sidebar").find(`a[href="${window.url}"]`).closest("ul").addClass("show");
					$("#sidebar").find(`a[href="${window.url}"]`).closest("ul").prev().attr("aria-expanded",true).parent().addClass("active");
				} else
					$("#sidebar").find(`a[href="${window.url}"]`).parent().addClass("active");
			});
		</script>
		<?php
		if(isset($data["scripts"])) {
			if(!empty($data["scripts"])) {
				foreach($data["scripts"] AS $l)
					echo $l;
			}
		}
		if(isset($data["script"])) {
			echo $data["script"];
		}
		?>
	</body>
</html>
