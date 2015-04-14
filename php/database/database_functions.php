<?php
include_once 'configuration.php';

function getFreelancerBySkillAndLocation($skid, $level) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT DISTINCT freelancers.* from freelancers inner join freelancer_skill on freelancers.id = freelancer_skill.skill_id where freelancer_skill.skill_id = :id and freelancers.level>=:fl ORDER BY freelancers.id");
		$query->bindValue(":id", $skid);
		$query->bindValue(":fl", $level);
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    array_push($arr, $row);
		return $arr;
	} catch (Exception $e) {
		echo($e->getMessage());
		die();
		return array();
	}
}

function notifyAboutJob($skill, $lv, $jid) {
	$freelancers = getFreelancerBySkillAndLocation($skill, $lv);

	foreach ($freelancers as $freelancer) {
		$to = $freelancer['email'];
		$subject = "New Job!";
		$txt = "There is a new job matching your skill. Check it out http://devground.cf/freelancer/job.php?id=".$jid;
		$headers = "From: notification@devground.cf";

		mail($to,$subject,$txt,$headers);
	}
}

function getFreelancerSkills($id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT skills.id from skills inner join freelancer_skill on skills.id = freelancer_skill.skill_id where freelancer_skill.freelancer_id = :id");
		$query->bindValue(":id", $id);
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    array_push($arr, $row['id']);

		return $arr;
	} catch (Exception $e) {
		echo($e->getMessage());
		die();
		return array();
	}
}

function uppayForJob($id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$STH = $DBH->prepare("UPDATE `jobs` SET `payedfor`=:name WHERE `id`=:id");
		$STH->bindValue(":id", $id);
		$STH->bindValue(":name", "0");

        $STH->execute();
		return true;
	} catch (Exception $e) {
		return -1;
	}
}

function payForJob($id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$STH = $DBH->prepare("UPDATE `jobs` SET `payedfor`=:name WHERE `id`=:id");
		$STH->bindValue(":id", $id);
		$STH->bindValue(":name", "1");

        $STH->execute();
		return true;
	} catch (Exception $e) {
		return -1;
	}
}

function getSupplierFor($toc, $lid) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT * from suppliers where type_of_company = :toc and location = :lid");
		$query->bindValue(":toc", $toc);
		$query->bindValue(":lid", $lid);
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    return $row;

		return $arr;
	} catch (Exception $e) {
		return array();
	}
}

function updateJobName($id, $name) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$STH = $DBH->prepare("UPDATE `jobs` SET `name`=:name WHERE `id`=:id");
		$STH->bindValue(":id", $id);
		$STH->bindValue(":name", $name);

        $STH->execute();
		return true;
	} catch (Exception $e) {
		return -1;
	}
}

function clearSubmissions($id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$STH = $DBH->prepare("DELETE `submissions` WHERE `id`=:id");
		$STH->bindValue(":id", $id);

        $STH->execute();
		return true;
	} catch (Exception $e) {
		return -1;
	}
}

function clearFile($id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$STH = $DBH->prepare("UPDATE `submissions` SET `file`=:f WHERE `id`=:id");
		$STH->bindValue(":id", $id);
		$STH->bindValue(":f", "");

        $STH->execute();
		return true;
	} catch (Exception $e) {
		return -1;
	}
}

function getSubmissions($id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT * from submissions where job_id = :id");
		$query->bindValue(":id", $id);
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    return $row;

		return $arr;
	} catch (Exception $e) {
		return array();
	}
}

function getCards($id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT DISTINCT jobs.* from jobs inner join card_jobs on jobs.id=card_jobs.job_id inner join cards on cards.id=card_jobs.shit_id inner join freelancer_skill on cards.skill_id = freelancer_skill.skill_id where jobs.state = :s and freelancer_skill.freelancer_id=:id ORDER BY jobs.id");
		//inner join presentations on presentations.id=presentation_jobs.shit_id inner join freelancer_skill on presentations.skill = freelancer_skill.skill_id where jobs.state = :s and freelancer_skill.freelancer_id=:fid
		$query->bindValue(":id", $id);
		$query->bindValue(":s", "1");
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    array_push($arr, $row);

		return $arr;
	} catch (Exception $e) {
		echo($e->getMessage());
		die();
		return array();
	}
}

function getCustomShirts($id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT DISTINCT jobs.* from jobs inner join custom_shirt_jobs on jobs.id=custom_shirt_jobs.job_id inner join custom_shirts on custom_shirts.id=custom_shirt_jobs.shit_id inner join freelancer_skill on custom_shirts.skill_id = freelancer_skill.skill_id where jobs.state = :s and freelancer_skill.freelancer_id=:id ORDER BY jobs.id");
		//inner join presentations on presentations.id=presentation_jobs.shit_id inner join freelancer_skill on presentations.skill = freelancer_skill.skill_id where jobs.state = :s and freelancer_skill.freelancer_id=:fid
		$query->bindValue(":id", $id);
		$query->bindValue(":s", "1");
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    array_push($arr, $row);

		return $arr;
	} catch (Exception $e) {
		echo($e->getMessage());
		die();
		return array();
	}
}

function getPresentations($id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT DISTINCT jobs.* from jobs inner join presentation_jobs on jobs.id=presentation_jobs.job_id inner join presentations on presentations.id=presentation_jobs.shit_id inner join freelancer_skill on presentations.skill = freelancer_skill.skill_id where jobs.state = :s and freelancer_skill.freelancer_id=:id ORDER BY jobs.id");
		//inner join presentations on presentations.id=presentation_jobs.shit_id inner join freelancer_skill on presentations.skill = freelancer_skill.skill_id where jobs.state = :s and freelancer_skill.freelancer_id=:fid
		$query->bindValue(":id", $id);
		$query->bindValue(":s", "1");
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    array_push($arr, $row);

		return $arr;
	} catch (Exception $e) {
		echo($e->getMessage());
		die();
		return array();
	}
}


