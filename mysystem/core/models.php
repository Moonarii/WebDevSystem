<?php  
require_once 'dbConfig.php';

function insertWebDev($pdo, $username, $first_name, $last_name, 
	$date_of_birth, $specialization) {

	$sql = "INSERT INTO web_developers (username, first_name, last_name, 
		date_of_birth, specialization) VALUES(?,?,?,?,?)";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$username, $first_name, $last_name, 
		$date_of_birth, $specialization]);

	if ($executeQuery) {
		return true;
	}
}



function updateWebDev($pdo, $first_name, $last_name, 
	$date_of_birth, $specialization, $web_dev_id) {

	$sql = "UPDATE web_developers
				SET first_name = ?,
					last_name = ?,
					date_of_birth = ?, 
					specialization = ?
				WHERE web_dev_id = ?
			";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$first_name, $last_name, 
		$date_of_birth, $specialization, $web_dev_id]);
	
	if ($executeQuery) {
		return true;
	}

}


function deleteWebDev($pdo, $web_dev_id) {
	$deleteWebDevProj = "DELETE FROM projects WHERE web_dev_id = ?";
	$deleteStmt = $pdo->prepare($deleteWebDevProj);
	$executeDeleteQuery = $deleteStmt->execute([$web_dev_id]);

	if ($executeDeleteQuery) {
		$sql = "DELETE FROM web_developers WHERE web_dev_id = ?";
		$stmt = $pdo->prepare($sql);
		$executeQuery = $stmt->execute([$web_dev_id]);

		if ($executeQuery) {
			return true;
		}

	}
	
}




function getAllWebDevs($pdo) {
	$sql = "SELECT * FROM web_developers";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();

	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

function getWebDevByID($pdo, $web_dev_id) {
	$sql = "SELECT * FROM web_developers WHERE web_dev_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$web_dev_id]);

	if ($executeQuery) {
		return $stmt->fetch();
	}
}





function getProjectsByWebDev($pdo, $web_dev_id) {
	
	$sql = "SELECT 
				projects.project_id AS project_id,
				projects.project_name AS project_name,
				projects.technologies_used AS technologies_used,
				projects.date_added AS date_added,
				CONCAT(web_developers.first_name,' ',web_developers.last_name) AS project_owner
			FROM projects
			JOIN web_developers ON projects.web_dev_id = web_developers.web_dev_id
			WHERE projects.web_dev_id = ? 
			GROUP BY projects.project_name;
			";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$web_dev_id]);
	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}


function insertProject($pdo, $project_name, $technologies_used, $web_dev_id) {
	$sql = "INSERT INTO projects (project_name, technologies_used, web_dev_id) VALUES (?,?,?)";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$project_name, $technologies_used, $web_dev_id]);
	if ($executeQuery) {
		return true;
	}

}

function getProjectByID($pdo, $project_id) {
	$sql = "SELECT 
				projects.project_id AS project_id,
				projects.project_name AS project_name,
				projects.technologies_used AS technologies_used,
				projects.date_added AS date_added,
				CONCAT(web_developers.first_name,' ',web_developers.last_name) AS project_owner
			FROM projects
			JOIN web_developers ON projects.web_dev_id = web_developers.web_dev_id
			WHERE projects.project_id  = ? 
			GROUP BY projects.project_name";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$project_id]);
	if ($executeQuery) {
		return $stmt->fetch();
	}
}

function updateProject($pdo, $project_name, $technologies_used, $project_id) {
	$sql = "UPDATE projects
			SET project_name = ?,
				technologies_used = ?
			WHERE project_id = ?
			";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$project_name, $technologies_used, $project_id]);

	if ($executeQuery) {
		return true;
	}
}

function deleteProject($pdo, $project_id) {
	$sql = "DELETE FROM projects WHERE project_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$project_id]);
	if ($executeQuery) {
		return true;
	}
}




function insertNewUser($pdo, $username, $password) {

	$checkUserSql = "SELECT * FROM user_passwords WHERE username = ?";
	$checkUserSqlStmt = $pdo->prepare($checkUserSql);
	$checkUserSqlStmt->execute([$username]);

	if ($checkUserSqlStmt->rowCount() == 0) {

		$sql = "INSERT INTO user_passwords (username,password) VALUES(?,?)";
		$stmt = $pdo->prepare($sql);
		$executeQuery = $stmt->execute([$username, $password]);

		if ($executeQuery) {
			$_SESSION['message'] = "User successfully inserted";
			return true;
		}

		else {
			$_SESSION['message'] = "An error occured from the query";
		}

	}
	else {
		$_SESSION['message'] = "User already exists";
	}

	
}



function loginUser($pdo, $username, $password) {
	$sql = "SELECT * FROM user_passwords WHERE username=?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$username]); 

	if ($stmt->rowCount() == 1) {
		$userInfoRow = $stmt->fetch();
		$usernameFromDB = $userInfoRow['username']; 
		$passwordFromDB = $userInfoRow['password'];

		if ($password == $passwordFromDB) {
			$_SESSION['username'] = $usernameFromDB;
			$_SESSION['message'] = "Login successful!";
			return true;
		}

		else {
			$_SESSION['message'] = "Password is invalid, but user exists";
		}
	}

	
	if ($stmt->rowCount() == 0) {
		$_SESSION['message'] = "Username doesn't exist from the database. You may consider registration first";
	}

}

function getAllUsers($pdo) {
	$sql = "SELECT * FROM user_passwords";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();

	if ($executeQuery) {
		return $stmt->fetchAll();
	}

}

function getUserByID($pdo, $user_id) {
	$sql = "SELECT * FROM user_passwords WHERE user_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$user_id]);
	if ($executeQuery) {
		return $stmt->fetch();
	}
}


?>