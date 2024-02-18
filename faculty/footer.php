            </div>
		</div>

	</div>

	<div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3">
		<div id="liveToast" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">

			<div class="d-flex">
				<div class="toast-body" style="color: white;">

				</div>
				<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
			</div>

		</div>
	</div>

<script src="../../assets/js/faculty.js"></script>
<?php
	if(isset($js)){
?>
		<script src="<?php echo $js ?>"></script>
<?php
	}
?>
</div>
</body>


</html>