function updatePresentation($id, $name, $file, $image, $skill, $level, $price, $instructions_freelancer, $instructions_team, $instructions_supplier, $ex, $ct, $location_id) {
		try {
		$DBH = Configuration::getInstance()->getDBH();

		$STH = $DBH->prepare("UPDATE `presentations` SET `name`=:name, `file`=:file, `image`=:image, `skill`=:skill, `level`=:level, `price`=:price, `instructions_freelancer`=:instructions_freelancer, `instructions_team`=:instructions_team, `instructions_supplier`=:instructions_supplier, `example`=:ex, `content_template`=:ct, `location_id`=:location_id WHERE id=:id");
        $STH->bindValue(":id", $id);
        $STH->bindValue(":location_id", $location_id);
        $STH->bindValue(":name", $name);
		$STH->bindValue(":file", $file);
		$STH->bindValue(":image", $image);
		$STH->bindValue(":skill", $skill);
		$STH->bindValue(":level", $level);
		$STH->bindValue(":price", $price);
		$STH->bindValue(":instructions_freelancer", $instructions_freelancer);
		$STH->bindValue(":instructions_team", $instructions_team);
		$STH->bindValue(":instructions_supplier", $instructions_supplier);
		$STH->bindValue(":ex", $ex);
		$STH->bindValue(":ct", $ct);
        $STH->execute();
		return $DBH->lastInsertId('id');
	} catch (Exception $e) {
		echo($e->getMessage());
		die();
		return -1;
	}
}


function updateCard($id, $name, $file, $image, $skill_id, $level, $price, $instructions_freelancer, $instructions_team, $instructions_supplier, $loc_id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$STH = $DBH->prepare("UPDATE `cards` SET `name`=:name, `file`=:file, `image`=:image, `skill_id`=:skill_id, `level`=:level, `price`=:price, `instructions_freelancer`=:instructions_freelancer, `instructions_team`=:instructions_team, `instructions_supplier`=:instructions_supplier, `location_id`=:loc_id WHERE `id`=:id");
		$STH->bindValue(":id", $id);
		$STH->bindValue(":name", $name);
		$STH->bindValue(":file", $file);
		$STH->bindValue(":loc_id", $loc_id);
		$STH->bindValue(":image", $image);
		$STH->bindValue(":skill_id", $skill_id);
		$STH->bindValue(":level", $level);
		$STH->bindValue(":price", $price);
		$STH->bindValue(":instructions_freelancer", $instructions_freelancer);
		$STH->bindValue(":instructions_team", $instructions_team);
		$STH->bindValue(":instructions_supplier", $instructions_supplier);

        $STH->execute();
		return $DBH->lastInsertId('id');
	} catch (Exception $e) {
		echo($e->getMessage());
		die();
		return -1;
	}
}

function updateShirt($id, $name, $location_id, $file, $image, $color_id, $instructions_freelancer, $instructions_team, $instructions_supplier) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$STH = $DBH->prepare("UPDATE `shirts` SET `name`=:name, `location_id`=:location_id, `file`=:file, `image`=:image, `color_id`=:color_id, `instructions_freelancer`=:instructions_freelancer, `instructions_team`=:instructions_team, `instructions_supplier`=:instructions_supplier WHERE `id`=:id");
		$STH->bindValue(":id", $id);
		$STH->bindValue(":name", $name);
		$STH->bindValue(":location_id", $location_id);
		$STH->bindValue(":file", $file);
		$STH->bindValue(":image", $image);
		$STH->bindValue(":color_id", $color_id);
		$STH->bindValue(":instructions_freelancer", $instructions_freelancer);
		$STH->bindValue(":instructions_team", $instructions_team);
		$STH->bindValue(":instructions_supplier", $instructions_supplier);

        $STH->execute();
		return $DBH->lastInsertId('id');
	} catch (Exception $e) {
		return -1;
	}
}

function updateCustomShirt($id, $name, $location_id, $template_file, $thumbnail, $skill_id, $level, $price, $instructions_freelancer, $instructions_team, $instructions_supplier) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$STH = $DBH->prepare("UPDATE `custom_shirts` SET `name`=:name, `location_id`=:location_id, `template_file`=:template_file, `thumbnail`=:thumbnail, `skill_id`=:skill_id, `level`=:level, `price`=:price, `instructions_freelancer`=:instructions_freelancer, `instructions_team`=:instructions_team, `instructions_supplier`=:instructions_supplier WHERE `id`=:id");
		$STH->bindValue(":id", $id);
		$STH->bindValue(":name", $name);
		$STH->bindValue(":location_id", $location_id);
		$STH->bindValue(":template_file", $template_file);
		$STH->bindValue(":thumbnail", $thumbnail);
		$STH->bindValue(":skill_id", $skill_id);
		$STH->bindValue(":level", $level);
		$STH->bindValue(":price", $price);
		$STH->bindValue(":instructions_freelancer", $instructions_freelancer);
		$STH->bindValue(":instructions_team", $instructions_team);
		$STH->bindValue(":instructions_supplier", $instructions_supplier);
        $STH->execute();
		return $DBH->lastInsertId('id');
	} catch (Exception $e) {
		return -1;
	}
}


function getShirtShit($id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT * from shirts where id = :id");
		$query->bindValue(":id", $id);
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    return $row;

		return $arr;
	} catch (Exception $e) {
		return array();
	}
}

function getCustomShirtShit($id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT * from custom_shirts where id = :id");
		$query->bindValue(":id", $id);
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    return $row;

		return $arr;
	} catch (Exception $e) {
		return array();
	}
}

function getPresentationShit($id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT * from presentations where id = :id");
		$query->bindValue(":id", $id);
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    return $row;

		return $arr;
	} catch (Exception $e) {
		return array();
	}
}

