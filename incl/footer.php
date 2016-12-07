
					<nav>
						<ul>
							<?php 
								//if(isset($admin) && ($admin == "secretpage"))
								//{
									include("incl/adminmenu.php"); 
								//}
								//else
								//{
									include("incl/mainmenu.php");
								//}
							?>
						</ul>
					</nav>
					
					
				</div><!-- end main -->
				
                <footer>
                    Kontaktinformation
                </footer>

            </div><!-- end wrapper -->

			<?php
				if(isset($jquery)) {
				?>
					<script type="text/javascript" src="jquery/jquery-3.1.1.js">
						//20150914 2.1.1 -> 2.1.4
						//20161019 2.1.4 -> 3.1.1
					</script>
				<?php
				}
				
				if(isset($slimbox)) {
				?>
					<script type="text/javascript" src="slimbox-2.05/js/slimbox2.js">
						//20150914 2 -> 2.05
					</script>
				<?php
				}
				
				if(isset($accordion)) {
				?>
					<script type="text/javascript" src="jquery-ui-1.12.1/jquery-ui.js">
						//20150914 1.11.1 -> 1.11.4
						//20161019 1.11.4 -> 1.12.1
					</script>
				<?php
				}
				
				if(isset($script)) {
				?>
					<script type="text/javascript" src="script/<?php echo($script); ?>"></script>
				<?php
				}
			?>
			
        </body>

    </html>