<h1><?php echo $title;?></h1>
<div class="col-lg-4">
	<h3>PDF</h3>
	<div class="table-responsive">
		<table id="example" class="table table-bordered">
			<thead>
				<th width="2%">#</th>
				<th>Chapter</th>
				<th>Title</th> 
				<th width="2%">Action</th>
			</thead>
			<tbody>
				<?php 
				$sql = "SELECT * FROM tbllesson WHERE Category='Docs'";
				$mydb->setQuery($sql);
				$cur = $mydb->loadResultList();
				foreach ($cur as $result) {
					# code...
					echo '<tr>';
					echo '<td></td>';
					echo '<td>'.$result->LessonChapter.'</td>';
					echo '<td>'.$result->LessonTitle.'</td>';
					echo '<td><a href="index.php?q=viewpdf&id='.$result->LessonID.'" class="btn btn-xs btn-info"><i class="fa fa-info"></i> View File</a></td>';
					echo '</tr>';
				}
				?>
			</tbody>
		</table>
	</div>
</div>
<div class="col-lg-4">
	<h3>VIDEO</h3>
	<div class="table-responsive">
		<table id="example2" class="table table-bordered">
			<thead>
				<th width="2%">#</th>
				<th>Decription</th>
				<th width="2%">Action</th>
			</thead>
			<tbody>
				<?php 
				$sql = "SELECT * FROM tbllesson WHERE Category='Video'";
				$mydb->setQuery($sql);
				$cur = $mydb->loadResultList();
				foreach ($cur as $result) {
					# code...
					echo '<tr>';
					echo '<td></td>';
					echo '<td>'.$result->LessonTitle.'</td>'; 
					echo '<td><a href="index.php?q=playvideo&id='.$result->LessonID.'" class="btn btn-xs btn-info"><i class="fa fa-play"></i> Play Video</a></td>';
					echo '</tr>';
				}
				?>
			</tbody>
		</table>
	</div>
</div>
<div class="col-lg-4">
	<h3>AUDIO</h3>
	<div class="table-responsive">
		<table id="example3" class="table table-bordered">
			<thead>
				<th width="2%">#</th>
				<th>Decription</th>
				<th width="2%">Action</th>
			</thead>
			<tbody>
				<?php 
				$sql = "SELECT * FROM tbllesson WHERE Category='Audio'";
				$mydb->setQuery($sql);
				$cur = $mydb->loadResultList();
				foreach ($cur as $result) {
					# code...
					echo '<tr>';
					echo '<td></td>';
					echo '<td>'.$result->LessonTitle.'</td>'; 
					echo '<td><a href="index.php?q=playaudio&id='.$result->LessonID.'" class="btn btn-xs btn-info"><i class="fa fa-play"></i> Play Audio</a></td>';
					echo '</tr>';
				}
				?>
			</tbody>
		</table>
	</div>
</div>