function getCardShit($id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT * from cards where id = :id");
		$query->bindValue(":id", $id);
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    return $row;

		return $arr;
	} catch (Exception $e) {
		return array();
	}
}

function updateJobType($id, $val) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("UPDATE jobs SET type=:s WHERE id=:id");
		$query->bindValue(":id", $id);
		$query->bindValue(":s", $val);
        $query->execute();
		return true;
	} catch (Exception $e) {
		echo ($e->getMessage());
		die();
		return false;
	}
}

function getFreelancerById($id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT * from freelancers where id = :id");
		$query->bindValue(":id", $id);
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    return $row;

		return $arr;
	} catch (Exception $e) {
		return array();
	}
}
function getManagerById($id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT * from managers where id = :id");
		$query->bindValue(":id", $id);
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    return $row;

		return $arr;
	} catch (Exception $e) {
		return array();
	}
}

function updateManager($id, $first_name, $last_name, $location, $email, $skype, $position, $password) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$STH = $DBH->prepare("UPDATE `managers` SET `first_name`=:fn,`last_name`=:ln,`location_id`=:loc,`email`=:e,`skype`=:s,`position`=:pos,`password`=:pas,`blocked`=:bl WHERE id=:id");
		$STH->bindValue(":id", $id);
        $STH->bindValue(":fn", $first_name);
        $STH->bindValue(":ln", $last_name);
        $STH->bindValue(":loc", $location);
        $STH->bindValue(":e", $email);
        $STH->bindValue(":s", $skype);
        $STH->bindValue(":pos", $position);
        $STH->bindValue(":pas", $password);
        $STH->bindValue(":bl", "0");
        $STH->execute();
		return $DBH->lastInsertId('id');
	} catch (Exception $e) {
		return -1;
	}
}

function updateFreelancer($id, $name, $level, $timezone, $skype, $password, $email) {
	try {
		$DBH = Configuration::getInstance()->getDBH();
		$STH = $DBH->prepare("UPDATE freelancers SET `name`=:n, `level`=:l, `timezone`=:tz, `skype`=:s, `password`=:p, `blocked`=:bl, `email`=:e where id=:id");
		$STH->bindValue(":id", $id);
		$STH->bindValue(":n", $name);
		$STH->bindValue(":l", $level);
		$STH->bindValue(":tz", $timezone);
		$STH->bindValue(":s", $skype);
		$STH->bindValue(":p", $password);
		$STH->bindValue(":bl", "0");
		$STH->bindValue(":e", $email);
		$STH->execute();
		return $DBH->lastInsertId('id');
	} catch (Exception $e) {
		return -1;
	}  	
}

function removeFreelancerSkills($id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();
		$query = $DBH->prepare("DELETE FROM skills where freelancer_id = :id");

		$query->bindValue(":id", $id);

        $query->execute();
        return true;
    } catch (Exception $e) {
    	return false;
    }
}

function getAllCustomShirtShit($id) {
		try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT * from custom_shirts where id = :id");
		$query->bindValue(":id", $id);
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    return $row;

		return $arr;
	} catch (Exception $e) {
		return array();
	}
}

function getAllShirtShit($id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT * from shirts where id = :id");
		$query->bindValue(":id", $id);
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    return $row;

		return $arr;
	} catch (Exception $e) {
		return array();
	}
}

function getAllCardShit($id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT * from cards where id = :id");
		$query->bindValue(":id", $id);
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    return $row;

		return $arr;
	} catch (Exception $e) {
		return array();
	}
}

function updateJobState($id, $state) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("UPDATE jobs SET state=:s WHERE id=:id");
		$query->bindValue(":id", $id);
		$query->bindValue(":s", $state);
        $query->execute();
		return true;
	} catch (Exception $e) {
		echo ($e->getMessage());
		die();
		return false;
	}
}

function addCardJob($shit_id, $name, $title, $phone, $email, $photo, $how_many, $current_card_design, $job_id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$STH = $DBH->prepare("INSERT INTO `card_jobs` (`id`, `shit_id`, `name`, `title`, `phone`, `email`, `photo`, `how_many`, `current_card_design`, `job_id`) VALUES (NULL, :shit_id, :name, :title, :phone, :email, :photo, :how_many, :current_card_design, :jid);");
		$STH->bindValue(":shit_id", $shit_id);
		$STH->bindValue(":jid", $job_id);
		$STH->bindValue(":name", $name);
		$STH->bindValue(":title", $title);
		$STH->bindValue(":phone", $phone);
		$STH->bindValue(":email", $email);
		$STH->bindValue(":photo", $photo);
		$STH->bindValue(":how_many", $how_many);
		$STH->bindValue(":current_card_design", $current_card_design);
        $STH->execute();
		return $DBH->lastInsertId('id');
	} catch (Exception $e) {
		echo($e->getMessage());
		die();
		return -1;
	}
}

function addShirtJob($shit_id, $size, $how_many, $style, $jobId) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$STH = $DBH->prepare("INSERT INTO `shirt_jobs` (`id`, `shit_id`, `size`, `how_many`, `style`, `job_id`) VALUES (NULL, :shit_id, :size, :how_many, :style, :job_id);");
		$STH->bindValue(":job_id", $jobId);
		$STH->bindValue(":shit_id", $shit_id);
		$STH->bindValue(":size", $size);
		$STH->bindValue(":how_many", $how_many);
		$STH->bindValue(":style", $style);
        $STH->execute();
		return $DBH->lastInsertId('id');
	} catch (Exception $e) {
		echo($e->getMessage());
		die();
		return -1;
	}
}

