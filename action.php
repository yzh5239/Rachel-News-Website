<?php include('main.php') ?>
<?php
	$db = mysqli_connect('localhost', 'root', '19961211', 'registration');

	$selected = "";
	if(isset($_POST['submit'])){
		if(!empty($_POST['check'])){
			foreach($_POST['check'] as $check){
				$selected .= $check;
				$selected .= "/#/";
			}
		}

		$selected = substr($selected, 0, -3);
		//Check duplicity if so, override previous one
		$sql = "SELECT * FROM $data";
		$result = mysqli_query($db,$sql)or die(mysqli_error($db));
	
		$checkArray = array();
		$index = 0;
		$flag = 0;
		while($rows = mysqli_fetch_array($result)){
			$checkArray[$index] = $rows;
			$index++;
		}

		foreach($checkArray as $value){
			if($value['username']==$username and $value['PhotoID'] == $imgID[$imgIndex]){
				$sql = "UPDATE $data SET `Sentence`='$selected' WHERE `PhotoID`='$imgID[$imgIndex]' AND `username`='$username'";
				$flag = 1;
			}
		}
		echo $username;
		echo $imgID[$imgIndex];
		echo $selected;
		if($flag == 0){
			$sql = "INSERT INTO $data (username, PhotoID, Sentence) VALUES ('$username','$imgID[$imgIndex]', '$selected')";
		}

		echo "<br><br>";
		if(!mysqli_query($db, $sql)){
			echo 'Not inserted <br>';
		}
		else{
			echo 'Data inserted successfully <br>';
		}


		//Reset or increase
		if($imgIndex + 1 >= sizeof($img)){
			$artIndex++;
			$imgIndex = 0;
		} 
		else{
			$imgIndex++;
		}

		//Save indexes
		$sql = "UPDATE `save` SET `artIndex`='$artIndex',`imgIndex`='$imgIndex' WHERE `username`='$username' AND `section`='$section'";
		mysqli_query($db,$sql);

		header('location: index.php');
	}
	
	
?>