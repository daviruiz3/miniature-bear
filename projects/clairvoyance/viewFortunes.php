</div>
			<?php include("top.html"); ?>
			<?php include("sidebar.html"); ?>
			<?php #include("facebook.php");?>
			<?php
				#THIS IS HOW TO DO A QUERY------------------------------------!
				$con = mysqli_connect("localhost", "NullPointers", "GJcXxxpA4Zs7BjC6", "NullPointers-ProjectDB");
				if (mysqli_connect_errno())
				  {
				  echo "Failed to connect to MySQL: " . mysqli_connect_error();
				  }
				#echo 'tacos';
				$result = mysqli_query($con,"SELECT * FROM Fortune");
				
				echo 'tacos ';
				#echo $uid = $FacebookLogin->getUser();
				
				if(!$result){
					echo 'i think result is null';
				}
			?>
			
			<p style="text-align: center">Click either the date or the fortune titles to sort</p>
			<table class="sortable" style="padding-left:20px;">
				<tr style="font-weight:bold;">
					<th></th>
					<th style="padding-left: 10px; padding-right: 10px;">Date</th>
					<th>Fortune</th>
				</tr>
				<!-- Each row is one fortune with an Edit link, a Delete Link, and a link for comments. -->
				<?php
					while($row = mysqli_fetch_array($result)){
						#echo $row['FortuneMessage'];
						#echo "<br />";
				?>
				<tr>
					<td><a href="#">Edit</a> | <a href="#">Delete</a></td>
					<td style="padding-left: 10px; padding-right: 10px;"><?php echo $row['CreatedDateTime'];?></td>
					<td><?php echo $row['FortuneMessage'];?></td>				
				</tr>
				<?php } ?>
			</table>
		</div>
	</body>
</html>