function addCustomShirtJob($shit_id, $size, $how_many, $color_id, $style, $logo_color_id, $jobId, $photo_loc) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$STH = $DBH->prepare("INSERT INTO `custom_shirt_jobs` (`id`, `shit_id`, `size`, `how_many`, `color_id`, `style`, `logo_color_id`, `job_id`, `photo_loc`) VALUES (NULL, :shit_id,:size, :how_many, :color_id, :style, :logo_color_id, :job_id, :photo_loc);");
		$STH->bindValue(":job_id", $jobId);
		$STH->bindValue(":photo_loc", $photo_loc);
		$STH->bindValue(":shit_id", $shit_id);
		$STH->bindValue(":size", $size);
		$STH->bindValue(":how_many", $how_many);
		$STH->bindValue(":color_id", $color_id);
		$STH->bindValue(":style", $style);
		$STH->bindValue(":logo_color_id", $logo_color_id);
        $STH->execute();
		return $DBH->lastInsertId('id');
	} catch (Exception $e) {
		echo($e->getMessage());
		die();
		return -1;
	}
}

function getAllPresentationShit($id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT * from presentations where id = :id");
		$query->bindValue(":id", $id);
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    return $row;

		return $arr;
	} catch (Exception $e) {
		return array();
	}
}

function getAllCSJ($id) {
	try {

		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT * from custom_shirt_jobs where job_id = :id");
		
		$query->bindValue(":id", $id);
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    array_push($arr, $row);

		return $arr;
	} catch (Exception $e) {
		echo($e->getMessage());
		die();
		return array();
	}
}



function getAllSJ($id) {
	try {

		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT * from shirt_jobs where job_id = :id");
		
		$query->bindValue(":id", $id);
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    array_push($arr, $row);

		return $arr;
	} catch (Exception $e) {
		echo($e->getMessage());
		die();
		return array();
	}
}


function getAllCJ($id) {
	try {

		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT * from card_jobs where job_id = :id");
		
		$query->bindValue(":id", $id);
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    array_push($arr, $row);

		return $arr;
	} catch (Exception $e) {
		echo($e->getMessage());
		die();
		return array();
	}
}

function getAllPJ($id) {
	try {

		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT * from presentation_jobs where job_id = :id");
		
		$query->bindValue(":id", $id);
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    array_push($arr, $row);

		return $arr;
	} catch (Exception $e) {
		echo($e->getMessage());
		die();
		return array();
	}
}

function addPresentationJob($job_id, $shit_id, $brand, $content_link, $folder, $has_graphics) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$STH = $DBH->prepare("INSERT INTO `presentation_jobs` (`id`, `job_id`, `shit_id`, `brand`, `content_link`, `folder`, `has_graphics`) VALUES (NULL, :job_id, :shit_id, :brand, :content_link, :folder, :has_graphics);");
		$STH->bindValue(":job_id", $job_id);
		$STH->bindValue(":has_graphics", $has_graphics);
		$STH->bindValue(":shit_id", $shit_id);
		$STH->bindValue(":brand", $brand);
		$STH->bindValue(":content_link", $content_link);
		$STH->bindValue(":folder", $folder);
        $STH->execute();
		return $DBH->lastInsertId('id');
	} catch (Exception $e) {
		echo($e->getMessage());
		die();
		return -1;
	}
}

function addCustomShirt($name, $location_id, $template_file, $thumbnail, $skill_id, $level, $price, $instructions_freelancer, $instructions_team, $instructions_supplier) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$STH = $DBH->prepare("INSERT INTO `custom_shirts` (`id`, `name`, `location_id`, `template_file`, `thumbnail`, `skill_id`, `level`, `price`, `instructions_freelancer`, `instructions_team`, `instructions_supplier`) VALUES (NULL, :name, :location_id, :template_file, :thumbnail, :skill_id, :level, :price, :instructions_freelancer, :instructions_team, :instructions_supplier);");
		$STH->bindValue(":name", $name);
		$STH->bindValue(":location_id", $location_id);
		$STH->bindValue(":template_file", $template_file);
		$STH->bindValue(":thumbnail", $thumbnail);
		$STH->bindValue(":skill_id", $skill_id);
		$STH->bindValue(":level", $level);
		$STH->bindValue(":price", $price);
		$STH->bindValue(":instructions_freelancer", $instructions_freelancer);
		$STH->bindValue(":instructions_team", $instructions_team);
		$STH->bindValue(":instructions_supplier", $instructions_supplier);
        $STH->execute();
		return $DBH->lastInsertId('id');
	} catch (Exception $e) {
		return -1;
	}
}

function addLocation($name) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$STH = $DBH->prepare("INSERT INTO `locations` (`id`, `name`) VALUES (NULL, :n);");
        $STH->bindValue(":n", $name);
        $STH->execute();
		return $DBH->lastInsertId('id');
	} catch (Exception $e) {
		return -1;
	}
}


function addColor($name) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$STH = $DBH->prepare("INSERT INTO `colors` (`id`, `name`) VALUES (NULL, :n);");
        $STH->bindValue(":n", $name);
        $STH->execute();
		return $DBH->lastInsertId('id');
	} catch (Exception $e) {
		return -1;
	}
}


function addCard($name, $file, $image, $skill_id, $level, $price, $instructions_freelancer, $instructions_team, $instructions_supplier, $location_id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$STH = $DBH->prepare("INSERT INTO `cards`(`id`, `name`, `file`, `image`, `skill_id`, `level`, `price`, `instructions_freelancer`, `instructions_team`, `instructions_supplier`, `location_id`) VALUES (NULL, :name, :file, :image, :skill_id, :level, :price, :instructions_freelancer, :instructions_team, :instructions_supplier, :loc_id)");
		$STH->bindValue(":name", $name);
		$STH->bindValue(":file", $file);
		$STH->bindValue(":image", $image);
		$STH->bindValue(":skill_id", $skill_id);
		$STH->bindValue(":level", $level);
		$STH->bindValue(":loc_id", $location_id);
		$STH->bindValue(":price", $price);
		$STH->bindValue(":instructions_freelancer", $instructions_freelancer);
		$STH->bindValue(":instructions_team", $instructions_team);
		$STH->bindValue(":instructions_supplier", $instructions_supplier);

        $STH->execute();
		return $DBH->lastInsertId('id');
	} catch (Exception $e) {
		echo($e->getMessage());
		die();
		return -1;
	}
}

