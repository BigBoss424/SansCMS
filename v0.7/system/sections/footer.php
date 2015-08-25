	<div class="section" id="footer">
		<div class="wrapper narrow">
			<div class="column-100">
				<hr class="divider" />
				
				<div class="navigation">
					<div class="nav-container">
						<?php
						
							// render navigation
							// relative paths: 'Example' => 'example'
							// absolute paths: 'Example' => 'http://example.com'
							navigation(array(
								'Footer Page' => 'page',
								'Photography' => 'photography',
								'Twitter' => 'https://twitter.com/thomweerd',
								'Dribbble' => 'https://dribbble.com/thom'
							));
						
						?>
					</div>
				</div>
							
			</div>
		</div>
	</div>

	<script src="<?php print HTTP; ?>assets/js/site.js"></script>

</body>
</html>