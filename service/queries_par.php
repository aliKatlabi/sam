<?php




$admin_insert_setting = "INSERT INTO `submission_Table`(	`SubjectCode`	, 
												`SubjectName`	,
												`min`			,
												`max`			, 
												`startDate` 	,
												`deadLine`		) 
			VALUES (
					'$setting->subjectCode '		, 
					'$setting->subjectName' 		,	
					'$setting->grade_max'			,
					'$setting->grade_min'			,
					'$setting->submission_deadline'	,
					'$setting->submission_date'	
					)";

$admin_update_setting = "UPDATE `submission_Table` 
			 
			SET 
				SubjectName =	'$setting->get_subjectName()' 			,	
				min 		=	'$setting->get_grade_max()'				,
				max 		=	'$setting->get_grade_min()'				,
				deadLine 	=	'$setting->get_submission_date()'	
			
			WHERE SubjectCode = '$setting->get_subjectCode()' ";


///// USER

			
			
?>