function addShirt($name, $location_id, $file, $image, $color_id, $instructions_freelancer, $instructions_team, $instructions_supplier) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$STH = $DBH->prepare("INSERT INTO `shirts`(`id`, `name`, `location_id`, `file`, `image`, `color_id`, `instructions_freelancer`, `instructions_team`, `instructions_supplier`) VALUES (NULL, :name, :location_id, :file, :image, :color_id, :instructions_freelancer, :instructions_team, :instructions_supplier)");
		$STH->bindValue(":name", $name);
		$STH->bindValue(":location_id", $location_id);
		$STH->bindValue(":file", $file);
		$STH->bindValue(":image", $image);
		$STH->bindValue(":color_id", $color_id);
		$STH->bindValue(":instructions_freelancer", $instructions_freelancer);
		$STH->bindValue(":instructions_team", $instructions_team);
		$STH->bindValue(":instructions_supplier", $instructions_supplier);

        $STH->execute();
		return $DBH->lastInsertId('id');
	} catch (Exception $e) {
		return -1;
	}
}

function addPresentation($name, $file, $image, $skill, $level, $price, $instructions_freelancer, $instructions_team, $instructions_supplier, $ex, $ct, $location_id) {
		try {
		$DBH = Configuration::getInstance()->getDBH();

		$STH = $DBH->prepare("INSERT INTO `presentations`(`id`, `name`, `file`, `image`, `skill`, `level`, `price`, `instructions_freelancer`, `instructions_team`, `instructions_supplier`, `example`, `content_template`, `location_id`) VALUES (NULL, :name, :file, :image, :skill, :level, :price, :instructions_freelancer, :instructions_team, :instructions_supplier, :ex, :ct, :location_id)");
        $STH->bindValue(":name", $name);
        $STH->bindValue(":location_id", $location_id);
		$STH->bindValue(":file", $file);
		$STH->bindValue(":image", $image);
		$STH->bindValue(":skill", $skill);
		$STH->bindValue(":level", $level);
		$STH->bindValue(":price", $price);
		$STH->bindValue(":instructions_freelancer", $instructions_freelancer);
		$STH->bindValue(":instructions_team", $instructions_team);
		$STH->bindValue(":instructions_supplier", $instructions_supplier);
		$STH->bindValue(":ex", $ex);
		$STH->bindValue(":ct", $ct);
        $STH->execute();
		return $DBH->lastInsertId('id');
	} catch (Exception $e) {
		echo($e->getMessage());
		die();
		return -1;
	}
}

function getAllJobs() {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT * from jobs where state!=0 order by freelancer_id asc");
		$query->bindValue(":fid", "-1");
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    array_push($arr, $row);

		return $arr;
	} catch (Exception $e) {
		return array();
	}
}
function getAllJobsByF() {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT * from jobs where freelancer_id!=:fid and state!=0 order by freelancer_id asc");
		$query->bindValue(":fid", "-1");
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    array_push($arr, $row);

		return $arr;
	} catch (Exception $e) {
		echo ($e->getMessage());
		die();
		return array();
	}
}
function getAll($tableName) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT * from ".$tableName);
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    array_push($arr, $row);

		return $arr;
	} catch (Exception $e) {
		echo ($e->getMessage());
		die();
		return array();
	}
}
function dayz($dd) {
	$now = time();
    $your_date = strtotime($dd);
    $seconds = $your_date-$now;
    //return $datediff;

		$months = floor($seconds / (3600*24*30));
        $day = floor($seconds / (3600*24));
        $hours = floor($seconds / 3600);
        $mins = floor(($seconds - ($hours*3600)) / 60);
        $secs = floor($seconds % 60);

    return $day;
}
function hourz($dd) {
	$now = time();
    $your_date = strtotime($dd);
    $seconds = $your_date-$now;
    //return $datediff;

		$months = floor($seconds / (3600*24*30));
        $day = floor($seconds / (3600*24));
        $hours = floor($seconds / 3600 - $day*24);
        $mins = floor(($seconds - ($hours*3600)) / 60);
        $secs = floor($seconds % 60);

    return $hours;
}

function minz($dd) {
	$now = time();
    $your_date = strtotime($dd);
    $seconds = $your_date-$now;
    //return $datediff;

		$months = floor($seconds / (3600*24*30));
        $day = floor($seconds / (3600*24));
        $hours = floor($seconds / 3600);
        $mins = floor(($seconds - ($hours*3600)) / 60);
        $secs = floor($seconds % 60);

    return $mins;
}

function secz($dd) {
	$now = time();
    $your_date = strtotime($dd);
    $seconds = $your_date-$now;
    //return $datediff;

		$months = floor($seconds / (3600*24*30));
        $day = floor($seconds / (3600*24));
        $hours = floor($seconds / 3600);
        $mins = floor(($seconds - ($hours*3600)) / 60);
        $secs = floor($seconds % 60);

    return $secs;
}



function addJob($type, $name, $creator_id, $due_date, $freelancer_id, $state, $location) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$STH = $DBH->prepare("INSERT INTO `jobs` (`id`, `password`, `type`,`name`, `creator_id`, `due_date`, `freelancer_id`, `state`, `location_id`, `payedfor`) 
		VALUES (NULL, :password, :type, :name, :creator_id, :due_date, :freelancer_id, :state, :location_id, :pf);");
       	$STH->bindValue(":location_id", $location);
       	$STH->bindValue(":pf", "0");
       	$STH->bindValue(":name", $name);
       	$STH->bindValue(":type", $type);



       	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < 10; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    $randomString;

       	$STH->bindValue(":password", $randomString);
		$STH->bindValue(":creator_id", $creator_id);
		$STH->bindValue(":due_date", $due_date->format("Y-m-d H:i:s"));
		$STH->bindValue(":freelancer_id", $freelancer_id);
		$STH->bindValue(":state", $state);
        $STH->execute();
		return $DBH->lastInsertId('id');
	} catch (Exception $e) {
		echo($e->getMessage());
		die();
		return -1;
	}
}

function getActiveJobsWithSkill($freelancerId) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT jobs.* from jobs inner join freelancer_skill on jobs.skill_id = freelancer_skill.skill_id where jobs.state = :s and freelancer_skill.freelancer_id=:fid");
		$query->bindValue(":fid", $freelancerId);
		$query->bindValue(":s", "1");
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    array_push($arr, $row);

		return $arr;
	} catch (Exception $e) {
		return array();
	}
}

function getActiveJobs() {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT * from jobs where state = :s");
		$query->bindValue(":s", "1");
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    array_push($arr, $row);

		return $arr;
	} catch (Exception $e) {
		return array();
	}
}

function submitJob($jobId, $submission, $file) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		//$query = $DBH->prepare("UPDATE jobs SET finished=:f, state=:s WHERE id=:id");
		$query = $DBH->prepare("UPDATE jobs SET state=:s WHERE id=:id");
		$query->bindValue(":id", $jobId);
		$query->bindValue(":s", "3");
        $query->execute();

		$STH = $DBH->prepare("INSERT INTO `submissions` (`id`, `text`, `file`, `job_id`) VALUES (NULL, :t, :f, :id);");
		$STH->bindValue(":id", $jobId);
		$STH->bindValue(":t", $submission);
		$STH->bindValue(":f", $file);
        $STH->execute();
        
		return true;
	} catch (Exception $e) {
		echo ($e->getMessage());
		die();
		return false;
	}
}

function rejectJob($jobId) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("UPDATE jobs SET state=:s WHERE id=:id");
		$query->bindValue(":id", $jobId);
		$query->bindValue(":s", "2");
        $query->execute();
		return true;
	} catch (Exception $e) {
		echo ($e->getMessage());
		die();
		return false;
	}
}

function approveJob($jobId) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("UPDATE jobs SET state=:s WHERE id=:id");
		$query->bindValue(":id", $jobId);
		$query->bindValue(":s", "4");
        $query->execute();
		return true;
	} catch (Exception $e) {
		echo($e->getMessage());
		return false;
	}
}

function acceptJob($jobId, $freelancerId) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("UPDATE jobs SET freelancer_id=:fid, state=:s WHERE id=:id");
		$query->bindValue(":id", $jobId);
		$query->bindValue(":fid", $freelancerId);
		$query->bindValue(":s", "2");
        $query->execute();
		return true;
	} catch (Exception $e) {
		echo ($e->getMessage());
		die();
		return false;
	}
}

function getJob($id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT * from jobs where id = :id");
		$query->bindValue(":id", $id);
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    return $row;

		return $arr;
	} catch (Exception $e) {
		return array();
	}
}

function getJobsByFreelancer($id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT * from jobs where freelancer_id = :id");
		$query->bindValue(":id", $id);
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    array_push($arr, $row);

		return $arr;
	} catch (Exception $e) {
		return array();
	}
}
function getManagerNameById($id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT first_name, last_name, id from managers where id = :id");
		$query->bindValue(":id", $id);
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    return $row['first_name']." ".$row['last_name'];

		return "";
	} catch (Exception $e) {
		return "";
	}
}
function getFreeLancerNameById($id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT name from freelancers where id = :id");
		$query->bindValue(":id", $id);
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    return $row['name'];

		return "";
	} catch (Exception $e) {
		return "";
	}
}

function getJobsByManager($id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT * from jobs where creator_id = :id");
		$query->bindValue(":id", $id);
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    array_push($arr, $row);

		return $arr;
	} catch (Exception $e) {
		return array();
	}
}

function addFreelancerSkill($freelancerId, $skillId) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$STH = $DBH->prepare("INSERT INTO `freelancer_skill` (`id`, `freelancer_id`, `skill_id`) VALUES (NULL, :f, :s);");
        $STH->bindValue(":f", $freelancerId);
        $STH->bindValue(":s", $skillId);
        $STH->execute();
		return $DBH->lastInsertId('id');
	} catch (Exception $e) {
		echo($e->getMessage());
		die();
		return -1;
	}
}

function getJobRealPrice($job) {
	$price = 0;
	if ($job['type']==="1") {
		$orders = getAllPJ($job['id']);
	} else if ($job['type']==="2") {
		$orders = getAllCJ($job['id']);
	} else if ($job['type']==="3") {
		$orders = getAllSJ($job['id']);
	} else if ($job['type']==="4") { 
		$orders = getAllCSJ($job['id']);
	}
	foreach ($orders as $order) { 
		if ($job['type']==="1") {
			$shit = getAllPresentationShit($order['shit_id']);
			$price += substr($shit['price'], 0, strspn($shit['price'], "0123456789"));
		}

		if ($job['type']==="2") {
			$shit = getAllCardShit($order['shit_id']);
			$price += substr($shit['price'], 0, strspn($shit['price'], "0123456789"));
		}

		if ($job['type']==="3") {
			$shit = getAllShirtShit($order['shit_id']);
			$price += substr($shit['price'], 0, strspn($shit['price'], "0123456789"));
		}

		if ($job['type']==="4") {
			$shit = getAllCustomShirtShit($order['shit_id']);
			$price += substr($shit['price'], 0, strspn($shit['price'], "0123456789"));
		}
	}
	return $price;
}


function updateSkill($id, $name) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$STH = $DBH->prepare("UPDATE `skills` SET name=:n where id=:id");
        $STH->bindValue(":n", $name);
        $STH->bindValue(":id", $id);
        $STH->execute();
		return true;
	} catch (Exception $e) {
		echo($e->getMessage());
		die();
		return -1;
	}
}

function addSkill($name) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$STH = $DBH->prepare("INSERT INTO `skills` (`id`, `name`) VALUES (NULL, :n);");
        $STH->bindValue(":n", $name);
        $STH->execute();
		return $DBH->lastInsertId('id');
	} catch (Exception $e) {
		return -1;
	}
}

function getLocationName($id) {
	if ($id==="-10")
		return "Global";
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT * from locations where id=:id");
		$query->bindValue(":id", $id);
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    return $row['name'];

		return $arr;
	} catch (Exception $e) {
		return array();
	}
}

function getColorName($id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT * from colors where id=:id");
		$query->bindValue(":id", $id);
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    return $row['name'];

		return "";
	} catch (Exception $e) {
		echo($e->getMessage());
		die();
		return array();
	}
}

function getSkillName($id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT * from skills where id=:id");
		$query->bindValue(":id", $id);
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    return $row['name'];

		return $arr;
	} catch (Exception $e) {
		echo($e->getMessage());
		die();
		return array();
	}
}

function getSkills() {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT * from skills");
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    array_push($arr, $row);

		return $arr;
	} catch (Exception $e) {
		echo($e->getMessage());
		die();
		return array();
	}
}

function getJobs() {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT * from jobs");
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    array_push($arr, $row);

		return $arr;
	} catch (Exception $e) {
		return array();
	}
}

function updateSupplier($company_name, $type_of_company, $email, $location, $id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$STH = $DBH->prepare("UPDATE `suppliers` SET company_name=:cn, type_of_company=:toc, email=:e, location=:ls where id=:id");
        $STH->bindValue(":cn", $company_name);
        $STH->bindValue(":toc", $type_of_company);
        $STH->bindValue(":e", $email);
        $STH->bindValue(":l", $location);
        $STH->bindValue(":id", $location);
        $STH->execute();
		return $DBH->lastInsertId('id');
	} catch (Exception $e) {
		return -1;
	}
}

function addSupplier($company_name, $type_of_company, $email, $location) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$STH = $DBH->prepare("INSERT INTO `suppliers` (`id`, `company_name`, `type_of_company`, `email`, `location`) VALUES (NULL, :cn, :toc, :e, :l);");
        $STH->bindValue(":cn", $company_name);
        $STH->bindValue(":toc", $type_of_company);
        $STH->bindValue(":e", $email);
        $STH->bindValue(":l", $location);
        $STH->execute();
		return $DBH->lastInsertId('id');
	} catch (Exception $e) {
		return -1;
	}
}

function getSupplier($id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT * from suppliers where id=:id");
		$STH->bindValue(":id", $id);
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    return $row;

		return array();
	} catch (Exception $e) {
		return array();
	}
}

function getSuppliers() {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT * from suppliers");
        $query->execute();

        $arr = array();
		
		while($row = $query->fetch())
		    array_push($arr, $row);

		return $arr;
	} catch (Exception $e) {
		return array();
	}
}


function isFreelancer($username, $password) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT email, password, id from freelancers where email=:e and password=:ps and blocked=:bl");
		$query->bindValue(":e", $username);
		$query->bindValue(":ps", $password);
		$query->bindValue(":bl", "0");
        $query->execute();
    	
		while($row = $query->fetch()) {
		
		    if ($row['email']==$username && $row['password']==$password) 
		    	return $row['id'];
		}
		return -1;
	} catch (Exception $e) {
		echo ($e->getMessage());
		die();
		return -1;
	}
}

function isManager($username, $password) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT email, password, id, blocked from managers where email=:e and password=:ps and blocked=:bl");
		$query->bindValue(":e", $username);
		$query->bindValue(":ps", $password);
		$query->bindValue(":bl", 0);
        $query->execute();
    	
		while($row = $query->fetch()) {
		
		    if ($row['email']==$username && $row['password']==$password) 
		    	return $row['id'];
		}
		return -1;
	} catch (Exception $e) {
		echo ($e->getMessage());
		die();
		return -1;
	}
}

/*function updateManager($first_name, $last_name, $location, $email, $skype, $position, $password, $id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$STH = $DBH->prepare("UPDATE `managers` SET first_name=:fn, last_name=:ln, location=:loc, email=:e, skype=:s, position=:pos, password=:pas, blocked=:bl where id=:id");
        $STH->bindValue(":fn", $first_name);
        $STH->bindValue(":ln", $last_name);
        $STH->bindValue(":loc", $location);
        $STH->bindValue(":e", $email);
        $STH->bindValue(":s", $skype);
        $STH->bindValue(":pos", $position);
        $STH->bindValue(":pas", $password);
        $STH->bindValue(":bl", "0");
        $STH->execute();
		return $DBH->lastInsertId('id');
	} catch (Exception $e) {
		return -1;
	}
}*/


function addManager($first_name, $last_name, $location, $email, $skype, $position, $password) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$STH = $DBH->prepare("INSERT INTO `managers` (`id`, `first_name`, `last_name`, `location_id`, `email`, `skype`, `position`, `password`, `blocked`) VALUES (NULL, :fn, :ln, :loc, :e, :s, :pos, :pas, :bl);");
        $STH->bindValue(":fn", $first_name);
        $STH->bindValue(":ln", $last_name);
        $STH->bindValue(":loc", $location);
        $STH->bindValue(":e", $email);
        $STH->bindValue(":s", $skype);
        $STH->bindValue(":pos", $position);
        $STH->bindValue(":pas", $password);
        $STH->bindValue(":bl", "0");
        $STH->execute();
		return $DBH->lastInsertId('id');
	} catch (Exception $e) {
		return -1;
	}
}

function getManagers() {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT * from managers");
        $query->execute();

        $arr = array();
		while($row = $query->fetch()) {
			//$toRet = new User($row['fullName'], $row['userName'],$row['password'],$row['email'],$row['birthday'],$row['sq1'],$row['sa1'],$row['sq2'],$row['sa2'],$row['sq3'],$row['sa3'], $row['admin'], $row['premium']);
			//$toRet->id = $row['id'];
		    array_push($arr, $row);
		}
		return $arr;
	} catch (Exception $e) {
		return array();
	}
}
/*
function updateFreelancer($name, $level, $timezone, $skype, $password, $id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$STH = $DBH->prepare("UPDATE freelancers SET name=:n, level=:l, timezone=:tz, skype=:s, password=:p, blocked=:bl where id=:id");
		$STH->bindValue(":n", $name);
		$STH->bindValue(":l", $level);
		$STH->bindValue(":tz", $timezone);
		$STH->bindValue(":s", $skype);
		$STH->bindValue(":p", $password);
		$STH->bindValue(":bl", "0");
		$STH->execute();
		return $DBH->lastInsertId('id');
	} catch (Exception $e) {
		return -1;
	}  	
}*/


function addFreelancer($name, $level, $timezone, $skype, $password, $email) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$STH = $DBH->prepare("INSERT INTO freelancers (`id`, `name`, `level`, `timezone`, `skype`, `password`, `blocked`, `email`) VALUES (NULL, :n, :l, :tz, :s, :p, :bl, :e)");
		$STH->bindValue(":n", $name);
		$STH->bindValue(":l", $level);
		$STH->bindValue(":tz", $timezone);
		$STH->bindValue(":s", $skype);
		$STH->bindValue(":p", $password);
		$STH->bindValue(":bl", "0");
		$STH->bindValue(":e", $email);
		$STH->execute();
		return $DBH->lastInsertId('id');
	} catch (Exception $e) {
		return -1;
	}  	
}

function getFreelancers() {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT * from freelancers");
        $query->execute();

        $arr = array();
		while($row = $query->fetch()) {
			//$toRet = new User($row['fullName'], $row['userName'],$row['password'],$row['email'],$row['birthday'],$row['sq1'],$row['sa1'],$row['sq2'],$row['sa2'],$row['sq3'],$row['sa3'], $row['admin'], $row['premium']);
			//$toRet->id = $row['id'];
		    array_push($arr, $row);
		}
		return $arr;
	} catch (Exception $e) {
		return array();
	}
}


function getAdmins() {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT username, password, id from admins");
        $query->execute();

        $arr = array();
		while($row = $query->fetch()) {
			//$toRet = new User($row['fullName'], $row['userName'],$row['password'],$row['email'],$row['birthday'],$row['sq1'],$row['sa1'],$row['sq2'],$row['sa2'],$row['sq3'],$row['sa3'], $row['admin'], $row['premium']);
			//$toRet->id = $row['id'];
		    array_push($arr, $row);
		}
		return $arr;
	} catch (Exception $e) {
		return array();
	}
}

function removeAdmin($id) {
	try {
		$DBH = Configuration::getInstance()->getDBH();
		$query = $DBH->prepare("DELETE FROM admins where id = :id");

		$query->bindValue(":id", $id);

        $query->execute();
        return true;
    } catch (Exception $e) {

    	return false;
    }
}

function addAdmin($username, $password) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$STH = $DBH->prepare("INSERT INTO admins (username, password) value (:un, :p)");
		
		$STH->bindValue(":un", $username);
		$STH->bindValue(":p", $password);
		$STH->execute();
		return $DBH->lastInsertId('id');
	} catch (Exception $e) {
		return -1;
	}  	
}

function isAdmin($username, $password) {
	try {
		$DBH = Configuration::getInstance()->getDBH();

		$query = $DBH->prepare("SELECT username, password, id from admins where username=:e and password=:ps");
		$query->bindValue(":e", $username);
		$query->bindValue(":ps", $password);
        $query->execute();
    	
		while($row = $query->fetch()) {
		
		    if ($row['username']==$username && $row['password']==$password) 
		    	return $row['id'];
		}
		return -1;
	} catch (Exception $e) {
		return -1;
	}
}





//USELESSS ___--_-__--__--_--_--_-
function updatePipe($pipe) {
	try {
		
		$DBH = Configuration::getInstance()->getDBH();

		$STH = $DBH->prepare("UPDATE pipes SET brand_id = :bId,model = :m,shape_id = :sId,source = :s,price = :p,date_purchased = :dp,pipe_length = :pl,bowl_height = :bh,outside_diameter = :od,chamber_diameter = :cDiam,chamber_depth = :cDepth,weight = :w,notes = :n WHERE id=:id");
		$STH->bindValue(":id", $pipe->id);
		$STH->bindValue(":bId", $pipe->brandId);
		$STH->bindValue(":m", $pipe->model);
		$STH->bindValue(":sId", $pipe->shapeId);
		$STH->bindValue(":s", $pipe->source);
		$STH->bindValue(":p", $pipe->price);
		$STH->bindValue(":dp", $pipe->datePurchased);
		$STH->bindValue(":pl", $pipe->pipeLength);
		$STH->bindValue(":bh", $pipe->bowlHeight);
		$STH->bindValue(":od", $pipe->outsideDiameter);
		$STH->bindValue(":cDiam", $pipe->chamberDiameter);
		$STH->bindValue(":cDepth", $pipe->chamberDepth);
		$STH->bindValue(":w", $pipe->weight);
		$STH->bindValue(":n", $pipe->notes);

		//$STH->execute();
		return $DBH->lastInsertId('id');
	} catch (Exception $e) {
		echo ($e->getMessage());
		die();
		return -1;
	}  	
}


?>